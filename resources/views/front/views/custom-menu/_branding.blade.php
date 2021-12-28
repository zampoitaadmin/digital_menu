<style type="text/css">
    .dz-preview .dz-image img{
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }
</style>
<div role="tabpanel" class="tab-pane  active show1 " id="branding">
    <div class="container ">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex flex-row-reverse mb-2">
                            <button class="btn btn_custom_for_only_color d-flex flex-row-reverse"  ng-click="revertToDefaultFun()"><?= __('message_lang.branding_revert_to_Default'); ?></button>
                        </div>
                        <form novalidate autocomplete="off" class="dropzone" enctype="multipart/form-data">
                            <input type="hidden" name="hdnMenuBrandingId">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4"><b><?= __('message_lang.branding_color_main'); ?></b></label>
                                    <input type="color" id="mainColor" name="mainColor" ng-value="@{{ requestDataBranding.mainColor }}" class="form-control p-0" ng-model="requestDataBranding.mainColor">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4"><b><?= __('message_lang.branding_color_secondary'); ?></b></label>
                                    <input type="color" id="secondaryColor" name="secondaryColor" ng-value="@{{ requestDataBranding.secondaryColor }}" class="form-control p-0" ng-model="requestDataBranding.secondaryColor">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4"><b><?= __('message_lang.branding_color_third'); ?></b></label>
                                    <input type="color" id="thirdColor" name="thirdColor" ng-value="@{{ requestDataBranding.thirdColor }}" class="form-control p-0" ng-model="requestDataBranding.thirdColor">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4"><b><?= __('message_lang.branding_color_font'); ?></b></label>
                                    <input type="color" id="fontColor" name="fontColor" ng-value="@{{ requestDataBranding.fontColor }}" class="form-control p-0" ng-model="requestDataBranding.fontColor">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4"><b><?= __('message_lang.branding_logo'); ?></b></label>
                                    <div id="brandingDropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                        <span>Upload file</span>
                                    </div>
                                    <div class="branding-dropzone-previews"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn_custom_for_only_color d-flex flex-row-center" ng-click="updateUserBrandingFun()"><?= __('common.btn_submit'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var brandingDropzone;
    $(function () {
        // initBrandingDropzone();
    });
    /*function initBrandingDropzone(){
        brandingDropzone = new Dropzone("div#brandingDropzoneDragArea", {
            paramName: "brandLogo",
            url: "{{ url('/api/branding-logo') }}",
            previewsContainer: 'div.branding-dropzone-previews',
            addRemoveLinks: true,
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            params: {
            },
            init: function () {
                brandingDropzoneThis = this;
                $.ajax({
                    url: "{{ url('/api/branding-logo') }}",
                    type: 'get',
                    dataType: 'json',
                    headers: {"Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbC56YW1wb2l0YS5jb21cL2FwaVwvYXV0aFwvY29ubmVjdC1zc28iLCJpYXQiOjE2NDA2NjgzMDcsImV4cCI6MTY0MDc1NDcwNywibmJmIjoxNjQwNjY4MzA3LCJqdGkiOiJjdWVMQUd0N0dwYk44WFlVIiwic3ViIjoyOTYxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.fxSYvIgz8RCjMN34UoGU1htVdleaRNYR7GNg7oX0itY"},
                    success: function (response) {
                        if(response.status){
                            $.each(response.data, function (key, value) {
                                var mockFile = {
                                    name: value.name,
                                    size: value.size
                                };
                                brandingDropzoneThis.emit("addedfile", mockFile);
                                brandingDropzoneThis.emit("thumbnail", mockFile, value.url);
                                brandingDropzoneThis.emit("complete", mockFile);
                            });
                        }
                    }
                });
                this.on("success", function (file, response) {
                    if(response.status){
                        $('.branding-dropzone-previews').empty();
                    }
                    else{
                        alert(response.message);
                    }
                });
                this.on('sending', function (file, xhr, formData) {
                    let createdID = $('input:hidden[name=hdnMenuBrandingId]').val();
                    $('input:hidden[name=hdnMenuBrandingId]').val('');
                    formData.append('menuBrandingId', createdID);
                });
                this.on("complete", function(file) { 
                    this.removeAllFiles(true);
                    console.log("Reset done");
                })
            }
        });
    }*/
</script>