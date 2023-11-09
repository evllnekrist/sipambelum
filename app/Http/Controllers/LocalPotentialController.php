<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LocalPotential;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\Storage;
use DB;

class LocalPotentialController extends Controller
{
    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start
    public function user_index(Request $request)
    {
        $subdistricts = Subdistrict::all();
        $data['data_sorted_by'] = array(
            'latest'            => 'Paling Baru',
            'abc'               => 'Alfabet Judul A-Z',
            'abc-reverse'       => 'Alfabet Judul Z-A',
        );

        $query = LocalPotential::query();

        // Filter by name
        if ($request->has('_title') && !empty($request->_title)) {
            $query->where('name', 'like', '%' . $request->_title . '%');
        }

        // Filter by subdistrict
        if ($request->has('_subdistrict') && !empty($request->_subdistrict)) {
            $subdistrictId = $request->_subdistrict;
            $query->where('subdistrict', $subdistrictId);
        }

        // Count data
        $totalItems = $query->count();

        // Pagination
        $page = $request->has('_page') ? $request->_page : 1;
        $pageSize = 10;
        $skip = ($page - 1) * $pageSize;
        $localPotentials = $query->skip($skip)->take($pageSize)->get();

        $data['local_potentials'] = $localPotentials;
        $data['totalItems'] = $totalItems;
        $data['subdistricts'] = $subdistricts;
        $data['currentPage'] = $page;
        $data['pageSize'] = $pageSize;

        return view('pages.local_potential', $data);
    }
    public function admin_index()
    {
        return view('pages-admin.local-potential.index');
    }

    public function form_add()
    {
        $subdistricts = Subdistrict::all();
        return view('pages-admin.local-potential.add', compact('subdistricts'));
    }

    public function form_edit($id)
    {
        $data['selected'] = LocalPotential::find($id);
        $data['subdistricts'] = Subdistrict::all();
    
        if ($data['selected']) {
            return view('pages-admin.local-potential.edit', $data);
        } else {
            $error_details = array(
                'title' => 'Oops!',
                'desc' => 'Local Potential dengan ID yang Anda cari tidak ditemukan.'
            );
            return view('pages-admin.error.404', $error_details);
        }
    }

    

    // -------------------------------------- VIEW -------------------------------------- end

    // -------------------------------------- CALLED BY AJAX ---------------------------- start

    public function get_list(Request $request)
{
    try {
        $data = LocalPotential::with('subdistrict')->get();
        return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
    } catch (\Exception $e) {
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}

    public function post_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img_main'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name'      => 'required|string|max:50',
            'desc'      => 'nullable|string',
            'url_link'  => 'nullable|string',
            'active'    => 'boolean',
            'subdistrict' => 'array',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            if($request->hasFile('img_main')) {
                $file = $request->file('img_main');
                $filename = 'img_main_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/assets/img/localpotential', $filename);
                $data['img_main'] = $filename;
            }

            // Jika 'active' tidak ada di request, setel nilai default ke 1 (aktif)
            $data['active'] = isset($data['active']) ? $data['active'] : 1;

            $output = LocalPotential::create($data);
            DB::commit();
            return json_encode(array('status'=>true, 'message'=>'Berhasil menyimpan data', 'data'=>$output));
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
        }
    }

    public function post_edit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'      => 'required|string|max:50',
        'desc'      => 'nullable|string',
        'url_link'  => 'nullable|string',
        'active'    => 'boolean',
        'subdistrict' => 'array', // Ensure subdistrict is an array
    ]);

    if ($validator->fails()) {
        return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
    }

    DB::beginTransaction();
    try {
        $data = $request->except(['id', 'img_main', '_token', 'subdistrict']); // Exclude unnecessary fields
        $id = $request->input('id');

        // Convert array of subdistrict IDs to comma-separated string
        if ($request->has('subdistrict') && is_array($request->input('subdistrict'))) {
            $data['id_subdistrict'] = implode(',', $request->input('subdistrict'));
        } else {
            $data['id_subdistrict'] = '';
        }

        if ($request->hasFile('img_main')) {
            $file = $request->file('img_main');
            $filename = 'img_main_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/assets/img/localpotential', $filename);
            $data['img_main'] = $filename;
        }

        // Set 'active' default value to 1 if not provided in the request
        $data['active'] = isset($data['active']) ? $data['active'] : 1;

        // Update LocalPotential record using update method on the found instance
        $localPotential = LocalPotential::find($id);
        $localPotential->update($data);

        // Update associated subdistricts
        $localPotential->subdistricts()->sync($request->input('subdistrict'));

        DB::commit();

        // Redirect to a specific route after successful update
        return json_encode(array('status'=>true, 'message'=>'Berhasil merubah data', 'data'=>null));
    } catch (\Exception $e) {
        DB::rollback();
        return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
    }
}

    public function post_delete($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
        }

        DB::beginTransaction();
        try {
            $output = LocalPotential::where('id', $id)->delete();
            DB::commit();
            return json_encode(array('status'=>true, 'message'=>'Berhasil menghapus data', 'data'=>$output));
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
        }
    }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
