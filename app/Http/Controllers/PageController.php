<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\SelectionList;
use App\Models\Page;
use App\Models\Banner;
use DB;

class PageController extends Controller
{

    public function __construct()
    {}

    // -------------------------------------- VIEW -------------------------------------- start
      public function homepage()
      {
        $data['banner'] = Banner::whereRaw("(((TIMESTAMP(publish_start) <= TIMESTAMP('".now()."') and (publish_end IS NULL or TIMESTAMP(publish_end) > TIMESTAMP('".now()."'))))  OR (publish_start IS NULL))")
                          ->orderBy('sequence','ASC')
                          // ->toSql();
                          ->get();
        // echo "<pre>";
        // echo "<hr>current time --> ".now()."<br>";
        // print_r($data['banner']);
        // echo "</pre>";die();
        return view('pages.index',$data);
      }
      public function index()
      {
        return view('admin.page.index');
      }
      public function user_index($slug)
      {
        $data['selected'] = Page::where('slug',$slug)->first();
        if($data['selected']){
          $data['title'] = $data['selected']->title;
          return view('user.page', $data);
        }else{
          $error_details = array(
            'title' => 'Oops!', 
            'desc' => 'Page dengan ID yang Anda cari tidak ditemukan.'
          );
          return view('admin.error.404', $error_details);
        }
      }
      public function form_add()
      {
        return view('admin.page.add');
      }
      public function form_edit($id)
      {
        // $data['selected'] = Page::find(1001); // testing error page
        $data['selected'] = Page::find($id);
        if($data['selected']){
          return view('admin.page.edit', $data);
        }else{
          $error_details = array(
            'title' => 'Oops!', 
            'desc' => 'Page dengan ID yang Anda cari tidak ditemukan.'
          );
          return view('admin.error.404', $error_details);
        }
      }
    // -------------------------------------- VIEW -------------------------------------- end

    // -------------------------------------- CALLED BY AJAX ---------------------------- start
      public function post_add(Request $request)
      {
          $validator = Validator::make($request->all(), [
            // 'code' => 'required',
            'slug' => 'required',
            'img_main' => 'required',
            'title' => 'required',
            'body' => 'required',
          ]); 
          if ($validator->fails()) {
            // return redirect()->back()->withInput();
            return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
          }
          
          DB::beginTransaction();
          try {
            if(Page::where('slug',$request->get('slug'))->exists()) {
              DB::rollback();
              return json_encode(array('status'=>false, 'message'=>'<b>Slug sudah dipakai.</b><br>Silahkan gunakan slug lain <br>atau ubah slug di data yang memakai slug ini.', 'data'=>null));
            }
            $data = $request->all();
            $default_folder = 'page/'; 
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
            $output = Page::create($data);
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
            // 'code' => 'required',
            'slug' => 'required',
            // 'img_main' => 'required',
            'title' => 'required',
            'body' => 'required',
          ]); 
          if ($validator->fails()) {
            // return redirect()->back()->withInput();
            return json_encode(array('status'=>false, 'message'=>$validator->messages()->first(), 'data'=>null));
          }
          
          DB::beginTransaction();
          try {
            $data = $request->all();
            $default_folder = 'page/'; 
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
            unset($data['check_validity']);
            unset($data['files']);
            $output = Page::where('id',$request->get('id'))->update($data);
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
            $output = Page::where('id', $id)->delete();
            return json_encode(array('status'=>true, 'message'=>'Berhasil menghapus data', 'data'=>$output));
          } catch (Exception $e) {
            return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
          }
      }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
