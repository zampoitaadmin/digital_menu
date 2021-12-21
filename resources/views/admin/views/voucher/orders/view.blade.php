@extends("admin.layouts.layout")

@section("title", "Voucher Product View")

@section("page_style")
    
@endsection

<!--  Note : if you do changes any king in order view blade please do copy same in mail blade file -->

@section("content")

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-voucher-orders-list') }}">Voucher Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Voucher Order Details</li>
                </ol>
            </nav>

            <div class="ms-panel" id="printArea">
                <div class="ms-panel-header header-mini">
                    <div class="d-flex justify-content-between">
                        <h6>Voucher Order Details</h6>
                        <h6>#{{ $data->voucher_code ?? '' }}</h6>
                    </div>
                </div>
                <div class="ms-panel-body">

                    <!-- Invoice To -->
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="invoice-address">
                                <h3> Recipient : </h3>
                                <h5>{{ $data->recipient_name ?? '' }}</h5>
                                <p>{{ $data->recipient_email_address ?? '' }}</p>
                                <p class="mb-0" style="max-width: 200px;">{{ $data->shipping_address ?? ''}}</p>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <ul class="invoice-date">
                                <li>Order Date : {{ $data->order_date_time ?? '' }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Invoice Table -->
                    <div class="ms-invoice-table table-responsive mt-5">
                        <table class="table table-hover thead-light">
                            <thead>
                                <tr class="text-capitalize">
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Product price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Gift Voucher data: {{config('constants.currency')}}{{ _number_format($data->product_price ?? '')}}<br>
                                              Name: {{ $data->product_name}}<br>
                                              To: {{ _ucWords($data->recipient_name)}}<br>
                                              Email: {{ $data->recipient_email_address}}<br>
                                              From: {{ _ucWords($data->voucher_from)}}<br>
                                              Send Date: {{ $data->when_to_email_voucher}}<br>
                                              Greeting Message: {{ $data->personal_message}}<br>
                                             <!--  Send When To  : @if($data->when_to_email_voucher_type !="")
                                                {{$data->when_to_email_voucher}}
                                                @else
                                                     &nbsp;&nbsp;&nbsp; -
                                                @endif -->
                                    </td>
                                    <td>{{ $data->quantity ?? '' }}</td>
                                    <td>{{ config('constants.currency')}}{{ _number_format($data->product_price ?? '')}}</td>
                                    <td>{{ config('constants.currency')}}{{ _number_format($data->product_price * $data->quantity ?? 0) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="pb-0  text-right ">Total : </td>
                                    <td class="pb-0">{{ config('constants.currency')}}{{ _number_format($data->product_price * $data->quantity ?? 0 )}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if(isset($data) && !empty($data))
                <div class="ms-panel">
                    <div class="invoice-buttons text-right">
                        <select  class="form-control changeStatus" style="float: left;  width: 200px; margin-left:10px; margin-top: 7px; ">
                            <option class="dropdown-item badge-gradient-success" data-status="Active" data-id="{{ $data->id }}" <?php if($data->status == 'Active'){ echo "selected"; } ?> >Acitve</option>
                            <option class="dropdown-item badge-gradient-warning" data-status="Inactive" data-id="{{ $data->id }}" <?php if($data->status == 'Inactive'){ echo "selected"; } ?> >Inactive</option>
                            <option class="dropdown-item badge-gradient-danger" data-status="Used" data-id="{{ $data->id }}" <?php if($data->status == 'Used'){ echo "selected"; } ?> >Used</option>
                        </select>
                        <a href="javascript:void(0);" onclick="printDiv('printArea')"  class="btn btn-primary mr-2 print m-2">Print Order</a>
                        {{-- <a href="{{ route('admin-voucher-orders-send-invoice', [base64_encode($data->id), base64_encode($data->user_id)]) }}" class="btn btn-primary m-2">Send Invoice</a> --}}
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

@section("page_vendors")
@endsection
    
@section("page_script")
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        $('.changeStatus').change(function(){
            var status = $(this).find(':selected').attr('data-status');
            var id = $(this).find(':selected').attr('data-id');
            
            $.ajax({
                "url": "{!! route('admin-voucher-orders-change-status') !!}",
                "dataType": "json",
                "type": "POST",
                "data":{
                    id: id,
                    status: status,
                    _token: "{{csrf_token()}}"
                },
                success: function (response){
                    if (response.code == 200){
                        toastr.success('Status changed successfully.', 'Success');
                    } else {
                        toastr.error('Failed to change status', 'Error');
                    }
                }
            });
        });
    </script>
@endsection