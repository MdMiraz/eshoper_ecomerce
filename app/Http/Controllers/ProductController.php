<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start();

class ProductController extends Controller
{
    public function index(){
    	$this->AdminAuth();
		return view('admin.add_product');
	}

	public function save_product(Request $request){
		$this->AdminAuth();
		$data = array();
		$data['product_name'] = $request->product_name;
		$data['category_id'] = $request->category_id;
		$data['manufacture_id'] = $request->manufacture_id;
		$data['product_short_description'] = $request->product_short_description;
		$data['product_long_description'] = $request->product_long_description;
		$data['product_prize'] = $request->product_prize;
		$data['product_size'] = $request->product_size;
		$data['product_color'] = $request->product_color;
		$data['publication_status'] = $request->publication_status;

		$image=$request->file('product_image');
		if($image) {
			$image_name=Str::random(20);
			$ext=strtolower($image->getClientOriginalExtension());
			$image_full_name=$image_name.'.'.$ext;
			$upload_path='image/';
			$image_url=$upload_path.$image_full_name;
			$success=$image->move($upload_path,$image_full_name);
			if($success){
				$data['product_image']=$image_url;
				DB::table('tbl_products')->insert($data);
				Session::put('messege','Product Added Successfully.');
				return Redirect::to('/add-product');

			}
		}
		$data['product_image']='';
				DB::table('tbl_products')->insert($data);
				Session::put('messege','Product Added Successfully Without Image.');
				return Redirect::to('/add-product');

		
	}


	public function all_product(){
		$this->AdminAuth();
		$all_product_info=DB::table('tbl_products')
						->join('tbl_category','tbl_products.category_id','=','tbl_category.category_id')
						->join('tbl_manufacture','tbl_products.manufacture_id','=','tbl_manufacture.manufacture_id')
						->select('tbl_products.*','tbl_manufacture.manufacture_name','tbl_category.category_name')
						->get();
		$manage_info=view('admin.all_product')
					->with('all_product_info',$all_product_info);		
		return view('admin_layout')
					->with('admin.all_product',$manage_info);
	}

	public function unactive_product($product_id){
		$this->AdminAuth();
		DB::table('tbl_products')
			->where('product_id',$product_id)
			->update(['publication_status'=>0]);
		Session::put('messege','Product Unactive Successfully.');
		return Redirect::to('/all-product');

	}

	public function active_product($product_id){
		$this->AdminAuth();
		DB::table('tbl_products')
			->where('product_id',$product_id)
			->update(['publication_status'=>1]);
		Session::put('messege','Product Active Successfully.');
		return Redirect::to('/all-product');

	}

	public function edit_product($product_id){
		$this->AdminAuth();
		$all_product_info=DB::table('tbl_products')
						->where('product_id',$product_id)
						->first();
		$manage_info=view('admin.edit_product')
					->with('all_product_info',$all_product_info);		
		return view('admin_layout')
					->with('admin.edit_product',$manage_info);

	}
    
    public function update_product(Request $request, $product_id){
    	$this->AdminAuth();
		$data = array();
		$data['product_name'] = $request->product_name;
		$data['category_id'] = $request->category_id;
		$data['manufacture_id'] = $request->manufacture_id;
		$data['product_short_description'] = $request->product_short_description;
		$data['product_long_description'] = $request->product_long_description;
		$data['product_price'] = $request->product_price;
		$data['product_size'] = $request->product_size;
		$data['product_color'] = $request->product_color;
		$data['publication_status'] = $request->publication_status;

		$image=$request->file('product_image');
		if($image) {
			$image_name=Str::random(20);
			$ext=strtolower($image->getClientOriginalExtension());
			$image_full_name=$image_name.'.'.$ext;
			$upload_path='image/';
			$image_url=$upload_path.$image_full_name;
			$success=$image->move($upload_path,$image_full_name);
			if($success){
				$data['product_image']=$image_url;
				DB::table('tbl_products')
						->where('product_id',$product_id)
						->update($data);
				Session::put('messege','Product Updated Successfully.');
				return Redirect::to('/all-product');

			}
		}
		$data['product_image']='';
				DB::table('tbl_products')
						->where('product_id',$product_id)
						->update($data);
				Session::put('messege','Product Updated Successfully Without Image.');
				return Redirect::to('/all-product');

	}

	public function delete_product($product_id){
		$this->AdminAuth();
		DB::table('tbl_products')
			->where('product_id',$product_id)
			->delete();
		Session::put('messege','Product Deleted Successfully.');
		return Redirect::to('/all-product');

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
