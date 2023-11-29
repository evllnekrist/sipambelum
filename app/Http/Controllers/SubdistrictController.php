<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subdistrict;
use DB;

class SubdistrictController extends Controller
{
    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start


    public function admin_index()
    {
        $data['items'] = Subdistrict::get();
        return view('pages-admin.subdistrict.index', $data);
    }

    public function form_add()
    {
        $data = array();
        return view('pages-admin.subdistrict.add', $data);
    }

    public function form_edit($id)
    {
        $data['selected'] = Subdistrict::find($id);
        if ($data['selected']) {
            return view('pages-admin.subdistrict.edit', $data);
        } else {
            // Handle error if subdistrict with given ID is not found
        }
    }
    // -------------------------------------- VIEW -------------------------------------- end

    // -------------------------------------- CALLED BY AJAX ---------------------------- start
    public function getSubdistrictNameById($id)
    {
        $subdistrict = Subdistrict::find($id);

        if ($subdistrict) {
            return response()->json(['name' => $subdistrict->name]);
        } else {
            return response()->json(['name' => 'Not Found'], 404);
        }
    }
    public function get_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required',
            'page_size' => 'required',
        ]);
        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        try {
            $data = Subdistrict::orderBy('created_at', 'desc')->get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }

    public function post_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'active' => 'required|boolean',
            // Add other validation rules here
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $output = Subdistrict::create($data);
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
            'id' => 'required|integer',
            'name' => 'required|string|max:50',
            'active' => 'required|boolean',
            // Add other validation rules here
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $output = Subdistrict::where('id', $request->get('id'))->update($data);
            DB::commit();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengubah data', 'data' => $output));
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

        DB::beginTransaction();
        try {
            $output = Subdistrict::where('id', $id)->delete();
            DB::commit();
            return json_encode(array('status' => true, 'message' => 'Berhasil menghapus data', 'data' => $output));
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
