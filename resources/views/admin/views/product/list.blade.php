@extends("admin.layouts.layout")

@section("title", "Product List")

@section("page_style")
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/custom_table_css.css') }}">
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="new">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="material-icons">home</i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-product-list') }}">Product</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product List</li>
                </ol>
            </nav>
          
            <div class="ms-panel">
                <div class="ms-panel-header">
                    <div class="d-flex justify-content-between">
                        <div class="align-self-center align-left">
                            <h6>Product</h6>
                        </div>
                        <a href="{{ route('admin-product-add') }}" class="btn btn-square btn-gradient-success">Add Product</a>
                    </div>
                </div>

                <div class="ms-panel-body">
                    <div class="table-responsive">
                        <table id="data-table-4" class="table w-100 thead-primary nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <!-- <th>Catagories</th> -->
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
        $(document).ready(function() {
            if($('#data-table-4').length > 0){
                list_table_one = $('#data-table-4').DataTable({
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
                    
                    "ajax":{
                        "url": "{{ route('admin-product-lists') }}",
                        "type": "POST",
                        "dataType": "json",
                        "data":{
                            _token: "{{csrf_token()}}"
                        }
                    },
                    "columnDefs": [
                        {
                            "targets": [0,5], //first column / numbering column
                            "orderable": false, //set not orderable
                        }
                    ],
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            sortable:false
                        },
                        {
                            data: 'image',
                            name: 'image'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        // {
                        //     data: 'category_ids',
                        //     name: 'category_ids'
                        // },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            sortable:false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            sortable:false
                        }
                    ]
                });
            }
        });
    
        function change_status(a_object){
            var status = $(a_object).data("status");
            var id = $(a_object).data("id");
            $.ajax({
                "url": "{!! route('admin-product-change-status') !!}",
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
                        toastr.success('status changed successfully.', 'Success');
                    }else{
                        toastr.error('something went wrong.', 'Error');
                    }
                }
            });
        }
    </script>
@endsection