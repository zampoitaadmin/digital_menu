@extends("admin.layouts.layout")

@section("title", "Order View")

@section("page_style")

    @endsection

            <!--  Note : if you do changes any king in order view blade please do copy same in mail blade file -->

@section("content")

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-orders-list') }}">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                </ol>
            </nav>

            <div class="ms-panel" id="printArea">
                <div class="ms-panel-header header-mini">
                    <div class="d-flex justify-content-between">
                        <h6>Order Details</h6>
                        <h6>#{{ $data->generate_code ?? '' }}</h6>
                    </div>
                </div>
                <div class="ms-panel-body">

                    <!-- Invoice To -->
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="invoice-address">
                                <h3>Recipient : </h3>
                                <h5>{{ _ucWords($data->customer_name ?? '') }}</h5>
                                <p>
                                    {{ $data->customer_email  ?? '' }} <br>
                                    {{ $data->customer_phone }}<br>
                                </p>
                                <p></p>
                                <p class="mb-0" style="max-width: 200px;">{{ $data->shipping_address?? ''}}<br>{{$data->customer_postcode}}</p>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <ul class="invoice-date">
                                <li>Order Date : {{ $data->order_date_time ?? '' }}</li>
                                <?php
                                    $paymentStatus = '';
                                    #dd($data);
                                    if($data->payment_method == 'Manual' && $data->payment_status != 'Completed'){
                                        $paymentStatus = '<span class="badge badge-gradient-danger">'.$data->payment_status.'</span>';
                                    }
                                ?>
                                <li>Payment Mode : {{ $data->payment_method ?? '' }}</li>
                                <li>Payment Status : {!!$paymentStatus!!}</li>
                                <li>Transaction Id: {{ $data->txn_id ?? '' }}</li>
                            </ul>
                        </div>
                    </div>


                    <!-- Invoice Table -->


                    @if( $data->order_type == "PRODUCT" || $data->order_type == "BOTH" )
                        <div class="ms-invoice-table table-responsive mt-5">
                            <h6>SLATE SIGNS</h6>
                            <table class="table table-hover text-right thead-light">
                                <thead>
                                <tr class="text-capitalize">
                                    <th class="text-center w-5">id</th>
                                    <th class="text-left">Item Details</th>
                                    <th class="text-right">Quantity</th>
                                    @if($adminRoleId !="2")
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Total </th>
                                    @endif
                                </tr>
                                </thead>
                                @php $i=1;
                                @endphp
                                <tbody>
                                @foreach($order as $key=>$value)
                                    @if($value->is_product == 1)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td class="text-left">
                                                Size        : {{$value->size_name}} <br>
                                                Edge        : {{$value->edge_name}} <br>
                                                Line1       : {{$value->line1}} <br>
                                                Line2       : {{$value->line2}}  <br>
                                                Line3       : {{$value->line3}}  <br>
                                                Font        : {{$value->font_name}} <br>
                                                Colour      : {{$value->color_name}} <br>
                                                Fixing Type : {{getFixingType($value->fixing_type,'name')}}
                                            </td>
                                            <td class="text-right">{{ $value->quantity}}</td>
                                            @if($adminRoleId !="2")
                                                <td class="text-right">{{config('constants.currency')}}{{_number_format($value->unit_price) }}</td>
                                                <td class="text-right">{{config('constants.currency')}}{{_number_format($value->total_price)}}</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($value->is_product == 3)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td class="text-left">
                                                 <?php
                                                                                        $previewData = @json_decode(json_decode($value->preview_data));
                                                                                        // if($previewData){
                                                                                        // echo nl2br(strip_tags($previewData->description ));
                                                                                        // }else{
                                                                                        //     echo " - ";
                                                                                        // }
                                                                                    ?>
                                                                                    Name : {{@$previewData->name}}<br>
                                                                                    Size : {{@$previewData->size}}<br>
                                                                                    Finish : {{@$previewData->finish}}<br>
                                                                                    Colour : {{@$previewData->colour}}<br>
                                                                                    House Number : {{@$value->line1}}<br>
                                            </td>
                                            <td class="text-right">{{ $value->quantity}}</td>
                                            @if($adminRoleId !="2")
                                                <td class="text-right">{{config('constants.currency')}}{{_number_format($value->unit_price) }}</td>
                                                <td class="text-right">{{config('constants.currency')}}{{_number_format($value->total_price)}}</td>
                                            @endif
                                        </tr>
                                    @endif
                                    <?php $i++;?>
                                @endforeach

                                </tbody>
                                @if($adminRoleId !="2")
                                    @if($data->order_type == "PRODUCT")
                                        <tfoot>

                                        @if($data->shipping_charge != "")
                                            <tr>
                                                <td colspan="4" class="pb-0">Shipping Charge: </td>
                                                <td class="pb-0">{{ config('constants.currency')}}{{$data->shipping_charge }}</td>
                                            </tr>
                                        @endif

                                        @if($data->shipping_charge_vat!="0.00")
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Shipping Charge Vat : </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{ $data->shipping_charge_vat ?? '' }}</td>
                                            </tr>
                                        @endif
                                        @if($data->is_urgent_order == 1)
                                            {{--<tr>
                                                <td scope="row" colspan="3" style="border-top: none; text-align: left;"  class="pb-0 pt-0">Urgent Order : Yes </td>
                                            </tr>--}}
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0" >Urgent Order Price :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->is_urgent_order_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-1 pt-1">Urgent Order Vat :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-1">{{ config('constants.currency')}}{{$data->is_urgent_order_vat}}</td>
                                            </tr>
                                        @endif



                                        @if(!empty($data->discount_code))
                                            {{--<tr>
                                                <td scope="row" colspan="2" style="border-top: none; text-align: left;"  class="pb-0 pt-0">Discount : <?= $data->discount_code_id  ? 'Coupon':'Voucher'?> </td>
                                            </tr>--}}
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Discount <?= $data->discount_code_id  ? 'Coupon':'Voucher'?> <br>[{{$data->discount_code}}]  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Discount Price :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">- {{config('constants.currency')}}{{ ($data->discount_amount) }}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Discount Vat :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">- {{config('constants.currency')}}{{ ($data->discount_vat) }}</td>
                                            </tr>

                                        @endif

                                        <tr>
                                            <td colspan="4" style="border-top: none;" class="pb-0 pt-0" >Sub Total : </td>
                                            <td style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->payable_amount  }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Sub Total Vat : </td>
                                            <td  style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->subtotal_vat  }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="border-top: none;">Total Cost : </td>
                                            <td style="border-top: none;">{{config('constants.currency')}}{{$data->total_payable}}</td>
                                        </tr>

                                        </tfoot>

                                    @endif
                                @endif
                            </table>

                            @endif

                            @if($data->order_type == "BOTH" || $data->order_type == "VOUCHER" )
                                <h6>GIFT VOUCHER</h6>
                                <table class="table table-hover text-right thead-light">
                                    <thead>
                                    <tr class="text-capitalize">
                                        <th class="text-center w-5">id</th>
                                        <th class="text-left">Description</th>
                                        <th class="text-right">Quantity</th>
                                        @if($adminRoleId !="2")
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Total </th>
                                        @endif
                                    </tr>
                                    </thead>
                                    @php
                                    $i=1;
                                    @endphp
                                    <tbody>
                                    @foreach($order as $key=>$value)
                                        @if($value->is_product==2)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td class="text-left">
                                                    Gift Voucher data: {{config('constants.currency')}}{{$value->total_item_price}}<br>
                                                    Name: {{ $value->product_name}}<br>
                                                    To: {{ _ucWords($value->recipient_first_name)}} {{ _ucWords($value->recipient_last_name)}}<br>
                                                    Email: {{ $value->recipient_email_address}}<br>
                                                    From: {{ _ucWords($value->voucher_from)}}<br>
                                                    Send Date: {{ $voucher->when_to_email_voucher}}<br>
                                                    Greeting Message: {{ $value->personal_message}}<br>
                                                    <!-- Send When To  : @if($voucher->when_to_email_voucher_type !="")
                                                {{$voucher->when_to_email_voucher}}
                                                @else
                                                            &nbsp;&nbsp;&nbsp; -
                                                @endif -->
                                                </td>
                                                <td class="text-right">{{ $value->quantity}}</td>
                                                @if($adminRoleId !="2")
                                                    <td class="text-right">{{ config('constants.currency')}}{{  _number_format($value->unit_price + $value->unit_vat) }}</td>
                                                    <td class="text-right">{{ config('constants.currency')}}{{  _number_format($value->total_item_price)}}</td>
                                                @endif
                                            </tr>
                                            <?php $i++;?>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    @if($adminRoleId !="2")
                                        <tfoot>


                                        @if($data->order_type=="Both")
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Unit Vat : </td>
                                                <td style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{ $data->unit_vat ?? '' }}</td>
                                            </tr>
                                        @endif

                                        @if($data->order_type == "BOTH")
                                            @if($data->shipping_charge !="0.00")
                                                <tr>
                                                    <td colspan="4" class="pb-0">Shipping Charge: </td>
                                                    <td class="pb-0">{{ config('constants.currency')}}{{$data->shipping_charge }}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Shipping Charges Vat :  </td>
                                                    <td colspan="4" style="border-top: none;" class="pb-0 pt-0"> {{config('constants.currency')}}{{ ($data->shipping_charge_vat) }}</td>
                                                </tr>

                                            @endif
                                        @endif
                                        @if($data->is_urgent_order == 1)
                                            {{--<tr>
                                                <td scope="row" colspan="3" style="border-top: none; text-align: left;"  class="pb-0 pt-0">Urgent Order : Yes </td>
                                            </tr>--}}
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Urgent Order Price :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->is_urgent_order_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Urgent Order Vat :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->is_urgent_order_vat}}</td>
                                            </tr>
                                        @endif


                                        @if(!empty($data->discount_code))

                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Discount <?= $data->discount_code_id  ? 'Coupon':'Voucher'?> <br>[{{$data->discount_code}}]  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Discount Price :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">- {{config('constants.currency')}}{{ ($data->discount_amount) }}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Discount Vat :  </td>
                                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">- {{config('constants.currency')}}{{ ($data->discount_vat) }}</td>
                                            </tr>

                                        @endif

                                        <tr>
                                            <td colspan="4" style="border-top: none;" class="pb-0 pt-0" >Sub Total : </td>
                                            <td style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->payable_amount  }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Sub Total Vat : </td>
                                            <td  style="border-top: none;" class="pb-0 pt-0">{{ config('constants.currency')}}{{$data->subtotal_vat  }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="border-top: none;">Total Cost : </td>
                                            <td style="border-top: none;">{{config('constants.currency')}}{{$data->total_payable}}</td>
                                        </tr>

                                        </tfoot>
                                    @endif
                                </table>
                            @endif

                        </div>
                </div>
            </div>

            @if(isset($data) && !empty($data))
                <div class="ms-panel">
                    <div class="invoice-buttons text-right">
                        <input type="hidden" name="id" id="id" value="{{$data->id}}">
                        <select  class="form-control change_status" style="float: left;  width: 200px; margin-left:10px; margin-top: 7px; ">
                            <option class="dropdown-item badge-gradient-danger" data-status="Processing"  data-id="{{ $data->id }}" <?php if($data->order_status == 'Processing'){ echo "selected"; } ?> >Processing</option>
                            <option class="dropdown-item badge-gradient" style="background-color: blue;" data-status="Processing"  data-id="{{ $data->id }}" <?php if($data->order_status == 'Proof Emailed'){ echo "selected"; } ?> >Proof Emailed</option>
                            <option class="dropdown-item badge-gradient"  data-status="In Production"  data-id="{{ $data->id }}" <?php if($data->order_status == 'In Production'){ echo "selected"; } ?> style="background-color: orange;" >In Production</option>
                            <option class="dropdown-item badge-gradient" style="background-color: black;"  data-status="Quality Issue"  data-id="{{ $data->id }}" <?php if($data->order_status == 'Quality Issue'){ echo "selected"; } ?> >Quality Issue</option>
                            <option class="dropdown-item badge-gradient-success"  data-status="Completed"  data-id="{{ $data->id }}" <?php if($data->order_status == 'Completed'){ echo "selected"; } ?> >Completed</option>
                            <option class="dropdown-item badge-gradient"  style="background-color: #9F10C6;"  data-status="Cancelled"  data-id="{{ $data->id }}" <?php if($data->order_status == 'Cancelled'){ echo "selected"; } ?> >Cancelled</option>

                        </select>
                        <a href="javascript:void(0);" onclick="printDiv('printArea')"  class="btn btn-primary mr-2 print m-2">Print Order</a>
                        {{-- <a href="{{ route('admin-orders-send-invoice', [base64_encode($data->id), base64_encode($data->customer_id)]) }}" class="btn btn-primary m-2">Send Invoice</a> --}}
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
        $(".change_status").change(function(){

            var status = $('.change_status').val();
            var id = $('#id').val();
            $.ajax({
                "url": "{!! route('admin-orders-change-status') !!}",
                "dataType": "json",
                "type": "POST",
                "data":{
                    id: id,
                    status: status,
                    _token: "{{csrf_token()}}"
                },
                success: function (response){
                    if (response.status == "success"){
                        toastr.success('{{ __('message_lang.STATUS_CHANGED_SUCCESSFULLY') }}', 'Success');
                    } else {
                        toastr.error('{{ __('message_lang.FAILED_TO_UPDATE_STATUS') }}', 'Error');
                    }
                }
            });
        });
    </script>
@endsection