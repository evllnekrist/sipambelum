<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Option;
use App\Models\Training;
use DB;

class TrainingController extends Controller
{

  public function __construct()
  {}

  // -------------------------------------- VIEW -------------------------------------- start
  public function user_index()
  {
    $data['items'] = Training::get();
    return view('pages.training', $data);
  }
  
  public function user_detail($slug)
  {
      $data['selected'] = Training::where('slug',$slug)->first();
      if($data['selected']){
        $data['training'] = Training::orderBy('created_at', 'desc')->skip(0)->take(5)->get();
        return view('pages.training-detail', $data);
      }else{
        return $this->show_error_user('Berita');
      }
  }

  public function admin_index()
  {
    return view('pages-admin.training.index');
  }

  public function form_add()
  {
    $data = array();
    return view('pages-admin.training.add', $data);
  }
  
  public function form_edit($id)
  {
    $data['selected'] = Training::find($id);
    if($data['selected']){
      return view('pages-admin.training.edit', $data);
    }else{
      return $this->show_error_admin('Berita');
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
        return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
      }
      
      try {
        $data = Training::orderBy('event_start','DESC')->limit($request->page_size)->get();
        return json_encode(array('status'=>true, 'message'=>'Berhasil mengambil data', 'data'=>$data));
      } catch (Exception $e) {
        return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
      }
  }
  public function get_listfull(Request $request)
  {
    try {
      $data = Training::orderBy('created_at', 'DESC')->get();
      return json_encode(array('status'=>true, 'message'=>'Berhasil mengambil data', 'data'=>$data));
    } catch (Exception $e) {
      return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
    }
  }
  public function post_add(Request $request)
  {
      $validator = Validator::make($request->all(), [
        'img_main'  => 'required',
        'name'      => 'required',
      ]); 
      if ($validator->fails()) {
        // return redirect()->back()->withInput();
        return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
      }

      DB::beginTransaction();
      try {
        $data = $request->all(); 
        $default_folder = 'training/'; 
        $file_indexes = array('img_main');
        foreach ($file_indexes as $index){ // https://laracasts.com/discuss/channels/laravel/how-direct-upload-file-in-storage-folder
          if($request->file($index)){
            // Get filename with the extension
            $filename_with_ext = $request->file($index)->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file($index)->getClientOriginalExtension();
            // Filename to store
            $filename_to_store = $index.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file($index)->storeAs('public/'.$default_folder.($index=='file_main'?'file':'image'),$filename_to_store);
            $data[$index] = '/storage//'.$default_folder.($index=='file_main'?'file':'image')."//".$filename_to_store;
          }else{
            unset($data[$index]);
          }
        }
        $data['keywords'] = isset($data['keywords'])?implode(',',$data['keywords']):'';
        $output = Training::create($data);
        DB::commit();
        return json_encode(array('status'=>true, 'message'=>'Berhasil menyimpan data', 'data'=>$output));
      } catch (Exception $e) {
        DB::rollback();
        return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
      }
  }
  public function post_edit(Request $request)
  {
      $validator = Validator::make($request->all(), [
        // 'img_main'  => 'required',
        'name'      => 'required',
      ]); 
      if ($validator->fails()) {
        // return redirect()->back()->withInput();
        return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
      }
      
      DB::beginTransaction();
      try {
        $data = $request->all();
        $default_folder = 'training/'; 
        $file_indexes = array('img_main');
        foreach ($file_indexes as $index){ // https://laracasts.com/discuss/channels/laravel/how-direct-upload-file-in-storage-folder
          if($request->file($index)){
            // Get filename with the extension
            $filename_with_ext = $request->file($index)->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file($index)->getClientOriginalExtension();
            // Filename to store
            $filename_to_store = $index.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file($index)->storeAs('public/'.$default_folder.($index=='file_main'?'file':'image'),$filename_to_store);
            $data[$index] = '/storage//'.$default_folder.($index=='file_main'?'file':'image')."//".$filename_to_store;
          }else{
            unset($data[$index]);
          }
        }
        unset($data['id']);
        if(isset($data['files'])){
          unset($data['files']);
        }
        $data['keywords'] = isset($data['keywords'])?implode(',',$data['keywords']):'';
        $output = Training::where('id',$request->get('id'))->update($data);
        DB::commit();
        return json_encode(array('status'=>true, 'message'=>'Berhasil menrubah data', 'data'=>$output));
      } catch (Exception $e) {
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
        // return redirect()->back()->withInput();
        return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
      }

      DB::beginTransaction();
      try {
        $output = Training::where('id', $id)->delete();
        DB::commit();
        return json_encode(array('status'=>true, 'message'=>'Berhasil menghapus data', 'data'=>$output));
      } catch (Exception $e) {
        DB::rollback();
        return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
      }
  }
// -------------------------------------- CALLED BY AJAX ---------------------------- end
}