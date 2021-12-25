<div role="tabpanel" class="tab-pane active show1" id="products">
    <div class="container">
        <div class="row  ">
            <div class="col-lg-2 col-md-12 right-box">
                @include('front.views.custom-menu._left_side_categories')
            </div>
            <div class="col-lg-10 col-md-12 left-box">
                <div class="row">
                    <div class="col-md-12">
                        <div id="main">
                           <div class="pull-right">
                                <div class="btn btn-success my-2" ng-click="openAddProductModal()">Add Product</div>
                            <div class="btn btn-success my-2" ng-click="openAddProductModal()">Add Product</div>
                            <div class="btn btn-success my-2" ng-click="openAddProductModal()">Add Product</div>
                            <div class="btn btn-success my-2" ng-click="openAddProductModal()">Add Product</div>
                            <div class="btn btn-success my-2" ng-click="openAddProductModal()">Add Product</div>
                            <div class="btn btn-success my-2" ng-click="openAddProductModal()">Add Product</div>
                           </div>
                            <span class="loaderProduct bb-loader" ng-bind-html="loaderProduct" ng-if="loaderProduct.length>0"></span>
                            <div class="accordion" id="faq">
                                <div class="card" style="background: none" ng-repeat="categoryProduct in userSelectedCategoriesProducts">
                                    <div class="card-header">
                                        <a href="#@{{ categoryProduct.slug }}" class="btn btn-header-link collapsed" data-toggle="collapse">@{{ categoryProduct.name }}</a>
                                    </div>
                                    <div id="@{{ categoryProduct.slug }}" class="collapse" data-parent="#faq">
                                        <div class="card-body px-3 py-1">
                                            <div class="row bootstrap snippets bootdeys" id="store-list" ng-repeat="productInfo in categoryProduct.responseProducts">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-sm-3 pb-3">
                                                                    <a href="#">
                                                                        <img src="{{ _betagitZampoitaWebUrl('assets/products/').'/' }}@{{ productInfo.product_main_image }}"  class="img-fluid img-thumbnail rounded h-100" onerror="this.onerror=null;this.src='{{ _betagitZampoitaWebUrl('assets/default/100_no_img.jpg') }}';">
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <h4 class="title-store">
                                                                        <strong>
                                                                            <a href="#">
                                                                                {{ __('message_lang.product_text_1') }} :
                                                                                <div class="btn-group" role="group" aria-label="Third group">
                                                                                    <button type="button" class="btn btn-del_edt mb-1">@{{ productInfo.product_order }}</button>
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
                                                                    <h6 class="m-0">@{{ productInfo.product_name }}</h6>
                                                                    <p>
                                                                        @{{ productInfo.product_description }}
                                                                    </p>
                                                                    <p>
                                                                    <p class="my-2" ng-if="productInfo.responseAllergies.length"><b>Allergy items selected</b></p>
                                                                    <div ng-repeat="allergyInfo in productInfo.responseAllergies">
                                                                        <button type="button" class="p-0 btn btn-outline-info">
                                                                            <img src="{{ _betagitZampoitaWebUrl('assets/allergy/').'/' }}@{{ allergyInfo.image }}" class="img-fluid" width="30" height="30" onerror="this.onerror=null;this.src='{{ _betagitZampoitaWebUrl('assets/default/100_no_img.jpg') }}';">
                                                                        </button>
                                                                    </div>
                                                                    <a href="javascript:void(0)" class="btn btn_custom_for_only_color pull-right mx-1" data-original-title="" title="Fixed Price">{{ config('constants.currency') }}@{{ productInfo.product_price }}</a>

                                                                    <a href="javascript:void(0)" class="btn btn_custom_for_only_color pull-right mx-1" data-original-title="" title="1 R">{{ config('constants.currency') }}@{{ productInfo.product_1r }}</a>

                                                                    <a href="javascript:void(0)" class="btn btn_custom_for_only_color pull-right mx-1" data-original-title="" title="1/2 R">{{ config('constants.currency') }}@{{ productInfo.product_12r }}</a>

                                                                    <a href="javascript:void(0)" class="btn btn_custom_for_only_color pull-right mx-1" data-original-title="" title="Tapa">{{ config('constants.currency') }}@{{ productInfo.product_topa }}</a>
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
                    <!-- <div class="col-lg-12 col-md-12 left-box">
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
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModel" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= __('message_lang.product_text_2'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form name="frmAddProduct" id="frmAddProduct" novalidate autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email1"><?= ucfirst(__('message_lang.form_input_categorySP')); ?></label>
                        <input type="text" class="form-control my-1" name="categoryNameSp" ng-model="formCrudRequestData.categoryNameSp" placeholder="<?= __('message_lang.form_input_placeholder',['formInput'=>__('message_lang.form_input_categorySP')]); ?>" required>
                        <span ng-show="frmAddProduct.$submitted || frmAddProduct.categoryNameSp.$dirty">
                                                <span class="validationMessageClass" ng-show="frmAddProduct.categoryNameSp.$error.required || formCrudRequestErrors.categoryNameSp">This field is required.</span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email1"><?= ucfirst(__('message_lang.form_input_category')); ?></label>
                        <input type="text" class="form-control my-1" name="categoryNameEn" ng-model="formCrudRequestData.categoryNameEn" placeholder="<?= __('message_lang.form_input_placeholder',['formInput'=>__('message_lang.form_input_category')]); ?>" required>
                        <span ng-show="frmAddProduct.$submitted || frmAddProduct.categoryNameEn.$dirty">
                                                <span class="validationMessageClass" ng-show="frmAddProduct.categoryNameEn.$error.required  || formCrudRequestErrors.categoryNameEn">This field is required.</span>
                        </span>
                    </div>
                    <p class="validationMessageClass" ng-if="formCrudRequestErrors.message" > @{{ formCrudRequestErrors.message}}</p>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-dark my-1 w-25" name="btnSubmit" ng-click="updateRecordFun(frmAddProduct.$valid);"><?= __('common.btn_submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>