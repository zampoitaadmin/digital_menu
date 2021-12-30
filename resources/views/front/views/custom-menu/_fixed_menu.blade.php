<div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form name="frmFixedMenu" id="frmFixedMenu" novalidate autocomplete="off" class="p-4 bg-white card" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<h4>{{ __('message_lang.lbl_fixed_menu') }}</h4>
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
							<textarea class="form-control" name="menuDescriptionConditions" ng-model="requestDataFixedMenu.menuDescriptionConditions"></textarea>
						</div>
					</div>

					<hr>
					<h6>{{ __('message_lang.lbl_starters') }}<h6>
					<hr>
					<div data-ng-repeat="starter in starters">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_name') }}</label>
								<input type="text" name="productName" ng-model="starter.productName" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_allergy') }}</label>
								<select class="form-control" select2="" name="allergyId" data-ng-model="starter.allergyId" ng-options="allergy.id as allergy.name for allergy in allAllergies" multiple required>
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
		                        <input type="file" file-input="files" name="starterProductMainImage" class="dropify" />
							</div>
							<div class="form-group col-md-6">
								<label>{{ __('message_lang.lbl_product_description') }}</label>
								<textarea class="form-control" name="productDescription" ng-model="starter.productMainDescription"></textarea>
							</div>
						</div>
						<button type="button" class="btn btn btn_custom_for_only_color" style="float: right;" ng-if="starters.length>1 && !$last" ng-click="removeStarter(starter)">{{ __('common.lbl_remove') }}</button>
						<br><br>
						<button type="button" class="btn btn btn_custom_for_only_color" ng-if="$last" ng-click="addNewStarter()">{{ __('common.lbl_add') }}</button>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4 offset-4">
							<label>{{ __('message_lang.lbl_fixed_menu_price') }}</label>
							<input type="number" name="fixedMenuPrice" ng-model="requestDataFixedMenu.fixedMenuPrice" class="form-control">
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
<script type="text/javascript">
	/*Dropzone.autoDiscover = false;
    var starterDropzone;
    $(function () {
        initStarterDropzone();
    });
    function initStarterDropzone(){
        starterDropzone = new Dropzone("div.dropzoneDragAreaStarter", {
            paramName: "productMainImage",
            url: "{{ url('/api/product-image') }}",
            previewsContainer: 'div.dropzone-previews',
            addRemoveLinks: true,
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            params: {
            },
            init: function () {
                this.on('sending', function (file, xhr, formData) {
                    debugger;
                    let createdID = $('input:hidden[name=hdnProductId]').val();
                    $('input:hidden[name=hdnProductId]').val('');
                    formData.append('productId', createdID);
                });
                this.on("complete", function(file) { 
                    // this.removeAllFiles(true);
                    // console.log("Reset done");
                })
            }
        });
    }*/
</script>