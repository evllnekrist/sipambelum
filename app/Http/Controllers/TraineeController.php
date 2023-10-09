<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Trainee;
use DB;

class TraineeController extends Controller
{
    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start
    public function admin_index()
    {
        return view('pages-admin.trainee.index');
    }

    public function form_add()
    {
        return view('pages-admin.trainee.add');
    }

    public function checkNik(Request $request)
    {
        // Ambil nilai NIK dari request
        $nik = $request->input('nik');

        // Cek apakah NIK sudah terdaftar
        $trainee = Trainee::where('nik', $nik)->first();

        // Jika NIK sudah terdaftar, kirim respons dengan status true
        // Jika NIK belum terdaftar, kirim respons dengan status false
        return response()->json(['status' => $trainee ? true : false]);
    }


    public function form_edit($id)
    {
        $data['selected'] = Trainee::find($id);
        if ($data['selected']) {
            return view('pages-admin.trainee.edit', $data);
        } else {
            $error_details = array(
                'title' => 'Oops!',
                'desc' => 'Trainee dengan ID yang Anda cari tidak ditemukan.'
            );
            return view('pages-admin.error.404', $error_details);
        }
    }
    // -------------------------------------- VIEW -------------------------------------- end

    // -------------------------------------- CALLED BY AJAX ---------------------------- start
    public function get_list(Request $request)
    {
        try {
            $data = Trainee::get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }

    public function post_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:10',
            'sex' => 'nullable|string|max:2',
            'religion' => 'nullable|string|max:20',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'latest_edu' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'subdistrict_of_residence' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $output = Trainee::create($data);
            DB::commit();
            return json_encode(array('status' => true, 'message' => 'Berhasil menyimpan data', 'data' => $output));
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }

    public function post_edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:10',
            'sex' => 'nullable|string|max:2',
            'religion' => 'nullable|string|max:20',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'latest_edu' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'subdistrict_of_residence' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            unset($data['id']); // Hapus ID dari data agar tidak diupdate
            $output = Trainee::where('id', $request->get('id'))->update($data);
            DB::commit();
            return json_encode(array('status' => true, 'message' => 'Berhasil merubah data', 'data' => $output));
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }

    public function post_delete($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        try {
            $output = Trainee::where('id', $id)->delete();
            return json_encode(array('status' => true, 'message' => 'Berhasil menghapus data', 'data' => $output));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
