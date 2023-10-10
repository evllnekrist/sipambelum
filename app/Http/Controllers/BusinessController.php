<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Business;
use DB;

class BusinessController extends Controller
{
    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start
    public function user_index()
    {
        $data['items'] = Business::get();
        return view('pages.business', $data);
    }

    public function user_detail($id)
    {
        $data['selected'] = Business::find($id);
        if ($data['selected']) {
            // Tambahkan logika tampilan detail bisnis di sini
        } else {
            return $this->show_error_user('Business');
        }
    }
    public function getBusinessById($id)
    {
        $business = Business::find($id);
    
        return response()->json($business);
    }
    public function admin_index()
    {
        return view('pages-admin.business.index');
    }

    public function form_add()
    {
        $data = array();
        return view('pages-admin.business.add', $data);
    }

    public function form_edit($id)
    {
        $data['selected'] = Business::find($id);
        if ($data['selected']) {
            return view('pages-admin.business.edit', $data);
        } else {
            return $this->show_error_admin('Business');
        }
    }
    // -------------------------------------- VIEW -------------------------------------- end

    // -------------------------------------- CALLED BY AJAX ---------------------------- start
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
            $data = Business::orderBy('created_at', 'desc')->limit($request->page_size)->get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }

    public function get_listfull(Request $request)
    {
        try {
            $data = Business::orderBy('created_at', 'desc')->get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }

    public function post_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nib'  => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'address' => 'nullable|string|max:255',
            'subdistrict' => 'nullable|integer',
            'date_of_establishment' => 'nullable|date',
            'initial_business_capital' => 'nullable|numeric',
            'revenue' => 'nullable|numeric',
            'digitalization' => 'required|string|max:50',
            'employees_count' => 'nullable|integer',
            'development_problems' => 'nullable|string',
            'training_needs' => 'nullable|string',
            'is_sales_transaction' => 'nullable|boolean',
            'is_access_to_funding' => 'nullable|boolean',
            'is_financial_report' => 'nullable|boolean',
            'is_business_account' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            // Tambahkan logika untuk menyimpan data bisnis di sini
            $output = Business::create($data);
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
            'nib'  => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'address' => 'nullable|string|max:255',
            'subdistrict' => 'nullable|integer',
            'date_of_establishment' => 'nullable|date',
            'initial_business_capital' => 'nullable|numeric',
            'revenue' => 'nullable|numeric',
            'digitalization' => 'required|string|max:50',
            'employees_count' => 'nullable|integer',
            'development_problems' => 'nullable|string',
            'training_needs' => 'nullable|string',
            'is_sales_transaction' => 'nullable|boolean',
            'is_access_to_funding' => 'nullable|boolean',
            'is_financial_report' => 'nullable|boolean',
            'is_business_account' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            // Tambahkan logika untuk mengedit data bisnis di sini
            $output = Business::where('id', $request->get('id'))->update($data);
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
            $output = Business::where('id', $id)->delete();
            DB::commit();
            return json_encode(array('status' => true, 'message' => 'Berhasil menghapus data', 'data' => $output));
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
