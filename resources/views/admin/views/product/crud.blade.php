@extends("admin.layouts.layout")

@section('title')
	@if(isset($data))
		Update Product
	@else
		Add Product
	@endif
@endsection

@section("page_style")
	<link href="{{ url('ex_plugins/dropify-master/css/dropify.min.css') }}" rel="stylesheet">
	<link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script type="text/javascript" src="{{ url('ex_plugins/ckeditor/ckeditor.js') }}"></script>
	<style type="text/css">
		#cke_description, #cke_ingredients
		{
			width: inherit;
		}
	</style>
@endsection

@section("content")
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb pl-0">
					<li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="material-icons"></i> Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin-product-list') }}">Products</a></li>
					<li class="breadcrumb-item active" aria-current="page">
						@if(isset($data))
							Update {{ $data->name ?? '' }}
						@else
							Add Product
						@endif
					</li>
				</ol>
			</nav>
		</div>
		
		<div class="col-xl-12 col-lg-12">
			<div class="ms-panel ms-panel-fh">
				<div class="ms-panel-header">
					@if(isset($data))
						<h6>Update {{ $data->name ?? '' }}</h6>
					@else
						<h6>Add Product</h6>
					@endif
				</div>
				<div class="ms-panel-body">
					@if(isset($id))
                        @php 
                            $form_route = route('admin-product-update', $id); 
                            $id_encoded = base64_encode($id);
                        @endphp
                    @else
                        @php $form_route = route('admin-product-insert'); @endphp
                    @endif
					<form id="id_frm_crud_user" class="needs-validation clearfix" method="post" action="{{ $form_route }}" enctype="multipart/form-data">
						@csrf
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="name">Name</label>
								<div class="input-group">
									<input type="text" name="name" id="name" class="form-control" value="{{ old('name', @$data->name) }}" placeholder="Name" >
									@error('name')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div>
							<!-- <div class="col-md-12 mb-3">
								<label for="category_ids">Category</label>
								<div class="input-group">
									<select class="form-control" name="category_ids[]" id="category_ids" multiple="multiple" >
										@if(isset($data->category_ids))
											@php $datacategories = explode(',',$data->category_ids); @endphp
										@else
											@php $datacategories = []; @endphp
										@endif
										<option value="">Select Category</option>
	                                    @if(isset($category) && !empty($category))
	                                        @foreach($category as $row)
	                                            <option value="{{ $row->id }}" @if(in_array($row->id, $datacategories)) selected @endif >{{ $row->cat_name }}</option>
	                                        @endforeach
	                                    @endif
	                                </select>
									@error('category_ids')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div> -->
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="price">Price</label>
								<div class="input-group">
									<div class="input-group-append">
										<span class="input-group-text">&pound;</span>
									</div>
									<input type="text" name="price" id="price" class="form-control" value="{{ old('price', @$data->price) }}" placeholder="Price" >
									@error('price')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="name">Size</label>
								<div class="input-group">
									<input type="text" name="size" id="size" class="form-control" value="{{ old('size', @$data->size) }}" placeholder="Size" >
									@error('size')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="name">Finish</label>
								<div class="input-group">
									<input type="text" name="finish" id="finish" class="form-control" value="{{ old('finish', @$data->finish) }}" placeholder="Finish" >
									@error('finish')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="name">Colour</label>
								<div class="input-group">
									<input type="text" name="colour" id="colour" class="form-control" value="{{ old('colour', @$data->colour) }}" placeholder="Colour" >
									@error('colour')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="description">Description</label>
								<div class="input-group">
									<textarea name="description" id="description" class="form-control" placeholder="Description" rows="5">{{ old('description', @$data->description) }}</textarea>
									@error('description')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
								</div>
							</div>
						</div>
						
						<div class="col-md-12 mb-3">
                            @if(isset($data) && $data->image != '')
                                 @if(File::exists(public_path('uploads/product/'.$data->image)))
                                    @php $image_url = url('uploads/product/'.$data->image); @endphp
                                @else
                                    @php $image_url = url('uploads/default/default.jpg'); @endphp
                                @endif
                            @else
                                @php $image_url = ''; @endphp
                            @endif
                            <label for="image">Select Image</label>
                            <div class="input-group">
                                <input type="file" class="form-control dropify" id="image" name="image" data-default-file="{{ $image_url }}">

                                @error('image')
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                <!-- Send Hidden Image (Old Name) -->
                                @if(isset($data->image) && $data->image  !='')
                                    <input type="hidden" name="hidden_image" value="{{ $data->image }}"></input>
                                @else
                                    <input type="hidden" name="hidden_image" value=""></input>
                                @endif
                                <!-- Send Hidden Image (Old Name) -->
                            </div>
                        </div>
                       
						<!-- <div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="status">Select Status</label>
								<div class="input-group">
									<select class="form-control" name="status" id="status">
										<option value="{{config('constants.product_status.active')}}" <?php if(isset($data->status) && $data->status == config('constants.product_status.active')){ echo 'selected'; } ?> >
											{{config('constants.product_status.active')}}
										</option>
										<option value="{{config('constants.product_status.deactive')}}" <?php if(isset($data->status) && $data->status == config('constants.product_status.deactive')){ echo 'selected'; } ?> >
											{{config('constants.product_status.deactive')}}
										</option>
									</select>
									@error('status')
	                                    <div class="invalid-feedback" style="display: block;">
	                                        <strong>{{ $message }}</strong>
	                                    </div>
	                                @enderror
								</div>
							</div>
						</div> -->
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<button type="submit" class="btn btn-square btn-gradient-success" type="submit">Save</button>
								<a href="{{ route('admin-product-list') }}" class="btn btn-square btn-gradient-light float-right">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section("page_vendors")
	<script src="{{ asset('ex_plugins/jquery-validation-1.19.1/dist/jquery.validate.js') }}"></script>
    <script src="{{ url('ex_plugins/dropify-master/js/dropify.min.js') }}"></script>
    <script src="{{ url('assets/js/promise.min.js') }}"></script>
    <script src="{{ url('assets/js/sweetalert2.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section("page_script")
	<script type="text/javascript">
		CKEDITOR.replace('description');
		
		$(document).ready(function (){
			$('#category_ids').select2();
			$('.dropify').dropify();
			
			var drEvent = $('.dropify').dropify();

			var dropifyElements = {};
			
			$('.dropify').each(function (){
				dropifyElements[this.id] = false;
			});

			drEvent.on('dropify.beforeClear', function (event, element){
				id = event.target.id;
				if (!dropifyElements[id]){
					var url = "{!! route('admin-product-remove-image') !!}";
					<?php if(isset($id_encoded)){ ?>
						var id_encoded = "{{ $id_encoded }}";
						
						Swal.fire({
							title: 'Are you sure want delete this image?',
							text: "",
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Yes'
						}).then(function (result){
							if (result.value){
								$.ajax({
									url: url,
									type: "POST",
									data:{
										encoded_id: id_encoded,
										_token: "{{csrf_token()}}"
									},
									dataType: "JSON",
									success: function (data){
										if (data.code == '200'){
											Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
											dropifyElements[id] = true;
											element.clearElement();
										}else{
											Swal.fire('', 'Failed to delete', 'error');
										}
									},
									error: function (jqXHR, textStatus, errorThrown) {}
								});
							}
						});
						return false;
					<?php } else { ?>
						Swal.fire({
							title: 'Are you sure want delete this image?',
							text: "",
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Yes'
						}).then(function (result){
							if (result.value){
								Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
								dropifyElements[id] = true;
								element.clearElement();
							}else{
								Swal.fire('Cancelled', 'Discard Last Operation.', 'error');
							}
						});
					
						return false;
					<?php }?>
				}else{
					dropifyElements[id] = false;
					return true;
				}
			});

			$("#id_frm_crud_user").validate({
				errorElement: "div",
				errorClass: 'invalid-feedback',
				errorPlacement: function (error, element){
					error.insertAfter(element);
				},
				ignore: "",
				rules:{
					name:{
						required: true
					},
					price:{
						required: true,
						digits: true
					},
					size:{
						required:true,
					},
					finish:{
						required:true,
					},
					colour:{
						required:true,
					}
				},
				messages:{
					name:{
						required: 'Please enter name'
					},
					price:{
						required: 'Please enter price',
						digits: 'Please enter digit only'
					},
					size:{
						required: 'Please Enter Size'
					},
					finish:{
						required: 'Please Enter Finish'
					},
					colour:{
						required: 'Please Enter Colour'
					},
				},
				invalidHandler: function (event, validator){
				},
				highlight: function (element){
					$(element).closest('.help-block').removeClass('valid');
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
				},
				unhighlight: function (element){
					$(element).closest('.form-group').removeClass('has-error');
				},
				success: function (label, element){
					label.addClass('help-block valid');
					$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
				},
				submitHandler: function (frmadd, event){
					successHandler1.show();
					errorHandler1.hide();
				}
			});
		});
	</script>
@endsection