<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Config;
use DB;

class ConfigController extends Controller
{
  // -------------------------------------- VIEW -------------------------------------- start
  public function index()
  {
    $data['items'] = Config::get();
    return view('pages.config', $data);
  }
  public function admin_index()
  {
    return view('pages-admin.config.index');
  }

  public function form_add()
  {
    $data = array();
    return view('pages-admin.config.add', $data);
  }

  public function form_edit($code)
  {
      $data['selected'] = Config::where('code', $code)->first();
  
      if ($data['selected']) {
          return view('pages-admin.config.edit', $data);
      } else {
          return $this->show_error_admin('Config');
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
      $data = Config::limit($request->page_size)->get();
      return json_encode(array('status' => true, 'message' => 'Berhasil mengambil data', 'data' => $data));
    } catch (Exception $e) {
      return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
  }
  public function get_listfull(Request $request)
  {
    try {
      $data = Config::orderBy('created_at', 'DESC')->get();
      return json_encode(array('status'=>true, 'message'=>'Berhasil mengambil data', 'data'=>$data));
    } catch (Exception $e) {
      return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
    }
  }
  public function post_add(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'code' => 'required',
          'value' => 'required',
          'img_main' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add this line for image validation
      ]);
  
      if ($validator->fails()) {
          return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
      }
  
      DB::beginTransaction();
      try {
          $data = $request->all();
          
          // Validate and store the image
          if ($request->file('img_main')) {
              $imagePath = $request->file('img_main')->store('public/images'); // Adjust the storage path as needed
              $data['img_main'] = asset(str_replace('public', 'storage', $imagePath));
          }
  
          $output = Config::create($data);
          DB::commit();
          return json_encode(array('status' => true, 'message' => 'Berhasil menyimpan data', 'data' => $output));
      } catch (Exception $e) {
          DB::rollback();
          return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
      }
  }
  
  public function post_edit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'code' => 'required',
        'value' => 'required',
        'img_main' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add this line for image validation
    ]);

    if ($validator->fails()) {
        return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
    }

    DB::beginTransaction();
    try {
        $data = $request->all();
        unset($data['code']); // Ganti 'id' menjadi 'code'

        // Validate and store the image
        if ($request->file('img_main')) {
            $imagePath = $request->file('img_main')->store('public/images'); // Adjust the storage path as needed
            $data['img_main'] = asset(str_replace('public', 'storage', $imagePath));
        }

        $output = Config::where('code', $request->get('code'))->update($data); // Ganti 'id' menjadi 'code'
        DB::commit();
        return json_encode(array('status' => true, 'message' => 'Berhasil merubah data', 'data' => $output));
    } catch (Exception $e) {
        DB::rollback();
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}

public function post_delete($code)
{
    $validator = Validator::make(['code' => $code], [
        'code' => 'required',
    ]);

    if ($validator->fails()) {
        return json_encode(array('status' => false, 'message' => $validator->messages()->first(), 'data' => null));
    }

    DB::beginTransaction();
    try {
        $output = Config::where('code', $code)->delete(); // Pastikan 'code' sesuai dengan kolom primary key yang benar
        DB::commit();
        return json_encode(array('status' => true, 'message' => 'Berhasil menghapus data', 'data' => $output));
    } catch (Exception $e) {
        DB::rollback();
        return json_encode(array('status' => false, 'message' => $e->getMessage(), 'data' => null));
    }
}

  // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
