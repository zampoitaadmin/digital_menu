@extends("admin.layouts.layout")

@if(isset($id))
    @section("title", "Update Coupon")
@else
    @section("title", "Add Coupon")
@endif

@section("page_style")
    <link href="{{ url('ex_plugins/dropify-master/css/dropify.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/datatables.min.css') }}">
@endsection

@section("content")
      <div class="row">

        <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="material-icons">home</i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-coupon-list') }}">Coupon</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if(isset($id))
                        Update Coupon
                    @else
                        Add Coupon
                    @endif
                </li>
            </ol>
        </nav>
    </div>

         <div class="col-xl-12 col-lg-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
                @if(isset($id))
                    <h6>Update Coupon</h6>
                @else
                    <h6>Add Coupon</h6>
                @endif
            </div>
            <div class="ms-panel-body">

              <form id="id_frm_crud_coupon" class="needs-validation clearfix" method="post"  action="@if(isset($id)) {{route('admin-coupon-update',['id'=>base64_encode($id)])}} @else{{route('admin-insert-coupon')}} @endif" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="form-row">

                  <div class="col-md-6 mb-3">
                    <label for="coupon_code">Coupon Code {!!_required_asterisk()!!}</label>
                    <div class="input-group">
                      <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Coupon Code" value="{{ old('coupon_code', @$coupon->coupon_code) }}" required>
                      <div class="invalid-feedback">
                        Plese Enter Coupon Code
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="type">Select Type</label>
                    <div class="input-group">
                      <select class="form-control" name="type" id="type" required>
                        
                        <option value="flat" <?=(isset($coupon) && $coupon->type =='flat' ?'selected':'')?> >Flat</option>

                        <option value="percentage" <?=(isset($coupon) && $coupon->type =='percentage' ?'selected':'')?>>Percentage</option>
                        

                      </select>
                      <div class="invalid-feedback">
                        Please select a Type
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mb-3">
                    <label for="description">Description {!!_required_asterisk()!!}</label>
                    <div class="input-group">
                      <textarea rows="5" name="description" id="description" class="form-control" placeholder="Coupon Description" required>{{ old('description', @$coupon->description) }}</textarea>
                      <div class="invalid-feedback">
                        Please provide a message.
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="amount">Amount {!!_required_asterisk()!!}</label>
                    <div class="input-group">
                      <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter Amount" value="{{ old('amount', @$coupon->amount) }}" required>
                      <div class="invalid-feedback">
                        Amount
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="limit_of_use">Limit Of Usage {!!_required_asterisk()!!}</label>
                      <div class="input-group">
                          
                        <input type="numeric" name="limit_of_use" id="limit_of_use" value="{{ old('limit_of_use', @$coupon->limit_of_use) }}" class="form-control" placeholder="Enter Limit Of Usage" required>
                          <div class="invalid-feedback">
                            Limit Of Usage
                          </div>
                      </div>
                  </div>


                  <div class="col-md-6 mb-3">
                    <label for="expiry_date">Expiry Date {!!_required_asterisk()!!}</label>
                      <div class="input-group">
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', @$coupon->expiry_date) }}" class="form-control"  required>
                          <div class="invalid-feedback">
                            Expiry Date
                          </div>
                      </div>
                  </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom22">Select Status </label>
                            <div class="input-group">
                              <select class="form-control" name="status" id="validationCustom22" required>
                                <option value="Active" <?=(isset($coupon->status) && $coupon->status=="Active"?'selected':'')?>>Active</option>
                                <option value="Inactive" <?=(isset($coupon->status) && $coupon->status=="Inactive"?'selected':'')?>>Inactive</option>

                              </select>
                              <div class="invalid-feedback">
                                Please select a Status.
                              </div>
                            </div>
                          </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-square btn-gradient-success" type="submit">Save</button>
                            <a href="{{ route('admin-coupon-list') }}" class="btn btn-square btn-gradient-light float-right">Cancel</a>
                        </div>

                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
   @endsection

@section("page_vendors")
    <script src="{{ url('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('ex_plugins/jquery-validation-1.19.1/dist/jquery.validate.js') }}"></script>
    <script src="{{ url('ex_plugins/dropify-master/js/dropify.min.js') }}"></script>
    <script src="{{ url('assets/js/promise.min.js') }}"></script>
    <script src="{{ url('assets/js/sweetalert2.min.js') }}"></script>
@endsection

@section("page_script")
<script type="text/javascript">
    $(document).ready(function(){


        // debugger;
        $("#id_frm_crud_coupon").validate({
            errorElement: "div", // contain the error msg in a span tag
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) { // render error placement for each input type
                // debugger;  
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: "",
            rules: {
                coupon_code: {
                    required: true
                },
                amount: {
                    required: true,
                    digits: true
                },
                description:{
                  required:true,
                },
                limit_of_use: {
                    required: true,
                },
                expiry_date: {
                    required: true
                }
            },
            messages: {
                coupon_code: {
                    required: '{{ __('Plese Enter Coupon Code') }}'
                },
                amount: {
                    required: '{{ __('Plese Enter Coupon Amount') }}',
                    digits: '{{ __('Plese Enter Valid Coupon Amount') }}'
                },
                description:{
                    required: '{{ __('Plese Enter Description') }}',
                },
                limit_of_use: {
                    required: '{{ __('Plese Enter Limit Of Usage') }}',
                },
                expiry_date: {
                    required: '{{ __('Plese Select Expiry Date') }}'
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                // debugger;
                //successHandler1.hide();
                //errorHandler1.show();
            },
            highlight: function (element) {
                // debugger;
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                // debugger;
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                // debugger;
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (frmadd) {
                // debugger;
                successHandler1.show();
                errorHandler1.hide();
            }
        });
    });


</script>
@endsection