<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Business;
use App\Models\Trainee;
use App\Models\Subdistrict;
use App\Models\MapTraineeBusiness;
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
    public function getSubdistrictList()
    {
        $subdistricts = Subdistrict::select('id', 'name')->get();
        return response()->json(['status' => true, 'data' => $subdistricts]);
    }
    public function getBasicList(Request $request)
{
    try {
        $data = Trainee::select('nik', 'name')->get();
        return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
    } catch (\Exception $e) {
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}
public function mapToBusiness(Request $request)
{
    try {
        // Ambil data dari request
        $businessId = $request->input('businessId');
        $trainees = $request->input('trainees');

        // Simpan data mapping trainee ke bisnis
        foreach ($trainees as $traineeId) {
            // Periksa apakah trainee sudah ada dalam mapping (berdasarkan id_trainee dan id_business)
            $existingMapping = MapTraineeBusiness::where('id_trainee', $traineeId)
                ->where('id_business', $businessId)
                ->first();

            // Jika mapping sudah ada, perbarui nilai active menjadi 1
            // Jika mapping belum ada, buat mapping baru dengan active 1
            if ($existingMapping) {
                $existingMapping->update(['active' => 1]);
            } else {
                MapTraineeBusiness::create([
                    'id_business' => $businessId,
                    'id_trainee' => $traineeId,
                    'active' => 1, // Set active menjadi 1
                    // Tambahan kolom lainnya jika ada
                ]);
            }
        }

        return response()->json(['status' => true, 'message' => 'Mapping trainees to business successful']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()]);
    }
}

    public function getBusinessById($id)
    {
        $business = Business::find($id);
    
        return response()->json($business);
    }
    public function admin_index()
    {
        try {
            // Mengambil data dari tabel map_trainee_business
            $data['items'] = MapTraineeBusiness::get();
            return view('pages-admin.business.index', $data);
        } catch (\Exception $e) {
            return $this->show_error_admin('Business');
        }
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
    public function form_edit_trainees($id)
{
    $data['selected'] = MapTraineeBusiness::with('trainee')->find($id);
    $data['subdistricts'] = Subdistrict::get();
    $data['trainees'] = MapTraineeBusiness::with('trainee')
                          ->select('map_trainee_business.*', 'map_trainee_business.job_title') // Menyertakan kolom job_title
                          ->where('id_business', $id)
                          ->get();

    if ($data['selected']) {
        return view('pages-admin.business.edit-trainee', $data);
    } else {
        return $this->show_error_admin('Trainee');
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
        // Mengambil data Business dengan menyertakan relasi subdistrict
        $data = Business::with('subdistrict')->orderBy('created_at', 'desc')->limit($request->page_size)->get();
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
