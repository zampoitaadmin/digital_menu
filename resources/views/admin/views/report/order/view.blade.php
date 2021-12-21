@extends("admin.layouts.layout")

@section("title")
    Report Order View
@endsection

@section("page_style")
    
@endsection

<!--  Note : if you do changes any king in order view blade please do copy same in mail blade file -->

@section("content")

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-report-order-list') }}">Report Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Order View</li>
                </ol>
            </nav>

            <div class="ms-panel" id="printArea">
                <div class="ms-panel-header header-mini">
                    <div class="d-flex justify-content-between">
                        <h6>Report Order View</h6>
                    </div>
                </div>
                <div class="ms-panel-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section("page_vendors")
@endsection
    
@section("page_script")
    <script>
        function change_status(a_object){
            var status = $(a_object).data("status");
            var id = $(a_object).data("id");
            $.ajax({
                "url": "{!! route('admin-report-order-change-status') !!}",
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
        }
    </script>
@endsection