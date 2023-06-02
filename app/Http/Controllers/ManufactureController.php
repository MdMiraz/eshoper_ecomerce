<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start();

class ManufactureController extends Controller
{
    public function index(){
    	$this->AdminAuth();
		return view('admin.add_manufacture');
	}

	public function save_manufacture(Request $request){
		$this->AdminAuth();
		$data = array();
		$data['manufacture_id'] = $request->manufacture_id;
		$data['manufacture_name'] = $request->manufacture_name;
		$data['manufacture_description'] = $request->manufacture_description;
		$data['publication_status'] = $request->publication_status;
		DB::table('tbl_manufacture')->insert($data);
		Session::put('messege','Brands Added Successfully.');
		return Redirect::to('/add-manufacture');
	}

	public function all_manufacture(){
		$this->AdminAuth();
		$all_manufacture_info=DB::table('tbl_manufacture')->get();
		$manage_info=view('admin.all_manufacture')
					->with('all_manufacture_info',$all_manufacture_info);		
		return view('admin_layout')
					->with('admin.all_manufacture',$manage_info);
	}

	public function unactive_manufacture($manufacture_id){
		$this->AdminAuth();
		DB::table('tbl_manufacture')
			->where('manufacture_id',$manufacture_id)
			->update(['publication_status'=>0]);
		Session::put('messege','Brand Unactive Successfully.');
		return Redirect::to('/all-manufacture');

	}

	public function active_manufacture($manufacture_id){
		$this->AdminAuth();
		DB::table('tbl_manufacture')
			->where('manufacture_id',$manufacture_id)
			->update(['publication_status'=>1]);
		Session::put('messege','Brand Active Successfully.');
		return Redirect::to('/all-manufacture');

	}

	public function edit_manufacture($manufacture_id){
		$this->AdminAuth();
		$all_manufacture_info=DB::table('tbl_manufacture')
						->where('manufacture_id',$manufacture_id)
						->first();
		$manage_info=view('admin.edit_manufacture')
					->with('all_manufacture_info',$all_manufacture_info);		
		return view('admin_layout')
					->with('admin.edit_manufacture',$manage_info);

	}
    
    public function update_manufacture(Request $request, $manufacture_id){
    	$this->AdminAuth();
		$data = array();
		$data['manufacture_name'] = $request->manufacture_name;
		$data['manufacture_description'] = $request->manufacture_description;
		DB::table('tbl_manufacture')
				->where('manufacture_id',$manufacture_id)
				->update($data);
		Session::put('messege','Brand Updated Successfully.');
		return Redirect::to('/all-manufacture');

	}

	public function delete_manufacture($manufacture_id){
		$this->AdminAuth();
		DB::table('tbl_manufacture')
			->where('manufacture_id',$manufacture_id)
			->delete();
		Session::put('messege','Brand Deleted Successfully.');
		return Redirect::to('/all-manufacture');

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
