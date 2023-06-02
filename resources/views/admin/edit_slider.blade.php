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
					<a href="#">Update Slider</a>
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
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Update Slider</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="{{URL::to('/update-slider',$all_slider_info->slider_id)}}" method="post" enctype="multipart/form-data">
						@csrf
						  <fieldset>							
							<div class="control-group">
								<label class="control-label" for="fileInput">Product Image</label>
								<div class="controls">
								  <input class="input-file uniform_on" id="fileInput" name="slider_image" type="file">
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