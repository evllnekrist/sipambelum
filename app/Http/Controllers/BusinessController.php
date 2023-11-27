<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Business;
use App\Models\Trainee;
use App\Models\LocalPotential;
use App\Models\Option;
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
        $business = Business::with('localPotential')->find($id);
    
        return response()->json($business);
    }
    public function getLocalPotentialName($id)
    {
        $localPotential = LocalPotential::find($id);

        return response()->json(['name' => $localPotential->name]);
    }

    public function admin_index()
{
    try {
        // Mengambil data dari tabel map_trainee_business dengan menyertakan relasi business dan localPotential
        $data['items'] = MapTraineeBusiness::with(['business.localPotential'])->get();
        
        return view('pages-admin.business.index', $data);
    } catch (\Exception $e) {
        return $this->show_error_admin('Business');
    }
}
 
    public function form_add()
    {
        $data = array();
        $subdistricts = Subdistrict::all();
        
        // Menambahkan data local_potential ke dalam array data
        $localPotentials = LocalPotential::all();
        
        return view('pages-admin.business.add', compact('subdistricts', 'localPotentials'), $data);
    }

    public function form_edit($id)
    {
        $data['selected'] = Business::find($id);
        $data['subdistricts'] = Subdistrict::all();
        $data['localPotentials'] = LocalPotential::all(); 
    
        if ($data['selected']) {
            return view('pages-admin.business.edit', $data);
        } else {
            return $this->show_error_admin('Business');
        }
    }
    public function form_edit_trainees($id)
    {
        $data['selected'] = Business::with('trainees')->find($id);
        $data['subdistricts'] = Subdistrict::get();
        $data['trainees'] = MapTraineeBusiness::with('trainee')
                              ->select('map_trainee_business.*', 'map_trainee_business.job_title') 
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
            $data = Business::with(['subdistrict', 'localPotential'])->orderBy('created_at', 'desc')->limit($request->page_size)->get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    
    public function get_listfull(Request $request)
{
    try {
        $data = Business::with(['subdistrict', 'trainees', 'localPotential'])->orderBy('created_at', 'DESC')->get();
        
        // Modify the data to include the local potential name
        $data = $data->map(function ($business) {
            $business->localPotentialName = $business->localPotential ? $business->localPotential->name : '';
            return $business;
        });

        return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
    } catch (Exception $e) {
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}

    



    public function post_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nib'  => 'required|string|max:20',
            'id_local_potential'  => 'required|string|max:20',
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
            'id_local_potential'  => 'required|string|max:20',
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
    protected static $TABLE_MS_TRAINEE = 'ms_trainee';
    public function post_edit_trainee($id, Request $request)
{
  
    $validator = Validator::make($request->all(), [
        'trainees_new' => 'array',
        'trainees_to_delete' => 'array',
        'trainees_approved' => 'array',
        'trainees_approved_not' => 'array',
        'trainees_job_titles' => 'array',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => $validator->messages()->first(), 'data' => null], 400);
    }

    DB::beginTransaction();

    try {
        $output = [];
        $data = $request->all();

        // Ambil informasi kecamatan dari bisnis
        $business = Business::find($id);
        $businessSubdistrict = $business->subdistrict; // Sesuaikan ini berdasarkan model dan relasi yang sebenarnya

  
          // 1__create or not if exist 
          if($data['trainees_new']){
            $data['trainees'] = array_diff($data['trainees_new'],$data['trainees_to_delete']);
            $output['trainees'] = [];
            foreach ($data['trainees'] as $key => $value) {
              $output['trainees'][$value] = MapTraineeBusiness::firstOrCreate(
                ['id_business'=>$id, 'id_trainee'=>$value]
              );
            }
          }
          // 2__delete
          if($data['trainees_to_delete']){
            $output['trainees_to_delete'] = [];
            foreach ($data['trainees_to_delete'] as $key => $value) {
              $output['trainees_to_delete'][$value] = MapTraineeBusiness::where('id_business', $id)->where('id_trainee', $value)->delete();
            }
          } 
          // 3__update
          if($data['trainees_approved']){
            $output['trainees_approved'] = [];
            foreach ($data['trainees_approved'] as $key => $value) {
              $output['trainees_approved'][$value] = MapTraineeBusiness::where('id_business', $id)->where('id_trainee', $value)->update(['active'=>true]);
            }
          } 
          if($data['trainees_approved_not']){
            $output['trainees_approved_not'] = [];
            foreach ($data['trainees_approved_not'] as $key => $value) {
              $output['trainees_approved_not'][$value] = MapTraineeBusiness::where('id_business', $id)->where('id_trainee', $value)->update(['active'=>false]);
            }
          } 
          if ($data['trainees_job_titles']) {
            $output['trainees_job_titles'] = [];
            foreach ($data['trainees_job_titles'] as $traineeId => $jobTitle) {
                $output['trainees_job_titles'][$traineeId] = MapTraineeBusiness::where('id_business', $id)
                    ->where('id_trainee', $traineeId)
                    ->update(['job_title' => $jobTitle]);
            }
        }
        if ($data['trainees_new']) {
            $data['trainees'] = array_diff($data['trainees_new'], $data['trainees_to_delete']);
            $output['trainees'] = [];

            foreach ($data['trainees'] as $key => $value) {
                $output['trainees'][$value] = MapTraineeBusiness::firstOrCreate(
                    ['id_business' => $id, 'id_trainee' => $value]
                );

                // Perbarui subdistrict_of_residence di ms_trainee
                DB::table(self::$TABLE_MS_TRAINEE)
                ->where('id', $value)
                ->update(['subdistrict_of_residence' => $businessSubdistrict]);
        }
        }
        DB::commit();
        return response()->json(['status' => true, 'message' => 'Berhasil merubah data', 'data' => $output], 200);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null]);
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
        // Hapus data dari tabel map_trainee_business terlebih dahulu
        MapTraineeBusiness::where('id_business', $id)->delete();

        // Hapus bisnis
        $output = Business::where('id', $id)->delete();

        // Selanjutnya, jika perlu, Anda dapat memperbarui kolom subdistrict pada ms_trainee menjadi kosong
        // Jangan lupa sesuaikan nama kolom dan nilai yang sesuai
        Trainee::where('subdistrict_of_residence', $id)->update(['subdistrict_of_residence' => null]);

        DB::commit();

        return json_encode(array('status' => true, 'message' => 'Berhasil menghapus data', 'data' => $output));
    } catch (\Exception $e) {
        DB::rollback();
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}

    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
