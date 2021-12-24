
<div role="tabpanel" class="tab-pane active show1 " id="setting">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body px-3 py-3">

                        <div class="text-center" id="store-list" ng-if="loaderSetting.length>0">
                            <span class="loaderSetting bb-loader text-center" ng-bind-html="loaderSetting" ></span>
                        </div>
                        <div class="row bootstrap snippets bootdeys" id="store-list" ng-if="loaderSetting.length==0">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <h5 class="card-title mx-2"><?= __('message_lang.setting_website_template'); ?>{{--Active Menu In Website Template--}}</h5>
                                    {{--<div class="custom-control custom-switch text-success ">
                                        <input type="checkbox" class="custom-control-input custom-switch-success" id="customSwitch1" value="1">
                                        <label class="custom-control-label custom-control-label-success" for="customSwitch1"></label>
                                    </div>--}}
                                    <div class="item">
                                        <switch name="isActiveWebsiteTemplate" ng-model="requestDataSetting.isActiveWebsiteTemplate" on="Yes" off="No" class="wide "></switch>
                                    </div>
                                </div>
                                <div ng-if="requestDataSetting.isActiveWebsiteTemplate">
                                <small id="emailHelp" class="form-text text-muted"><?= __('message_lang.setting_url_externally'); ?>{{--use the below URL to link your menu extranally--}}
                                    <button type="button" class="btn btn-sm btn-secondary p-0" data-toggle="tooltip" data-placement="top" title="Use this link for:
- Facebook / Instagram / Google etc
- Your own website (simply provide this URL to our web developers)"><i class="fa fa-question-circle" aria-hidden="true" style="color: #fff;"></i></button>
                                </small>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="websiteURL"  ng-model="requestDataSetting.websiteURL"   readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button" ng-click="copyURLFun()"><?= __('common.btn_copy'); ?></button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title"><?= __('message_lang.setting_delivery_info_text'); ?>{{--Enter Your Delivery Information Below--}}</h5>
                                <form>
                                    <div class="form-group row">
                                        <label  class="col-sm-7 col-form-label"><?= __('message_lang.setting_standard_delivery_charge'); ?>{{--Standard Delivery Charge--}} : </label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control"  ng-model="requestDataSetting.standardDeliveryCharge">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-7 col-form-label"><?= __('message_lang.setting_minimum_delivery_charge'); ?>{{--Minimum Order For Delivery--}} :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" ng-model="requestDataSetting.minimumDeliveryCharge">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-7 col-form-label"><?= __('message_lang.setting_free_delivery_charge'); ?>{{--Free Delivery Charge on Order Over--}} :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" ng-model="requestDataSetting.freeDeliveryCharge" >
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex flex-row-center mb-0">
                                        <div class="col-sm-6 ">
                                            <button type="button" class="btn btn_custom_for_only_color" ng-click="updateUserSettingFun()"><?= __('common.btn_submit'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>