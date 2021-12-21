@extends("admin.layouts.layout")

@section("title", "Coupon List")

@section("page_style")
 
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/custom_table_css.css') }}">
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="new">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-orders-list') }}">Coupons</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Coupons List</li>
                </ol>
            </nav>
            <div class="ms-panel">
                <div class="ms-panel-header">
                    <div class="d-flex justify-content-between">
                        <div class="align-self-center align-left">
                            <h6>Orders</h6>
                        </div>
                            <button class="btn btn-success" onclick="ExportData();">Export</button>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="mt-3 mr-3">
                        From: 
                    </div>
                    <div class="mt-3 mr-3">
                        <input type="date" class="form-control" id="fromDatepicker" name="from_datepicker" style='width: 300px;' value="" onchange="handler(event);">
                    </div> 
                    <div class="mt-3 mr-3">
                        To: 
                    </div>
                    <div class="mt-3 mr-3">
                        <input type="date" class="form-control" id="toDatepicker" name="to_datepicker" style='width: 300px;' value="" onchange="handler(event);">
                    </div>
                    
                </div>

               

                <div class="ms-panel-body">
                    <div class="table-responsive">
                        <table id="data-table-4" name="frm-datatable" class="table w-100 thead-primary nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Coupon Code</th>
                                    <th>Count Uses of Coupon</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("page_vendors")
     <script src="{{ url('assets/js/datatables.min.js') }}"></script>
@endsection

@section("page_script")
    
<script type="text/javascript">
    var list_table_one;
    function handler(e)
    {
        // alert(e.target.value);
        list_table_one.ajax.reload(null, false); //reload datatable ajax
    }
    $(document).ready(function() {
        if($('#data-table-4').length > 0)
        {
            list_table_one = $('#data-table-4').DataTable(
            {
                processing: true,
                serverSide: true,

                // "pageLength": 10,
                // "iDisplayLength": 10,
                "responsive": true,
                "aaSorting": [],
                // "order": [], //Initial no order.
                //     "aLengthMenu": [
                //     [5, 10, 25, 50, 100, -1],
                //     [5, 10, 25, 50, 100, "All"]
                // ],
                
                "scrollX": true,
                "scrollY": true,
                
                // "scrollCollapse": false,
                // scrollCollapse: true,
                
                "ajax":
                {
                    "url": "{{ route('admin-coupon-report-list-fetch') }}",
                    "type": "POST",
                    "dataType": "json",
                    "data": function (data) {
                        data.fromDatepicker = $("#fromDatepicker").val();
                        data.toDatepicker = $("#toDatepicker").val();
                        _token: "{{csrf_token()}}"
                    },
                },
                "columnDefs": [
                    {
                        "targets": [0, 3], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
                columns: [
                    {
                        // data: 'id',
                        // name: 'id'
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        sortable:false
                    },
                    {
                        data: 'coupon_code',
                        name: 'coupon_code'
                    },
                    {
                        data: 'count_use_of_coupon',
                        name: 'count_use_of_coupon'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                    },
                ]
            });
        }
    });
    var fromDatepicker = document.getElementById('fromDatepicker');
    var toDatepicker = document.getElementById('toDatepicker');

    fromDatepicker.addEventListener('change', function() {
        if (fromDatepicker.value){
            toDatepicker.min = fromDatepicker.value;
        }
        list_table_one.ajax.reload(null, false); //reload datatable ajax
    }, false);

    toDatepicker.addEventListener('change', function() {
        if (toDatepicker.value){
            fromDatepicker.max = toDatepicker.value;
        }
        list_table_one.ajax.reload(null, false); //reload datatable ajax
    }, false);
    function ExportData()
    {
        var from_date = $('#fromDatepicker').val();
        var to_date = $('#toDatepicker').val();
        var from_order_type = $('#from_order_type').val();

        $.ajax({
          type :"post",
          url : "{{route('admin-coupon-report-export')}}",
          data : { 
            from_date : from_date ,
            to_date : to_date,
            from_order_type: from_order_type,
            _token: '{{csrf_token()}}',
          },
          success: function(result, status, xhr) {
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'Coupon-Report.csv');

                // The actual download
                var blob = new Blob([result], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
            }
          
        });
    }
</script>
@endsection