@extends('admin_layout')
@section('admin_content')
<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="{{URL::to('/dashboard')}}">Dashboard</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">Update Product</a>
				</li>
			</ul>

			<p class="alert-success">
					<?php
					$messege = Session::get('messege');
					if($messege){
						echo $messege;
						Session::put('messege', null);
					}
					?>
			</p>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Update Product</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="{{URL::to('/update-product',$all_product_info->product_id)}}" method="post" enctype="multipart/form-data">
						@csrf
						  <fieldset>							
							<div class="control-group">
							  <label class="control-label" for="date01">Product Name</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" name="product_name" required="" value="{{$all_product_info->product_name}}">
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label" for="selectError3">Product Category</label>
								<div class="controls">
								  <select id="selectError3" name="category_id">
								  <option>Select Category</option>
						<?php
                            $all_category_info=DB::table('tbl_category')
                                            ->where(['publication_status'=>1])
                                            ->get();
                            foreach($all_category_info as $v_category){ ?>
									<option value="{{$v_category->category_id}}">{{$v_category->category_name}}</option>
						<?php } ?>
								  </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError3">Brand Name</label>
								<div class="controls">
								  <select id="selectError3" name="manufacture_id">
								  <option>Select Brand</option>
						<?php
                            $all_manufacture_info=DB::table('tbl_manufacture')
                                            ->where(['publication_status'=>1])
                                            ->get();
                            foreach($all_manufacture_info as $v_manufacture){ ?>
									<option value="{{$v_manufacture->manufacture_id}}">{{$v_manufacture->manufacture_name}}</option>
						<?php } ?>
								  </select>
								</div>
							  </div>          
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Product Short Description</label>
							  <div class="controls">
								<textarea class="cleditor" name="product_short_description" rows="3" required="">{{$all_product_info->product_short_description}}</textarea>
							  </div>
							</div>
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Product long Description</label>
							  <div class="controls">
								<textarea class="cleditor" name="product_long_description" rows="3" required="">{{$all_product_info->product_long_description}}</textarea>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Product Price</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" name="product_price" required="" value="{{$all_product_info->product_price}}">
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label" for="fileInput">Product Image</label>
								<div class="controls">
								  <input class="input-file uniform_on" id="fileInput" name="product_image" type="file">
								</div>
							  </div>
							  <div class="control-group">
							  <label class="control-label" for="date01">Product Size</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" name="product_size" required="" value="{{$all_product_info->product_size}}">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Product Color</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" name="product_color" required="" value="{{$all_product_info->product_color}}">
							  </div>
							</div>							
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Update</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
@endsection