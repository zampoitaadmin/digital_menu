<p><strong>Hello {{ $varGreetingName }},</strong></p>
<p><strong>Receipt email address: {{ $email }},</strong></p>
<p><strong>Delivery address: {{ $orderData->shipping_address }},</strong></p>
<p>Your order has been placed successfully.</p>
<!--<p>Following is your order data.</p>-->
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .cls_order_receipt td, .cls_order_receipt th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
@if($cartArray->totalProductCount)
    <h2>Slate Sign</h2>
    <table class="cls_order_receipt">
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        @php $ctr = 0 ; @endphp
        @foreach($cartArray->allItems as $key => $row)
            @if ($row->is_product ==1)
                <tr>
                    <td>{{ $ctr +1 }}</td>
                    <td>
                        Size : {{@$row->size_name}}<br>
                        Edge : {{@$row->edge_name}}<br>
                        Line 1 : {{@$row->line1}}<br>
                        Line 2 : {{@$row->line2}}<br>
                        Line 3 : {{@$row->line3}}<br>
                        Font : {{@$row->font_name}}<br>
                        Colour : {{@$row->color_name}} <br>
                        Fixing Type : {{@getFixingType(@$row->fixing_type,"name")}}
                    </td>
                    <td>
                        Quantity : <span class="result">{{@$row->quantity}}</span><br>
                        Sign : <span class="result">{{config('constants.currency')}}{{_number_format(@$row->size_price)}}</span><br>
                        24ct Gold : <span class="result">{{config('constants.currency')}}{{_number_format(@$row->color_price)}}</span><br>
                        Fixings : <span class="result">{{config('constants.currency')}}{{_number_format(@$row->fixing_price)}}</span><br>
                        VAT : <span class="result">{{config('constants.currency')}}{{_number_format(@$row->total_vat)}}</span><br>
                        Total : <span class="result">{{config('constants.currency')}}{{_number_format(@$row->total_item_price)}}</span>
                    </td>
                </tr>
                @php $ctr++ ; @endphp
            @endif
        @endforeach
    </table>
@endif

@if($cartArray->totalVoucherCount)
    <h2>Gift Voucher</h2>
    <table class="cls_order_receipt">
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        @foreach($cartArray->vouchers as $key => $row)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>
                    Gift Voucher Value: {{config('constants.currency')}}{{ $row->total_item_price}}<br>
                    Name: {{ $row->product_name}}<br>
                    To: {{ $row->recipient_first_name}} {{ $row->recipient_last_name}}<br>
                    Email: {{ $row->recipient_email_address}}<br>
                    From: {{ $row->voucher_from}}<br>
                    Send Date: {{ $row->when_to_email_voucher}}<br>
                    Greeting Message: {{ $row->personal_message}}<br>
                </td>
                <td>
                    Quantity: <span class="result">{{ $row->quantity }}</span><br>
                    Voucher: <span class="result">{{config('constants.currency')}}{{ $row->total_price }}</span><br>
                    VAT: <span class="result">{{config('constants.currency')}}{{ $row->total_vat }}</span><br>
                    Total: <span class="result">{{config('constants.currency')}}{{ $row->total_item_price}}</span><br>

                </td>
            </tr>
        @endforeach
    </table>
@endif

</body>
</html>
@if($cartArray->totalProductCount)
    <p>Delivery: Yes</p>
    <p>Delivery Price: {{config('constants.currency')}}{{ ($cartArray->shipping_charge) }}</p>
    <p>Delivery VAT: {{config('constants.currency')}}{{ ($cartArray->shipping_charge_vat) }}</p>
@endif
@if(!empty($cartArray->discount_code))
    <p>Discount <?= ($cartArray->discount_code_id) ? 'Coupon':'Voucher'?>: {{$cartArray->discount_code}}</p>
    <p>Discount Price: {{config('constants.currency')}}{{ ($cartArray->discount_amount) }}</p>
    <p>Discount VAT: {{config('constants.currency')}}{{ ($cartArray->discount_vat) }}</p>
@endif
@if($cartArray->is_urgent_order)
    <p>Urgent Order: Yes</p>
    <p>Urgent Order Price: {{config('constants.currency')}}{{ ($cartArray->is_urgent_order_amount) }}</p>
    <p>Urgent Order VAT: {{config('constants.currency')}}{{ ($cartArray->is_urgent_order_vat) }}</p>
@endif
<p>Price: {{config('constants.currency')}}{{ $cartArray->payable_amount }} | VAT: {{config('constants.currency')}}{{ $cartArray->payable_vat }}</p>
<p>Total Price: {{config('constants.currency')}}{{ $cartArray->total_payable }}</p>

<p></p>
