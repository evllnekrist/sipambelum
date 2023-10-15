<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LocalPotential;
use Illuminate\Support\Facades\Storage;
use DB;

class LocalPotentialController extends Controller
{
    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start

    public function admin_index()
    {
        return view('pages-admin.local-potential.index');
    }

    public function form_add()
    {
        return view('pages-admin.local-potential.add');
    }

    public function form_edit($id)
    {
        $data['selected'] = LocalPotential::find($id);
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
            $data = LocalPotential::all();
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

            $id = $data['id'];
            unset($data['id']);
            $output = LocalPotential::where('id', $id)->update($data);
            DB::commit();
            return json_encode(array('status'=>true, 'message'=>'Berhasil merubah data', 'data'=>$output));
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
