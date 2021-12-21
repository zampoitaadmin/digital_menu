@extends("admin.layouts.layout")

@section("title", "Orders List")

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
                    <li class="breadcrumb-item"><a href="{{ route('admin-orders-list') }}">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Orders List</li>
                </ol>
            </nav>
            <div class="ms-panel">
                <div class="ms-panel-header">
                    <div class="d-flex justify-content-between">
                        <div class="align-self-center align-left">
                            <h6>Orders</h6>
                        </div>
                          <!-- <a class="btn btn-success action_export">Export</a> -->
                           <button class="btn btn-success" onclick="ExportData();">Export</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" style="margin-top: 10px; margin-left: 20px;">
                        <select name="delivery_type" id="delivery_type" class="form-control" style="width: 400px;" onchange="filterByDeliveryType();">
                            <option value="">Select Order Delivery Type</option>
                            <option value="0">Normal Delivery</option>
                            <option value="1">Urgent Delivery </option>
                        </select>
                    </div>
                </div>

                <div class="ms-panel-body">
                    <div class="table-responsive">
                        <table id="data-table-4" name="frm-datatable" class="table w-100 thead-primary nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Code</th>
                                    <th>Customer Name</th>
                                    <th>Order Type</th>
                                    @if($admin_role_id !="2")
                                        <th>Order Amount</th>
                                    @endif
                                    <th>Order Delivery Type</th>
                                    <th>Order Status</th>
                                    <th>Payment Mode</th>
                                    <th>Date Time</th>
                                    <th>{{ __('message_lang.LBL_ACTIONS') }}</th>
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
    {{--<script src="{{ url('ex_plugins/datatableV2/datatables.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('ex_plugins/datatableV2/datatables.min.css') }}">--}}
@endsection

@section("page_script")
    {{--<script src="{{ url('ex_plugins/datatableV2/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ url('ex_plugins/datatableV2/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('ex_plugins/datatableV2/buttons.html5.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('ex_plugins/datatableV2/dataTables.checkboxes.css') }}">--}}
<script type="text/javascript">
    var list_table_one;
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
                
                // "scrollX": true,
                // "scrollY": '',
                // "scrollCollapse": false,
                // scrollCollapse: true,
                
                "ajax":
                {
                    "url": "{{ route('admin-orders-list-fetch') }}",
                    "type": "POST",
                    "dataType": "json",
                    "data":function (data)
                    {
                        _token: "{{csrf_token()}}",
                        data.delivery_type = $("select[name='delivery_type']").val();
                    }
                },
                "columnDefs": [
                    {
                        <?php if($admin_role_id !="2") { ?>
                            "targets": [0], //first column / numbering column
                            "orderable": false, //set not orderable
                        <?php }?>
                       /* "targets": [0], //first column / numbering column
                            "orderable": false, //set not orderable
                            "checkboxes": {
                                    'selectRow': true
                                }*/
                    },
                ],
                /* 'select': {
                                'style': 'multi'
                            },*/
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
                        data: 'generate_code',
                        name: 'generate_code',
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'order_type',
                        name: 'order_type'
                    },
                    <?php if($admin_role_id !="2"){ ?>
                    {
                        data:'total_payable',
                        name:'total_payable'
                    },
                <?php } ?>
                    {
                        data:'is_urgent_order',
                        name:'is_urgent_order'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status',
                        orderable: false,
                        sortable:false
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                        orderable: false,
                        sortable:false
                    },
                    {
                        data: 'order_date_time',
                        name: 'order_date_time'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        sortable:false
                    },
                ]
            });
             $('#data-table-4').on('submit', function(e){
                    e.preventDefault();
                    var form = this;
                    var rows_selected = list_table_one.column(0).checkboxes.selected();
                   /* if(rows_selected.length==0){
                        toastr.error('You must select at least one record.', 'Error');
                        return false;
                    }else{*/
                        var selected_id_array=[];
                        // Iterate over all selected checkboxes
                        $.each(rows_selected, function(index, rowId){
                            console.log(rowId);
                            selected_id_array.push(rowId);
                            // Create a hidden element
                            /*$(form).append(
                             $('<input>')
                             .attr('type', 'hidden')
                             .attr('name', 'id[]')
                             .val(rowId)
                             );*/
                        });
                        //Delete Selected
                        ExportData(selected_id_array);
                        console.log(selected_id_array);
                    // }

                });
        }
    });
    $('.action_export').click(function() {
            $('#data-table-4').submit();
        })
       
    function change_status(a_object){

        var status = $(a_object).data("status");
        var id = $(a_object).data("id");
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
                    list_table_one.ajax.reload(null, false); //reload datatable ajax
                    toastr.success('{{ __('message_lang.STATUS_CHANGED_SUCCESSFULLY') }}', 'Success');
                } else {
                    toastr.error('{{ __('message_lang.FAILED_TO_UPDATE_STATUS') }}', 'Error');
                }
            }
        });
    }
    function filterByDeliveryType()
    {
        list_table_one.ajax.reload();
    }

    function ExportData()
    {
        var delivery_type = $('#delivery_type').val();
        
        $.ajax({
          type :"POST",
          url : "{{route('admin-orders-export')}}",
          data : { 
            delivery_type : delivery_type ,
            // checked_ids_arr: selected_id_array,
            _token: '{{csrf_token()}}',
          },
          success: function(result, status, xhr) {
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'OrdersReport.csv');

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