@extends("admin.layouts.layout")

@section("title", "Settings")

@section("page_style")
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/datatables.min.css') }}">
    <link href="{{ url('ex_plugins/dropify-master/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section("content")
    <!-- Body Content Wrapper -->  
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="new">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('setting-list') }}">Settings</a></li>
                </ol>
            </nav>

            <div class="ms-panel">
                <div class="ms-panel-header">
                    <div class="d-flex justify-content-between">
                        <div class="align-self-center align-left">
                            <h6>Settings</h6>
                        </div>
                    </div>
                </div>
            
                <ul class="nav nav-tabs tabs-bordered d-flex nav-justified mb-4" role="tablist">
                    <li role="presentation" class="mt-3"><a href="#tab1" aria-controls="tab1" class="active show" role="tab" data-toggle="tab"> General Setting </a></li>
                    <li role="presentation" class="mt-3"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"> Email Setting </a></li>
                    <li role="presentation" class="mt-3"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"> Social Setting </a></li>
                    <li role="presentation" class="mt-3"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"> Sms Settings </a></li>
                    <li role="presentation" class="mt-3"><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab"> Payment Settings </a></li>
                    <li role="presentation" class="mt-3"><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab"> Logo Settings </a></li>
                </ul>

                <div class="col-md-12">  
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active show fade in" id="tab1">
                            <form action="{{ route('setting-update') }}" method="post">
                                @csrf
                                @if(!empty($generals) && isset($generals) && count($generals) > 0)
                                    @foreach($generals as $row)
                                        <div class="form-row m-1">
                                            <div class="col-md-12 mb-3">
                                                <label for="first_name">{{ $row->key_title }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="{{ $row->key_title }}" name="{{ $row->id }}" placeholder="{{ $row->key_title }}" value="{{ $row->value }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(!empty($generals) && isset($generals) && count($generals) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <button type="submit" style="float: right;" class="btn btn-square btn-gradient-success">Save</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <h3 class="text-center">No Data Found ...!!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab2">
                            <form action="{{ route('setting-update') }}" method="post">
                                @csrf
                                @if(!empty($emails) && isset($emails) && count($emails) > 0)
                                    @foreach($emails as $row)
                                        <div class="form-row m-1">
                                            <div class="col-md-12 mb-3">
                                                <label for="first_name">{{ $row->key_title }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="{{ $row->key_title }}" name="{{ $row->id }}" placeholder="{{ $row->key_title }}" value="{{ $row->value }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(!empty($emails) && isset($emails) && count($emails) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <button type="submit" style="float: right;" class="btn btn-square btn-gradient-success">Save</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <h3 class="text-center">No Data Found ...!!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab3">
                            <form action="{{ route('setting-update') }}" method="post">
                                @csrf
                                @if(!empty($socials) && isset($socials) && count($socials) > 0)
                                    @foreach($socials as $row)
                                        <div class="form-row m-1">
                                            <div class="col-md-12 mb-3">
                                                <label for="first_name">{{ $row->key_title }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="{{ $row->key_title }}" name="{{ $row->id }}" placeholder="{{ $row->key_title }}" value="{{ $row->value }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(!empty($socials) && isset($socials) && count($socials) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <button type="submit" style="float: right;" class="btn btn-square btn-gradient-success">Save</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <h3 class="text-center">No Data Found ...!!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab4">
                            <form action="{{ route('setting-update') }}" method="post">
                                @csrf
                                @if(!empty($smss) && isset($smss) && count($smss) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-sm-2" style="margin: auto; text-align: center;">Live Credentials : </div>
                                        <div class="col-sm-10">
                                            @foreach($smss as $row)
                                                @php 
                                                    $slug = false;
                                                    if(strpos($row->keys, "LIVE") !== false) {
                                                        $slug = true;
                                                    }
                                                @endphp
                                                @if($slug == true)
                                                    <div class="form-row m-1">
                                                        <div class="col-md-4" style="margin: auto;">
                                                            <label for="first_name">{{ $row->key_title }}</label>
                                                        </div>
                                                        <div class="col-md-8" style="margin: auto;">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="{{ $row->key_title }}" name="{{ $row->id }}" placeholder="{{ $row->key_title }}" value="{{ $row->value }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif                                   
                                            @endforeach
                                        </div>
                                    </div>
                                    <div style="border-top: 1px solid black;" class="mt-2 mb-3"></div>
                                    <div class="form-row m-1">
                                        <div class="col-sm-2" style="margin: auto; text-align: center;">Test Credentials : </div>
                                        <div class="col-sm-10">
                                            @foreach($smss as $row)
                                                @php 
                                                    $slug = false;
                                                    if(strpos($row->keys, "TEST") !== false) {
                                                        $slug = true;
                                                    }
                                                @endphp
                                                @if($slug == true)
                                                    <div class="form-row m-1">
                                                        <div class="col-md-4" style="margin: auto;">
                                                            <label for="first_name">{{ $row->key_title }}</label>
                                                        </div>
                                                        <div class="col-md-8" style="margin: auto;">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="{{ $row->key_title }}" name="{{ $row->id }}" placeholder="{{ $row->key_title }}" value="{{ $row->value }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif                                   
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($smss) && isset($smss) && count($smss) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <button type="submit" style="float: right;" class="btn btn-square btn-gradient-success">Save</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <h3 class="text-center">No Data Found ...!!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab5">
                            <form action="{{ route('setting-update') }}" method="post">
                                @csrf
                                @if(!empty($payments) && isset($payments) && count($payments) > 0)
                                    @foreach($payments as $row)
                                        <div class="form-row m-1">
                                            <div class="col-md-12 mb-3">
                                                <label for="first_name">{{ $row->key_title }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="{{ $row->key_title }}" name="{{ $row->id }}" placeholder="{{ $row->key_title }}" value="{{ $row->value }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                
                                @if(!empty($payments) && isset($payments) && count($payments) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <button type="submit" style="float: right;" class="btn btn-square btn-gradient-success">Save</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <h3 class="text-center">No Data Found ...!!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab6">
                            <form action="{{ route('setting-logo-update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($logos) && isset($logos) && count($logos) > 0)
                                    @foreach($logos as $row)
                                        <div class="form-row m-1">
                                            <div class="col-md-12 mb-3">
                                                <label for="first_name">{{ $row->key_title }}</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control dropify" id="{{ $row->key_title }}" name="{{ $row->keys }}" data-show-remove="false" data-default-file="{{ $row->value }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                
                                @if(!empty($logos) && isset($logos) && count($logos) > 0)
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <button type="submit" style="float: right;" class="btn btn-square btn-gradient-success">Save</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row m-1">
                                        <div class="col-md-12 mb-5">
                                            <h3 class="text-center">No Data Found ...!!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("page_vendors")
    <script src="{{ url('ex_plugins/dropify-master/js/dropify.min.js') }}"></script>
    <script src="{{ url('assets/js/promise.min.js') }}"></script>
    <script src="{{ url('assets/js/sweetalert2.min.js') }}"></script>
@endsection

@section("page_script")
    <script>
        $('.dropify').dropify();
    </script>
@endsection