<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start();

class CategoryController extends Controller
{
	public function index(){
		$this->AdminAuth();
		return view('admin.add_category');
	}

	public function all_category(){
		$this->AdminAuth();
		$all_category_info=DB::table('tbl_category')->get();
		$manage_info=view('admin.all_category')
					->with('all_category_info',$all_category_info);		
		return view('admin_layout')
					->with('admin.all_category',$manage_info);
	}

	public function save_category(Request $request){
		$this->AdminAuth();
		$data = array();
		$data['category_id'] = $request->category_id;
		$data['category_name'] = $request->category_name;
		$data['category_description'] = $request->category_description;
		$data['publication_status'] = $request->publication_status;
		DB::table('tbl_category')->insert($data);
		Session::put('messege','Category Added Successfully.');
		return Redirect::to('/all-category');
	}

	public function unactive_category($category_id){
		$this->AdminAuth();
		DB::table('tbl_category')
			->where('category_id',$category_id)
			->update(['publication_status'=>0]);
		Session::put('messege','Category Unactive Successfully.');
		return Redirect::to('/all-category');

	}

	public function active_category($category_id){
		$this->AdminAuth();
		DB::table('tbl_category')
			->where('category_id',$category_id)
			->update(['publication_status'=>1]);
		Session::put('messege','Category Active Successfully.');
		return Redirect::to('/all-category');

	}

	public function edit_category($category_id){
		$this->AdminAuth();
		$all_category_info=DB::table('tbl_category')
						->where('category_id',$category_id)
						->first();
		$manage_info=view('admin.edit_category')
					->with('all_category_info',$all_category_info);		
		return view('admin_layout')
					->with('admin.edit_category',$manage_info);

	}
    
    public function update_category(Request $request, $category_id){
    	$this->AdminAuth();
		$data = array();
		$data['category_name'] = $request->category_name;
		$data['category_description'] = $request->category_description;
		DB::table('tbl_category')
				->where('category_id',$category_id)
				->update($data);
		Session::put('messege','Category Updated Successfully.');
		return Redirect::to('/all-category');

	}

	public function delete_category($category_id){
		$this->AdminAuth();
		DB::table('tbl_category')
			->where('category_id',$category_id)
			->delete();
		Session::put('messege','Category Deleted Successfully.');
		return Redirect::to('/all-category');

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
