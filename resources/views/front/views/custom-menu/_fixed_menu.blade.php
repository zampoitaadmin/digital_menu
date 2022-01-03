<div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form name="frmFixedMenu" id="frmFixedMenu" novalidate autocomplete="off" class="p-4 bg-white card" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<h4>{{ __('message_lang.lbl_fixed_menu') }}</h4>
						</div>
						<div class="col-md-6 text-right">
							<button type="button" class="btn btn btn_custom_for_only_color"><a href="custom-menu#products" class="text-white">{{ __('common.lbl_back') }}</a></button>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>{{ __('message_lang.lbl_category') }}</label>
							<input type="text" name="categoryName" ng-model="requestDataFixedMenu.categoryName" class="form-control" disabled>
						</div>
						<div class="form-group col-md-6">
							<label>{{ __('message_lang.lbl_change_category_name') }}</label>
							<input type="text" name="changeCategoryName" ng-model="requestDataFixedMenu.changeCategoryName" class="form-control">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>{{ __('message_lang.lbl_menu_description_conditions') }}</label>
							<textarea class="form-control" name="menuDescriptionConditions" ng-model="requestDataFixedMenu.menuDescriptionConditions" required></textarea>
                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.menuDescriptionConditions.$dirty">
                                <span class="validationMessageClass" ng-show="frmFixedMenu.menuDescriptionConditions.$error.required || formCrudRequestErrors.menuDescriptionConditions"><?= __('common.validation_message_required'); ?></span>
                            </span>
						</div>
					</div>

					<hr>
					<h5>{{ __('message_lang.lbl_starters') }}</h5>
					<hr>
					<div data-ng-repeat="starter in starters">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_name') }}</label>
								<input type="text" name="productName" ng-model="starter.productName" class="form-control" required>
	                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.productName.$dirty">
	                                <span class="validationMessageClass" ng-show="frmFixedMenu.productName.$error.required || formCrudRequestErrors.productName"><?= __('common.validation_message_required'); ?></span>
	                            </span>
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_allergy') }}</label>
								<select class="form-control" select2="" name="allergyId" data-ng-model="starter.allergyId" ng-options="allergy.id as allergy.name for allergy in allAllergies" multiple>
	                                <option value="">{{ __('message_lang.lbl_select_allergy') }}</option>
	                            </select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label"><?= ucfirst(__('message_lang.lbl_upload_file')); ?></label>
		                        <!-- <div class="dz-default dz-message dropzoneDragArea dropzoneDragAreaStarter">
		                            <span>{{ __('message_lang.lbl_upload_file') }}</span>
		                        </div>
		                        <div class="dropzone-previews"></div> -->
		                        <!-- <input type="file" file-input="files" name="starterProductMainImage" class="dropify" /> -->
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_description') }}</label>
								<textarea class="form-control" name="productDescription" ng-model="starter.productDescription" required></textarea>
	                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.productDescription.$dirty">
	                                <span class="validationMessageClass" ng-show="frmFixedMenu.productDescription.$error.required || formCrudRequestErrors.productDescription"><?= __('common.validation_message_required'); ?></span>
	                            </span>
							</div>
						</div>
						<button type="button" class="btn btn btn_custom_for_only_color" style="float: right;" ng-if="starters.length>1 && !starters.length!=1" ng-click="removeStarter(starter)">{{ __('common.lbl_remove') }}</button>
						<br><br>
						<button type="button" class="btn btn btn_custom_for_only_color" ng-if="$last" ng-click="addNewStarter()">{{ __('common.lbl_add') }}</button>
					</div>

					<hr>
					<h5>{{ __('message_lang.lbl_main_course') }}</h5>
					<hr>
					<div data-ng-repeat="mainCourse in mainCourses">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_name') }}</label>
								<input type="text" name="productName" ng-model="mainCourse.productName" class="form-control" required>
	                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.productName.$dirty">
	                                <span class="validationMessageClass" ng-show="frmFixedMenu.productName.$error.required || formCrudRequestErrors.productName"><?= __('common.validation_message_required'); ?></span>
	                            </span>
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_allergy') }}</label>
								<select class="form-control" select2="" name="allergyId" data-ng-model="mainCourse.allergyId" ng-options="allergy.id as allergy.name for allergy in allAllergies" multiple>
	                                <option value="">{{ __('message_lang.lbl_select_allergy') }}</option>
	                            </select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label"><?= ucfirst(__('message_lang.lbl_upload_file')); ?></label>
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_description') }}</label>
								<textarea class="form-control" name="productDescription" ng-model="mainCourse.productDescription" required></textarea>
	                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.productDescription.$dirty">
	                                <span class="validationMessageClass" ng-show="frmFixedMenu.productDescription.$error.required || formCrudRequestErrors.productDescription"><?= __('common.validation_message_required'); ?></span>
	                            </span>
							</div>
						</div>
						<button type="button" class="btn btn btn_custom_for_only_color" style="float: right;" ng-if="mainCourses.length>1 && !mainCourses.length!=1" ng-click="removeMainCourse(mainCourse)">{{ __('common.lbl_remove') }}</button>
						<br><br>
						<button type="button" class="btn btn btn_custom_for_only_color" ng-if="$last" ng-click="addNewMainCourse()">{{ __('common.lbl_add') }}</button>
					</div>

					<hr>
					<h5>{{ __('message_lang.lbl_deserts') }}</h5>
					<hr>
					<div data-ng-repeat="desert in deserts">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_name') }}</label>
								<input type="text" name="productName" ng-model="desert.productName" class="form-control" required>
	                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.productName.$dirty">
	                                <span class="validationMessageClass" ng-show="frmFixedMenu.productName.$error.required || formCrudRequestErrors.productName"><?= __('common.validation_message_required'); ?></span>
	                            </span>
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_allergy') }}</label>
								<select class="form-control" select2="" name="allergyId" data-ng-model="desert.allergyId" ng-options="allergy.id as allergy.name for allergy in allAllergies" multiple>
	                                <option value="">{{ __('message_lang.lbl_select_allergy') }}</option>
	                            </select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label"><?= ucfirst(__('message_lang.lbl_upload_file')); ?></label>
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_description') }}</label>
								<textarea class="form-control" name="productDescription" ng-model="desert.productDescription" required></textarea>
	                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.productDescription.$dirty">
	                                <span class="validationMessageClass" ng-show="frmFixedMenu.productDescription.$error.required || formCrudRequestErrors.productDescription"><?= __('common.validation_message_required'); ?></span>
	                            </span>
							</div>
						</div>
						<button type="button" class="btn btn btn_custom_for_only_color" style="float: right;" ng-if="deserts.length>1 && !deserts.length!=1" ng-click="removeDesert(desert)">{{ __('common.lbl_remove') }}</button>
						<br><br>
						<button type="button" class="btn btn btn_custom_for_only_color" ng-if="$last" ng-click="addNewDesert()">{{ __('common.lbl_add') }}</button>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4 offset-4">
							<label>{{ __('message_lang.lbl_fixed_menu_price') }}</label>
							<input type="number" name="fixedMenuPrice" ng-model="requestDataFixedMenu.fixedMenuPrice" class="form-control" required>
                            <span ng-show="frmFixedMenu.$submitted || frmFixedMenu.fixedMenuPrice.$dirty">
                                <span class="validationMessageClass" ng-show="frmFixedMenu.fixedMenuPrice.$error.required || formCrudRequestErrors.fixedMenuPrice"><?= __('common.validation_message_required'); ?></span>
                            </span>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-5 offset-5">
							<button type="submit" class="btn btn-dark my-1 w-25" name="btnSubmit" ng-click="fixedMenuRecordFun(frmFixedMenu.$valid);"><?= __('common.btn_submit'); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>