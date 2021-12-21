<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    
    <div class="container mt-5">
        <div class="ms-panel" id="printArea">
            <div class="ms-panel-header header-mini">
                <div class="d-flex justify-content-between">
                    <h6>Order</h6>
                    <h6>#{{ $data->generate_code ?? '' }}</h6>
                </div>
            </div>
            <div class="ms-panel-body">

                <!-- Invoice To -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="invoice-address">
                            <h3>Reciever: </h3>
                            <h5>{{ $data->user_full_name ?? '' }}</h5>
                            <p>{{ $data->user_email ?? '' }}</p>
                            <p class="mb-0" style="max-width: 200px;">{{ $data->shipping_address?? ''}}</p>
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
                    <table class="table table-hover text-right thead-light">
                        <thead>
                            <tr class="text-capitalize">
                                <th class="text-center w-5">id</th>
                                <th class="text-left">description</th>
                                <th>qty</th>
                                <th>Unit Cost</th>
                                <th>total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $main_total = 0; @endphp
    
                            @if(isset($data->order_item) && !empty($data->order_item))
                                @php $i = 1; @endphp
                                @foreach($data->order_item as $row)
                                    @php 
                                        $item_total = 0; 
                                        $product_prize = $row->product_prize ?? 0; 
                                        $quantity = $row->quantity ?? 0;
                                        $product_price_total = $quantity * $product_prize;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-left">{{ $row->product_name ?? '' }}</td>
                                        <td>{{ $quantity }}</td>
                                        <td>{{ '$'.$product_prize }}</td>
                                        <td>{{ '$'.$product_price_total }}</td>
                                        @php $item_total = $item_total + $product_price_total ; @endphp 
                                    </tr>

                                    @if(isset($row->ingrediants) && !empty($row->ingrediants))
                                        @php $subing_total = 0; @endphp
                                        @foreach($row->ingrediants as $pi)
                                            @php 
                                                $pi_quantity = $pi['quantity'] ?? 0;
                                                $pi_price = $pi['price'] ?? 0;
                                                $pi_total = $pi_quantity * $pi_price;
                                            @endphp
                                            <tr>
                                                <td></td>
                                                <td class="text-left" style="padding-left: 30px;"> - {{ $pi['name'] ?? '' }}</td>
                                                <td>{{ $pi_quantity }}</td>
                                                <td>{{ '$'.$pi_price }}</td>
                                                <td>{{ '$'.$pi_total }}</td>
                                                @php $subing_total = $subing_total + $pi_total; @endphp
                                            </tr>
                                        @endforeach
                                            @php $main_total = $main_total + $subing_total + $item_total; @endphp
                                    @else
                                        @php $main_total = $main_total + $item_total; @endphp
                                    @endif
                                    @php $i++; @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center"> No Data Found...!!!</td>
                                </tr>
                            @endif
                        </tbody>
                        @php 
                            $delivery_charge = $data->delivery_charge ?? 0;
                            $service_tax = $data->service_tax ?? 0;
                            $grand_total = $delivery_charge + $service_tax + $main_total;
                        @endphp
                        <tfoot>
                            <tr>
                                <td colspan="4" class="pb-0">Sub Total: </td>
                                <td class="pb-0">${{ $main_total ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Delivery Charge: </td>
                                <td style="border-top: none;" class="pb-0 pt-0">${{ $delivery_charge ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-top: none;" class="pb-0 pt-0">Service Tax: </td>
                                <td style="border-top: none;" class="pb-0 pt-0">${{ $service_tax ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-top: none;">Total Cost: </td>
                                <td style="border-top: none;">${{ $grand_total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>

</html>