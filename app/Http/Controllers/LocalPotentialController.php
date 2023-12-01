<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LocalPotential;
use App\Models\Subdistrict;
use App\Models\Subdistrict_LocalPotential;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
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
            'latest' => 'Paling Baru',
            'abc' => 'Alfabet Judul A-Z',
            'abc-reverse' => 'Alfabet Judul Z-A',
        );
    
        $query = LocalPotential::where('active', 1);
    
        // Filter by name
        if ($request->has('_title') && !empty($request->_title)) {
            $query->where('name', 'like', '%' . $request->_title . '%');
        }
    
         // Filter by subdistrict
         if ($request->has('_subdistrict') && !empty($request->_subdistrict)) {
            $subdistrictId = $request->_subdistrict;
            $query->whereHas('subdistricts', function ($q) use ($subdistrictId) {
                $q->where('ms_subdistrict.id', $subdistrictId);
            });
            
        }
        $totalItems = $query->count(); 
        // Paginate the results
        $page = $request->has('_page') ? $request->_page : 1;
        $pageSize = 9;
        $localPotentials = $query->with('subdistricts')->paginate($pageSize);
    
        $data['local_potentials'] = $localPotentials;
        $data['subdistricts'] = $subdistricts;
        $data['totalItems'] = $totalItems;
        $data['currentPage'] = $page;
        $data['pageSize'] = $pageSize;
    
        return view('pages.local_potential', $data);
    }
    
    public function search(Request $request)
    {
        $subdistricts = Subdistrict::all();
        $data['data_sorted_by'] = array(
            'latest'       => 'Paling Baru',
            'abc'          => 'Alfabet Judul A-Z',
            'abc-reverse'  => 'Alfabet Judul Z-A',
        );
    
        $query = LocalPotential::where('active', 1);
    
        // Filter by name
        if ($request->has('_title') && !empty($request->_title)) {
            $query->where('name', 'like', '%' . $request->_title . '%');
        }
    
        // Filter by subdistrict
        if ($request->has('_subdistrict') && !empty($request->_subdistrict)) {
            $subdistrictId = $request->_subdistrict;
            $query->whereHas('subdistricts', function ($q) use ($subdistrictId) {
                $q->where('ms_subdistrict.id', $subdistrictId);
            });
            
        }
    
        // Count data
        $totalItems = $query->count();
    
        // Paginate the results
        $page = $request->has('_page') ? $request->_page : 1;
        $pageSize = 9;
        $localPotentials = $query->with('subdistricts')->paginate($pageSize);
    
        $data['local_potentials'] = $localPotentials;
        $data['subdistricts'] = $subdistricts;
        $data['totalItems'] = $totalItems;
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
        $localPotentials = LocalPotential::with('subdistricts')->get();
        return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $localPotentials));
    } catch (\Exception $e) {
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}
public function post_add(Request $request)
{
    $validator = Validator::make($request->all(), [
        'img_main'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name'        => 'required|string|max:50',
        'desc'        => 'nullable|string',
        'url_link'    => 'nullable|string',
        'active'      => 'boolean',
        'subdistricts' => 'array', // Ubah 'subdistrict' menjadi 'subdistricts' agar sesuai dengan form HTML
    ]);

    if ($validator->fails()) {
        return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
    }

    DB::beginTransaction();
    try {
        $data = $request->all();
        if ($request->hasFile('img_main')) {
            $file = $request->file('img_main');
            $filename = 'img_main_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/assets/img/localpotential', $filename);
            $data['img_main'] = $filename;
        }

        // Jika 'active' tidak ada di request, setel nilai default ke 1 (aktif)
        $data['active'] = isset($data['active']) ? $data['active'] : 1;

        // Tambahkan record baru ke tabel local_potentials
        $localPotential = LocalPotential::create($data);

        // Tambahkan record ke tabel map_subdistrict_local_potential
        if (!empty($data['subdistricts'])) {
            $subdistricts = $data['subdistricts'];

            // Cek apakah 'all' ada di dalam array subdistricts
            if (in_array('all', $subdistricts)) {
                // Ambil ID subdistricts yang terkait dengan local potential
                $subdistrictIds = Subdistrict_LocalPotential::where('id_local_potential', $localPotential->id)
                    ->pluck('id_subdistrict')
                    ->toArray();

                // Periksa apakah ada lebih dari satu ID subdistrict
                if (!(sizeof($subdistrictIds) > 1)) {
                    DB::rollBack();
                    return json_encode(array('status' => false, 'message' => 'Tidak dapat menyimpan. Potensi lokal yang Anda pilih belum dimiliki oleh kecamatan manapun!'));
                }

                // Ubah array subdistricts menjadi string dengan koma
                $data['subdistricts'] = implode(",", $subdistrictIds);
            } else {
                // Jika 'all' tidak ada di dalam array, ubah array subdistricts menjadi string dengan koma
                $data['subdistricts'] = implode(",", $subdistricts);

                // Tambahkan record baru ke tabel map_subdistrict_local_potential
                foreach ($subdistricts as $subdistrictId) {
                    Subdistrict_LocalPotential::create([
                        'id_local_potential' => $localPotential->id,
                        'id_subdistrict' => $subdistrictId,
                        // Tambahkan kolom timestamp dan lainnya sesuai kebutuhan
                    ]);
                }
            }
        }

        DB::commit();
        return json_encode(array('status' => true, 'message' => 'Berhasil menyimpan data', 'data' => $localPotential));
    } catch (\Exception $e) {
        DB::rollBack();
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}

public function post_edit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'        => 'required|string|max:50',
        'desc'        => 'nullable|string',
        'url_link'    => 'nullable|string',
        'active'      => 'boolean',
        'subdistricts' => 'array', // Ensure subdistricts is an array
    ]);

    if ($validator->fails()) {
        return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
    }

    DB::beginTransaction();
    try {
        $data = $request->except(['id', 'img_main', '_token', 'subdistricts']); // Exclude unnecessary fields
        $id = $request->input('id');

        // Convert array of subdistrict IDs to comma-separated string
        if ($request->has('subdistricts') && is_array($request->input('subdistricts'))) {
            $data['id_subdistrict'] = implode(',', $request->input('subdistricts'));
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
        $localPotential->subdistricts()->sync($request->input('subdistricts'));

        DB::commit();

        // Redirect to a specific route after successful update
        return json_encode(array('status' => true, 'message' => 'Berhasil merubah data', 'data' => null));
    } catch (\Exception $e) {
        DB::rollback();
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
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
        // Hapus record dari tabel LocalPotential
        $localPotential = LocalPotential::find($id);
        if (!$localPotential) {
            throw new \Exception('Data tidak ditemukan');
        }

        // Hapus record dari tabel Subdistrict_LocalPotential
        Subdistrict_LocalPotential::where('id_local_potential', $localPotential->id)->delete();

        // Hapus record dari tabel LocalPotential
        $localPotential->delete();

        DB::commit();
        return json_encode(array('status'=>true, 'message'=>'Berhasil menghapus data', 'data'=>null));
    } catch (\Exception $e) {
        DB::rollback();
        return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
    }
}

    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
