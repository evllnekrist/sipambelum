<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\DB;

class TraineeController extends Controller
{
    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start
     

    // TraineeController.php

public function user_index(Request $request)
{
    $nik = $request->input('nik');

    $traineesQuery = Trainee::with('trainingHistory')
        ->join('ms_subdistrict', 'ms_trainee.subdistrict_of_residence', '=', 'ms_subdistrict.id')
        ->select('ms_trainee.id','ms_trainee.nik', 'ms_trainee.name', 'ms_trainee.phone', 'ms_trainee.email', 'ms_subdistrict.name as subdistrict_name');

    if (!empty($nik)) {
        $traineesQuery->where('ms_trainee.nik', $nik);
    } else {
        return view('pages.trainee');
    }

    $trainees = $traineesQuery->get();

    if (count($trainees) > 0) {
        $data['trainees'] = $trainees;
        return view('pages.trainee', $data)->with('success', 'Pencarian berhasil ditemukan.');
    } else {
        return redirect()->route('user.trainee')->with('message', 'Tidak ada hasil pencarian.');
    }
}

public function getTrainingHistory(Request $request)
{
    $idTrainee = $request->input('id_trainee');

    $trainingHistory = DB::table('map_trainee_training')
        ->join('tr_training', 'map_trainee_training.id_training', '=', 'tr_training.id')
        ->select('tr_training.name as training_name', 'map_trainee_training.active', 'map_trainee_training.is_passed')
        ->where('map_trainee_training.id_trainee', $idTrainee)
        ->get();

    return response()->json($trainingHistory);
}
public function getBusinessHistory(Request $request)
{
    $idTrainee = $request->input('id_trainee');

    $businessHistory = DB::table('map_trainee_business')
        ->leftJoin('ms_business', 'map_trainee_business.id_business', '=', 'ms_business.id')
        ->select('ms_business.name as business_name', 'map_trainee_business.job_title', 'map_trainee_business.active')
        ->where('map_trainee_business.id_trainee', $idTrainee)
        ->get();

    return response()->json($businessHistory);
}
    

    public function getSubdistrictList()
{
    $subdistricts = Subdistrict::select('id', 'name')->get();
    return response()->json(['status' => true, 'data' => $subdistricts]);
}
public function getBasicList(Request $request)
{
    try {
        $data = Trainee::select('id', 'nik', 'name')->get();
        return response()->json(['status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null]);
    }
    }

    // TraineeController.php

    public function admin_index()
    {
        return view('pages-admin.trainee.index');
    }

    public function form_add()
    {
        $subdistricts = Subdistrict::all();
        return view('pages-admin.trainee.add', compact('subdistricts'));
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
        $data['subdistricts'] = Subdistrict::all();
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
            // Mengambil data trainee dan menggabungkannya dengan data subdistrict
            $data = Trainee::with('subdistrict')->get();

            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    public function get_list_adv(Request $request)
    {
        try {
            $data['products'] = Trainee::with('subdistrict')->with('businessHistory')->with('trainingHistory');
            if($request->get('_search')){
                $data['products'] = $data['products']->where(function($q) use ($request) {
                    $q->where('name','like','%'.$request->get('_search').'%')
                        ->orWhere('nik','like','%'.$request->get('_search').'%');
                });
            }
            if($request->get('_subdistrict')){
                $data['products'] = $data['products']->where('subdistrict_of_residence',$request->get('_subdistrict'));
            }
            if($request->get('_level')){
                $data['products'] = $data['products']->where('level',$request->get('_level'));
            }
            $data['products'] = $data['products']->get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    public function get_list_tb(Request $request)
    {
        try {
            $data['products'] = Trainee::with('subdistrict')->with('businessHistory');
            if($request->get('_search')){
                $data['products'] = $data['products']->where(function($q) use ($request) {
                    $q->where('name','like','%'.$request->get('_search').'%')
                        ->orWhere('nik','like','%'.$request->get('_search').'%');
                });
            }
            if($request->get('_subdistrict')){
                $data['products'] = $data['products']->where('subdistrict_of_residence',$request->get('_subdistrict'));
            }
            
            $data['products'] = $data['products']->get();
            return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
        } catch (\Exception $e) {
            return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
        }
    }
    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
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
