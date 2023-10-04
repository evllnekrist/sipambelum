<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
// use App\Models\SelectionList;
use App\Models\Banner;
use DB;

class BannerController extends Controller
{

    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start
      public function admin_index()
      {
        return view('pages-admin.banner.index');
      }
      public function form_add()
      {
        return view('pages-admin.banner.add');
      }
      public function form_edit($id)
      {
        // $data['selected'] = Banner::find(1001); // testing error page
        $data['selected'] = Banner::find($id);
        if($data['selected']){
          return view('pages-admin.banner.edit', $data);
        }else{
          $error_details = array(
            'title' => 'Oops!', 
            'desc' => 'Banner dengan ID yang Anda cari tidak ditemukan.'
          );
          return view('pages-admin.error.404', $error_details);
        }
      }
    // -------------------------------------- VIEW -------------------------------------- end

    // -------------------------------------- CALLED BY AJAX ---------------------------- start
      public function get_list(Request $request)
      {
        try {
          $data = Banner::get();
          return json_encode(array('status'=>true, 'message'=>'Berhasil mengambil data', 'data'=>$data));
        } catch (Exception $e) {
          return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
        }
      }
      public function post_add(Request $request)
      {
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'img_main' => 'required',
            'publish_start' => 'required',
          ]); 
          if ($validator->fails()) {
            // return redirect()->back()->withInput();
            return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
          }
          
          DB::beginTransaction();
          try {
            $data = $request->all();
            $data['publish_start'] = date("Y-m-d H:i:s", strtotime($data['publish_start'])); 
            $default_folder = 'banner/'; 
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
            $output = Banner::create($data);
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
            'name' => 'required',
            // 'img_main' => 'required',
            'publish_start' => 'required',
          ]); 
          if ($validator->fails()) {
            // return redirect()->back()->withInput();
            return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
          }
          
          DB::beginTransaction();
          try {
            $data = $request->all();
            $data['publish_start'] = date("Y-m-d H:i:s", strtotime($data['publish_start'])); 
            $default_folder = 'banner/'; 
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
            $output = Banner::where('id',$request->get('id'))->update($data);
            DB::commit();
            return json_encode(array('status'=>true, 'message'=>'Berhasil merubah data', 'data'=>$output));
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
          
          try {
            $output = Banner::where('id', $id)->delete();
            return json_encode(array('status'=>true, 'message'=>'Berhasil menghapus data', 'data'=>$output));
          } catch (Exception $e) {
            return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
          }
      }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
