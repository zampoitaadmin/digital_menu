
<style type="text/css">
    /*.error{
        color: red;
    }*/
    /*[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-hide-animate) {
        display: unset !important;
    }*/
</style>
<div role="tabpanel" class="tab-pane active" id="categories">
    <div class="container">
        <div class="row  ">
            <div class="col-lg-2 col-md-12 right-box">
                @include('front.views.custom-menu._left_side_categories')
            </div>
            <div class="col-lg-10 col-md-12 left-box">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card single_post">
                            <div class="body p-5 justify-content-center d-flex" style="background: url(assets/images/section_bg.png) center no-repeat; background-size: cover;">
                                <div class="img-post mb-0">
                                    <button class="box-btn btn btn_custom_for_only_color m-5 forFontFamilyOnly" id="chooseCategory" ng-click="categorySubSectionChange('chooseCategory')">
                                        <a href="javascript:void(0)" class="text-white"><?= __('message_lang.category_text_2'); ?></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card single_post">
                            <div class="body p-5 justify-content-center d-flex" style="background: url(assets/images/section_bg.png) center no-repeat; background-size: cover;">
                                <div class="img-post mb-0">
                                    <button class="box-btn btn btn_custom_for_only_color m-5 forFontFamilyOnly" id="createdOwnCategory" ng-click="categorySubSectionChange('createOwnCategory')">
                                        <a href="javascript:void(0)" class="text-white"><?= __('message_lang.category_text_3'); ?></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 left-box" ng-if="categorySubSection=='chooseCategory'">
                        <div class="card text-center">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?= __('message_lang.category_text_4'); ?></h5> {{--Select Your Category--}}
                            </div>
                            <div class="card-body" >
                                {{--ng-if="loaderCategory" --}}
                                <span class="loaderCategory bb-loader" ng-bind-html="loaderCategory" ng-if="loaderCategory.length>0"></span>
                                <div class="cat action" ng-repeat="category in categories" ng-if="categories.length>0">
                                    {{--<label>
                                        <input type="checkbox" value="@{{ category.name }}" ng-checked="userCategoryIdsArray.indexOf(@{{ category.id }}) > -1" ><span ng-class="{'greenColor': userCreatedCategoryIdsArray.indexOf(@{{ category.id }}) > -1}" >@{{ category.name }}</span>
                                    </label>--}}
                                    <label>
                                        <input type="checkbox" value="@{{ category.id }}" ng-checked="userCategoryIdsArray.indexOf(@{{ category.id }}) > -1" ng-click="checkUnCheckCategoryFun(userCategoryIdsArray,category.id)">
                                            <span ng-class="{'greenColor': userCreatedCategoryIdsArray.indexOf(category.id) > -1}" >@{{ category.name }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-footer" ng-if="categories.length>0">
                                <button type="button" class="btn btn-dark my-1 w-25" ng-click="assignCategoryToUserFun()"><?= __('common.btn_submit'); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 left-box" ng-if="categorySubSection=='chooseCategory'">
                        <div class="card text-center">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?= __('message_lang.category_text_5'); ?></h5> {{--Your Selected Category--}}
                            </div>
                            <span class="loaderUserCategory bb-loader" ng-bind-html="loaderUserCategory" ng-if="loaderUserCategory.length>0"></span>
                            <div class="card-body" ng-if="userCategories.length>0">
                                <div class="btn-group m-1" ng-repeat="category in userCategories" ng-if="userCategories.length>0">
                                    <div class="btn-group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-del_edt btn_custom_for_only_color">
                                            @{{ category.name }}
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-del_edt btn_custom_for_only_color" ng-click="deleteRecordFun(category)"><i class="fa fa-trash text-danger"></i></button>
                                    <button type="button" class="btn btn-del_edt btn_custom_for_only_color" ng-click="showRecordFun(category)"><i class="fa fa-pencil-square-o text-light"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 left-box" ng-if="categorySubSection=='createOwnCategory'">
                        <div class="card text-center">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?= __('message_lang.category_text_6'); ?></h5>
                            </div>
                            <form name="frmAddCategory" id="frmAddCategory" novalidate autocomplete="off">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control my-1" name="categoryNameSp" ng-model="formCrudRequestData.categoryNameSp" placeholder="<?= __('message_lang.form_input_placeholder',['formInput'=>__('message_lang.form_input_categorySP')]); ?>" required>
                                            <span ng-show="frmAddCategory.$submitted || frmAddCategory.categoryNameSp.$dirty">
                                                <span class="validationMessageClass" ng-show="frmAddCategory.categoryNameSp.$error.required"><?= __('common.validation_message_required'); ?></span>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control my-1" name="categoryNameEn" ng-model="formCrudRequestData.categoryNameEn" placeholder="<?= __('message_lang.form_input_placeholder',['formInput'=>__('message_lang.form_input_category')]); ?>" required>
                                            <span ng-show="frmAddCategory.$submitted || frmAddCategory.categoryNameEn.$dirty">
                                                <span class="validationMessageClass" ng-show="frmAddCategory.categoryNameEn.$error.required"><?= __('common.validation_message_required'); ?></span>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="validationMessageClass" ng-if="formCrudRequestErrors.message" > @{{ formCrudRequestErrors.message}}</p>
                                    {{--<button type="submit" class="btn btn-dark my-1 w-25" name="btnSubmit" ng-click="createCategoryFun(frmAddCategory.$valid);"><?= __('common.btn_submit'); ?></button>--}}
                                </div>
                                <div class="card-footer" >
                                    <button type="submit" class="btn btn-dark my-1 w-25" name="btnSubmit" ng-click="createRecordFun(frmAddCategory.$valid);"><?= __('common.btn_submit'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODEL --}}
<div class="modal fade" id="updateModel" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= __('message_lang.category_text_7'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form name="frmUpdateCategory" id="frmUpdateCategory" novalidate autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email1"><?= ucfirst(__('message_lang.form_input_categorySP')); ?></label>
                        <input type="text" class="form-control my-1" name="categoryNameSp" ng-model="formCrudRequestData.categoryNameSp" placeholder="<?= __('message_lang.form_input_placeholder',['formInput'=>__('message_lang.form_input_categorySP')]); ?>" required>
                        <span ng-show="frmUpdateCategory.$submitted || frmUpdateCategory.categoryNameSp.$dirty">
                                                <span class="validationMessageClass" ng-show="frmUpdateCategory.categoryNameSp.$error.required || formCrudRequestErrors.categoryNameSp"><?= __('common.validation_message_required'); ?></span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email1"><?= ucfirst(__('message_lang.form_input_category')); ?></label>
                        <input type="text" class="form-control my-1" name="categoryNameEn" ng-model="formCrudRequestData.categoryNameEn" placeholder="<?= __('message_lang.form_input_placeholder',['formInput'=>__('message_lang.form_input_category')]); ?>" required>
                        <span ng-show="frmUpdateCategory.$submitted || frmUpdateCategory.categoryNameEn.$dirty">
                                                <span class="validationMessageClass" ng-show="frmUpdateCategory.categoryNameEn.$error.required  || formCrudRequestErrors.categoryNameEn"><?= __('common.validation_message_required'); ?></span>
                        </span>
                    </div>
                    <p class="validationMessageClass" ng-if="formCrudRequestErrors.message" > @{{ formCrudRequestErrors.message}}</p>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-dark my-1 w-25" name="btnSubmit" ng-click="updateRecordFun(frmUpdateCategory.$valid);"><?= __('common.btn_submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

