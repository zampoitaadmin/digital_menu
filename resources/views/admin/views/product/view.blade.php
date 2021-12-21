@extends("admin.layouts.layout")

@section("title")
    View Product
@endsection

@section("page_style")
    <link href="{{url('assets/css/slick.css')}}" rel="stylesheet">
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="new">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="material-icons">home</i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-product-list') }}">Product</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product View</li>
                </ol>
            </nav>
        </div>
            
        <div class="col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header">
                    <div class="d-flex justify-content-between">
                        <div class="align-self-center align-left">
                            <h6>View {{ $data->name ?? '' }}</h6>
                        </div>
                    <a href="{{ route('admin-product-list') }}" class="btn btn-square btn-gradient-dark">Back</a>
                </div>
                
                <div></div>
                
                <div class="row">
                    <div class="col-xl-5 col-md-12">
                        <div class="ms-panel ms-panel-fh">
                            <div class="ms-panel-body">
                                <img src="{{ $data->image }}" data-default="{{url('uploads/default/100_no_img.jpg')}}" onerror="if ( ! this.getAttribute('data-load-error') ){ this.setAttribute('data-load-error', '1');this.setAttribute('src', this.getAttribute('data-default'));}" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-md-12">
                        <div class="ms-panel ms-panel-fh">
                            <div class="ms-panel-body">
                                <table class="table ms-profile-information">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{!! $data->name ?? '' !!}</td>
                                        </tr>
                                        <!-- <tr>
                                            <th scope="row">Category</th>
                                            <td>{!! $data->category_ids ?? '' !!}</td>
                                        </tr> -->
                                        <tr>
                                            <th scope="row">Price</th>
                                            <td>{!! $data->price ?? '' !!}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Size</th>
                                            <td>{!! $data->size ?? '' !!}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Finish</th>
                                            <td>{!! $data->finish ?? '' !!}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Colour</th>
                                            <td>{!! $data->colour ?? '' !!}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status</th>
                                            <td>
                                            @if($data->status ==config('constants.product_status.ACTIVE'))
                                            <span class="badge badge-gradient-success">Active</span>
                                            @elseif($data->status ==config('constants.product_status.INACTIVE'))
                                            <span class="badge badge-gradient-warning">Inactive</span>
                                            @elseif($data->status ==config('constants.product_status.DELETED'))
                                            <span class="badge badge-gradient-danger">Deleted</span>
                                            @else
                                                -
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Description</th>
                                            <td>{!! $data->description ?? '' !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>   
        </div>
    </div>
@endsection

@section("page_vendors")
@endsection

@section("page_script")
@endsection