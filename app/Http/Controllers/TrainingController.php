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
    // $data['items'] = Training::get();
    $data['data_sorted_by']            = array(
      'latest'            => 'Paling Baru',
      'abc'               => 'Alfabet Judul A-Z',
      'abc-reverse'       => 'Alfabet Judul Z-A',
      // 'most_viewed'       => 'Paling Banyak Dilihat',
      // 'most_downloaded'   => 'Paling Banyak Diunduh',
      // 'most_reviewed'     => 'Paling Banyak Direview',
      // 'top_review'        => 'Review Tertinggi'
    );
    $data['grade_levels']    = Option::where('type', 'GRADE_LEVEL')->get();
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
    // dd($request->all());
    try {
      $limit            = intval($request->get('_limit'));
      $data['products'] = Training::whereRaw('1 = 1');
      if($request->get('_page')){
        $page           = intval($request->get('_page'));
        $offset         = ($page?($page-1)*$limit:0);
        $data['filter']                 = $request->all();
        $data['filter']['_page']        = $page;
        $data['filter']['_limit']       = $limit;
        $data['filter']['_level_info']  = null;
        if($request->get('_title')){
          $data['products'] = $data['products']->whereRaw('LOWER(title) LIKE "%'.strtolower($request->get('_title')).'%"');
        }
        // if($request->get('_status')){
        //   $data['products'] = $data['products']->where('status','=',$request->get('_status'));
        // }
        if($request->get('_year')){
          $year = explode(";",$request->get('_year'));
          $data['products'] = $data['products']->whereRaw('(YEAR(event_start) BETWEEN '.$year[0].' AND '.$year[1].')');
        }
        if($request->get('_level')){
          $data['products'] = $data['products']->whereIn('level',$request->get('_level'));
          $level_total      = Option::where('type', 'GRADE_LEVEL')->count();
          if(sizeof($request->get('_level')) != $level_total){
            $data['filter']['_level_info'] = 'SELECTED';
          }
        }
        if($request->get('_sort_by')){
          switch ($request->get('_sort_by')) {
            default:
            case 'latest':
              $data['products'] = $data['products']->orderBy('created_at','DESC');
              break;
            case 'abc':
              $data['products'] = $data['products']->orderBy('title','ASC');
              break;
            case 'abc-reverse':
              $data['products'] = $data['products']->orderBy('title','DESC');
              break;
            // case 'most_viewed':
            //   $data['products'] = $data['products']->orderBy('view_count','DESC');
            //   break;
            // case 'most_downloaded':
            //   $data['products'] = $data['products']->orderBy('download_count','DESC');
            //   break;
          }
        }
        $data['products_count_total']   = $data['products']->count();
        $data['products']               = $data['products']->limit($limit)->offset($offset);
        $data['products_count_start']   = ($data['products_count_total'] == 0 ? 0 : (($page-1)*$limit)+1);
        $data['products_count_end']     = ($data['products_count_total'] == 0 ? 0 : (($page-1)*$limit)+$data['products']->count());
      }else{
        $data['products']               = $data['products']->orderBy('created_at','DESC')->limit($limit);
      }
      // $data['products_raw_sql']       = $data['products']->toSql();
      $data['products']               = $data['products']->get();
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