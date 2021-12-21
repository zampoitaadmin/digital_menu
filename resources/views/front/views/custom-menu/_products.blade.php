<div role="tabpanel" class="tab-pane active show1" id="products">
    <div class="container">
        <div class="row  ">
            <div class="col-lg-2 col-md-12 right-box">
                @include('front.views.custom-menu._left_side_categories')
                {{--<div class="card bg-transparent d-sm-none d-md-block d-none d-sm-block">
                    <div class="body widget text-center py-1 px-1 ">
                        <ul class="list-unstyled categories-clouds mb-0">
                            <li class="w-100"><a href="javascript:void(0);" class="btn_custom_for_only_color">eCommerce</a></li>
                            <li class="w-100"><a href="javascript:void(0);" class="btn_custom_for_only_color">Creative UX</a></li>
                            <li class="w-100"><a href="javascript:void(0);" class="btn_custom_for_only_color">Wordpress</a></li>
                            <li class="w-100"><a href="javascript:void(0);" class="btn_custom_for_only_color">Angular JS</a></li>
                            <li class="w-100"><a href="javascript:void(0);" class="btn_custom_for_only_color">HTML5</a></li>
                            <li class="w-100"><a href="javascript:void(0);" class="btn_custom_for_only_color">Infographics </a></li>
                        </ul>
                    </div>
                </div>
                <div class="justify-content-center d-flex m-4 d-block d-sm-none">
                    <button type="button" class="btn btn_custom_for_only_color" data-toggle="modal" data-target="#exampleModal">
                        Select Your Cetegory
                    </button>
                </div>--}}
            </div>
            <div class="col-lg-10 col-md-12 left-box">
                <div class="row">
                    <div class="col-md-12">
                        <div id="main">
                            <div class="accordion" id="faq">
                                <div class="card">
                                    <div class="card-header" id="faqhead1">
                                        <a href="#" class="btn btn-header-link " data-toggle="collapse" data-target="#faq1"
                                           aria-expanded="true" aria-controls="faq1">Deserts</a>
                                    </div>
                                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                                        <div class="card-body px-3 py-1">
                                            <div class="row bootstrap snippets bootdeys" id="store-list">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-sm-3 pb-3">
                                                                    <a href="#">
                                                                        <img src="assets/images/p-1.jpg"  class="img-fluid img-thumbnail rounded h-100">
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <h4 class="title-store">
                                                                        <strong>
                                                                            <a href="#">
                                                                                MENU ITEM NO :
                                                                                <div class="btn-group" role="group" aria-label="Third group">
                                                                                    <button type="button" class="btn btn-del_edt mb-1">8</button>
                                                                                </div>
                                                                            </a>
                                                                        </strong>
                                                                    </h4>
                                                                    <div class="pull-right">
                                                                        <button type="button" class="btn btn-sm btn-primary mb-1">
                                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-warning mb-1">
                                                                            <i class="fa fa-archive" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-danger mb-1">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                    <h6 class="m-0">Lorem Ipsum</h6>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    </p>
                                                                    <p>
                                                                    <p class="my-2"><b>Allergy items selected</b></p>
                                                                    <button type="button" class="p-0 btn btn-outline-info">
                                                                        <img src="https://betagit.zampoita.com/assets/allergy/soja.png" class="img-fluid" width="30" height="30">
                                                                    </button>
                                                                    <a href="#" class="btn btn_custom_for_only_color pull-right mx-1" data-original-title="" title="">€25.00</a>
                                                                    <a href="#" class="btn btn_custom_for_only_color pull-right mx-1" data-original-title="" title="">€2.00</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="faqhead2">
                                        <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2"
                                           aria-expanded="true" aria-controls="faq2">Teast-2</a>
                                    </div>
                                    <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                                        <div class="card-body px-3 py-1">
                                            <div class="row bootstrap snippets bootdeys" id="store-list">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-sm-3  pb-3">
                                                                    <a href="#">
                                                                        <img src="assets/images/p-1.jpg" class="img-fluid img-thumbnail rounded h-100">
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <h4 class="title-store">
                                                                        <strong>
                                                                            <a href="#">
                                                                                MENU ITEM NO :
                                                                                <div class="btn-group" role="group" aria-label="Third group">
                                                                                    <button type="button" class="btn btn-del_edt mb-1">8</button>
                                                                                </div>
                                                                            </a>
                                                                        </strong>
                                                                    </h4>
                                                                    <div class="pull-right">
                                                                        <button type="button" class="btn btn-sm btn-primary mb-1">
                                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-warning mb-1">
                                                                            <i class="fa fa-archive" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-danger mb-1">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                    <h6 class="m-0">Lorem Ipsum</h6>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    </p>
                                                                    <p>
                                                                    <p class="my-2"><b>Allergy items selected</b></p>
                                                                    <button type="button" class="p-0 btn btn-outline-info">
                                                                        <img src="https://betagit.zampoita.com/assets/allergy/soja.png" class="img-fluid" width="30" height="30">
                                                                    </button>
                                                                    <a href="#" class="btn btn_custom_for_only_colo pull-right mx-1" data-original-title="" title="">€25.00</a>
                                                                    <a href="#" class="btn btn_custom_for_only_colo pull-right mx-1" data-original-title="" title="">€2.00</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="faqhead3">
                                        <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3"
                                           aria-expanded="true" aria-controls="faq3">Test-3</a>
                                    </div>
                                    <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                                        <div class="card-body px-3 py-1">
                                            <div class="row bootstrap snippets bootdeys" id="store-list">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <a href="#">
                                                                        <img src="https://media.istockphoto.com/photos/varied-food-carbohydrates-protein-vegetables-fruits-dairy-legumes-on-picture-id1218254547?b=1&k=6&m=1218254547&s=170667a&w=0&h=EXwwoHJ3wI0H2jDfoFhqOiIo2c4cL0y7R8Gop3iIO30=" class="img-responsive product-img">
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <h4 class="title-store">
                                                                        <strong>
                                                                            <a href="#">
                                                                                MENU ITEM NO :
                                                                                <div class="btn-group" role="group" aria-label="Third group">
                                                                                    <button type="button" class="btn btn-del_edt mb-1">8</button>
                                                                                </div>
                                                                            </a>
                                                                        </strong>
                                                                    </h4>
                                                                    <div class="pull-right">
                                                                        <button type="button" class="btn btn-sm btn-primary mb-1">
                                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-warning mb-1">
                                                                            <i class="fa fa-archive" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-danger mb-1">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                    <h6 class="m-0">Lorem Ipsum</h6>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    </p>
                                                                    <p>
                                                                    <p class="my-2"><b>Allergy items selected</b></p>
                                                                    <button type="button" class="p-0 btn btn-outline-info">
                                                                        <img src="https://betagit.zampoita.com/assets/allergy/soja.png" class="img-fluid" width="30" height="30">
                                                                    </button>
                                                                    <a href="#" class="btn btn_custom_for_only_colo pull-right mx-1" data-original-title="" title="">€25.00</a>
                                                                    <a href="#" class="btn btn_custom_for_only_colo pull-right mx-1" data-original-title="" title="">€2.00</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 left-box">
                        <form class="p-4 bg-white card">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Add Product</h4>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-del_edt pull-right">Add Product</button>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Category</label>
                                    <select class="form-control">
                                        <option selected>Choose...</option>
                                        <option>Category-1</option>
                                        <option>Category-2</option>
                                        <option>Category-3</option>
                                        <option>Category-4</option>
                                        <option>Category-5</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Product Name</label>
                                    <input type="email" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product Description</label>
                                    <textarea class="form-control" aria-label="With textarea"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Upload File</label>
                                <div class="preview-zone hidden">
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Choose an image file or drag it here.</p>
                                    </div>
                                    <input type="file" name="img_logo" class="dropzone">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="inputState">Product Price  </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Tapa</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>Choose...1</option>
                                        <option>Choose...2</option>
                                        <option>Choose...3</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">1/2 R</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>Choose...1</option>
                                        <option>Choose...2</option>
                                        <option>Choose...3</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">1 R</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>Choose...1</option>
                                        <option>Choose...2</option>
                                        <option>Choose...3</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Fixed</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>Choose...1</option>
                                        <option>Choose...2</option>
                                        <option>Choose...3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Allergy</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn btn_custom_for_only_color">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
