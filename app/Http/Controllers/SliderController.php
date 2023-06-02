<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start();

class SliderController extends Controller
{
     public function index(){
    	$this->AdminAuth();
		return view('admin.add_slider');
	}

	public function save_slider(Request $request){
		$this->AdminAuth();
		$data = array();		
		$data['publication_status'] = $request->publication_status;
		$image=$request->file('slider_image');
		if($image) {
			$image_name=Str::random(20);
			$ext=strtolower($image->getClientOriginalExtension());
			$image_full_name=$image_name.'.'.$ext;
			$upload_path='slider/';
			$image_url=$upload_path.$image_full_name;
			$success=$image->move($upload_path,$image_full_name);
			if($success){
				$data['slider_image']=$image_url;
				DB::table('tbl_slider')->insert($data);
				Session::put('messege','Slider Added Successfully.');
				return Redirect::to('/add-slider');

			}
		}
		$data['slider_image']='';
				DB::table('tbl_slider')->insert($data);
				Session::put('messege','Slider Added Successfully Without Image.');
				return Redirect::to('/add-slider');

		
	}


	public function all_slider(){
		$this->AdminAuth();
		$all_slider_info=DB::table('tbl_slider')
						->get();
		$manage_info=view('admin.all_slider')
					->with('all_slider_info',$all_slider_info);		
		return view('admin_layout')
					->with('admin.all_slider',$manage_info);
	}

	public function unactive_slider($slider_id){
		$this->AdminAuth();
		DB::table('tbl_slider')
			->where('slider_id',$slider_id)
			->update(['publication_status'=>0]);
		Session::put('messege','Slider Unactive Successfully.');
		return Redirect::to('/all-slider');

	}

	public function active_slider($slider_id){
		$this->AdminAuth();
		DB::table('tbl_slider')
			->where('slider_id',$slider_id)
			->update(['publication_status'=>1]);
		Session::put('messege','Slider Active Successfully.');
		return Redirect::to('/all-slider');

	}

	public function edit_slider($slider_id){
		$this->AdminAuth();
		$all_slider_info=DB::table('tbl_slider')
						->where('slider_id',$slider_id)
						->first();
		$manage_info=view('admin.edit_slider')
					->with('all_slider_info',$all_slider_info);		
		return view('admin_layout')
					->with('admin.edit_slider',$manage_info);

	}
    
    public function update_slider(Request $request, $slider_id){
    	$this->AdminAuth();
		$data = array();
		$data['publication_status'] = $request->publication_status;
		$image=$request->file('slider_image');
		if($image) {
			$image_name=Str::random(20);
			$ext=strtolower($image->getClientOriginalExtension());
			$image_full_name=$image_name.'.'.$ext;
			$upload_path='slider/';
			$image_url=$upload_path.$image_full_name;
			$success=$image->move($upload_path,$image_full_name);
			if($success){
				$data['slider_image']=$image_url;
				DB::table('tbl_slider')
						->where('slider_id',$slider_id)
						->update($data);
				Session::put('messege','Slider Updated Successfully.');
				return Redirect::to('/all-slider');

			}
		}
		$data['slider_image']='';
				DB::table('tbl_slider')
						->where('slider_id',$slider_id)
						->update($data);
				Session::put('messege','Slider Updated Successfully Without Image.');
				return Redirect::to('/all-slider');

	}

	public function delete_slider($slider_id){
		$this->AdminAuth();
		DB::table('tbl_slider')
			->where('slider_id',$slider_id)
			->delete();
		Session::put('messege','Slider Deleted Successfully.');
		return Redirect::to('/all-slider');

	}

	public function AdminAuth(){
    	$admin_id=Session::get('admin_id');
    	if($admin_id){
    		return;
    	} else {
    		return Redirect::to('/admin')->send();
    	}
    	
    } 
}
