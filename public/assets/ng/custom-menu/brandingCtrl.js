
bbAppControllers.controller('brandingCtrl', ['$scope', '$location','userService', 'brandingService','$window','Notification','$timeout',  function ($scope, $location, userService, brandingService,$window,Notification,$timeout) {
    console.info("in brandingCtrl");
    $('a[href="custom-menu#branding"]').click();
    $scope.requestDataBranding = {'mainColor':'','secondaryColor':'','thirdColor':'','fontColor':'','brandLogo':'','id':0};
    $scope.messageBrand = '';

    $scope.getDropifyConfig = function(){
        let drConfig = {};
        if(appLanguage == "en"){
            drConfig = {
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            };
        }else if(appLanguage == "es"){
            drConfig = {
                messages: {
                    'default': 'es Drag and drop a file here or click',
                    'replace': 'es Drag and drop or click to replace',
                    'remove':  'es Remove',
                    'error':   'es Ooops, something wrong happended.'
                }
            };
        }
        return drConfig;
    }

    var dropifyBrandLogo;
        dropifyBrandLogo = $('.dropifyBrandLogo').dropify( $scope.getDropifyConfig() );

    $(document).on('click', '.dropify-clear', function()
    {
        if( $("ul.nav.nav-pills li a.active").get(0).href.indexOf('#branding') > -1 ){
            let menuBrandingId = $scope.requestDataBranding.id;
            if(menuBrandingId>0){
                swal.fire({
                    title: 'Are you sure you want to delete?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).
                then((result) => {
                    if(result.value){
                        brandingService.removeBrandingLogo(menuBrandingId, function(response){
                            console.log(response);
                            if(response.status){
                                Notification.success(response.message);
                                $scope.onLoadFun();
                            }else{
                                Notification.error(response.message);
                                $scope.messageBrand =  response.message;
                            }
                        }, function(response){
                            //alert('Some errors occurred while communicating with the service. Try again later.');
                            var responseData = response.data;
                            if(response.status != 200){
                                if(angular.isObject(responseData.message)){
                                    //$scope.requestFormDataError = response.data.message;
                                    console.warn(responseData.message);
                                }else{
                                    // bbNotification.error(response.data.message);
                                    if(responseData.message.length==0){
                                        $scope.loaderUserSelectedCategory = $window.msgError;
                                    }else {
                                        //$scope.loaderUserSelectedCategorys = $window.msgError;
                                        Notification.error(responseData.message);
                                        //$scope.formCrudRequestErrors.message = responseData.message ;
                                        //TODO Error Msg with Refresh
                                        //alert("in "+responseData.message);
                                    }
                                }
                            }
                        });
                    }
                });
            }
            else{
                // event.preventDefault();
                return false;
            }
        }
    });

    dropifyBrandLogo.on('dropify.beforeClear', function(event, element){
    });

    dropifyBrandLogo = dropifyBrandLogo.data('dropify');
    if(!dropifyBrandLogo.isDropified()){
        dropifyBrandLogo.init();
    }

    $scope._refreshBranding = function(){
        brandingService.getAll(function(response){
            $scope.branding  = response.data.branding;
            $scope.requestDataBranding.mainColor = $scope.branding.brand_color;
            $scope.requestDataBranding.secondaryColor = $scope.branding.secondary_color;
            $scope.requestDataBranding.thirdColor = $scope.branding.third_color;
            $scope.requestDataBranding.fontColor = $scope.branding.font_color;
            $scope.requestDataBranding.id = $scope.branding.menu_branding_id;

            var dropifyBrandLogo = $('.dropifyBrandLogo').dropify( $scope.getDropifyConfig() );
            dropifyBrandLogo = dropifyBrandLogo.data('dropify');
            dropifyBrandLogo.resetPreview();
            dropifyBrandLogo.clearElement();
            dropifyBrandLogo.settings['defaultFile'] = $scope.branding.brandLogoUrl;
            dropifyBrandLogo.destroy();
            dropifyBrandLogo.init();
        }, function(response){
            if(response.status!=200){
                if(angular.isObject(response.data.message)){
                    //$scope.requestFormDataError = response.data.message;
                }else{
                    // bbNotification.error(response.data.message);
                    if(!$scope.messageBrand){
                        $scope.messageBrand = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        $scope.messageBrand = '<span class="text-danger">' + response.data.message + '</span>';
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    $scope.refreshBranding = function(){
        $timeout(function(){
            $scope._refreshBranding();
        }, 200);
    };
    $scope.onLoadFun = function(){
        $scope.refreshBranding();
    };

    $scope.onLoadFun();
    $scope.updateUserBrandingFun = function(){
        // debugger;
        //console.log($scope.requestDataBranding); return false;
        // $scope.requestDataBranding.appLanguage = appLanguage;
        // debugger;
        console.log($scope.requestDataBranding);
        
        // let appLanguage = $scope.requestDataBranding.appLanguage;
        let brandLogo = $scope.requestDataBranding.brandLogo;
        let fontColor = $scope.requestDataBranding.fontColor;
        let id = $scope.requestDataBranding.id;
        let mainColor = $scope.requestDataBranding.mainColor;
        let secondaryColor = $scope.requestDataBranding.secondaryColor;
        let thirdColor = $scope.requestDataBranding.thirdColor;

        let formData = new FormData();
        formData.append('appLanguage', appLanguage);
        if($scope.requestDataBranding.brandLogo){
            formData.append('brandLogo', $scope.requestDataBranding.brandLogo);
        }else{
            formData.append('brandLogo', '');
        }
        formData.append('fontColor', $scope.requestDataBranding.fontColor);
        formData.append('id', $scope.requestDataBranding.id);
        formData.append('mainColor', $scope.requestDataBranding.mainColor);
        formData.append('secondaryColor', $scope.requestDataBranding.secondaryColor);
        formData.append('thirdColor', $scope.requestDataBranding.thirdColor);
        
        brandingService.update(formData,
            function(response){
            if(response.status){
                Notification.success(response.message);
                $scope.onLoadFun();
            }else{
                Notification.error(response.message);
                $scope.messageBrand =  response.message;
            }
        }, function(response){
            //alert('Some errors occurred while communicating with the service. Try again later.');
            //console.error(response);
            var responseData = response.data;
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        //$scope.loaderUserSelectedCategory = $window.msgError;
                        $scope.messageBrand = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        //$scope.loaderUserSelectedCategorys = $window.msgError;
                        Notification.error(responseData.message);
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
        });
    };
    $scope.revertToDefaultFun = function(){
        //console.log($scope.requestDataBranding); return false;
        //$scope.requestDataBranding = {'mainColor':'','secondaryColor':'','thirdColor':'','fontColor':'','brandLogo':'','id':0};
        brandingService.revertToDefault($scope.requestDataBranding.id,
            {'mainColor':'','secondaryColor':'','thirdColor':'','fontColor':'','brandLogo':'','id':$scope.requestDataBranding.id,'appLanguage':appLanguage} , function(response){
            if(response.status){
                Notification.success(response.message);
                $scope.onLoadFun();
            }else{
                Notification.error(response.message);
                $scope.messageBrand =  response.message;
            }
        }, function(response){
            //alert('Some errors occurred while communicating with the service. Try again later.');
            //console.error(response);
            var responseData = response.data;
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        //$scope.loaderUserSelectedCategory = $window.msgError;
                        $scope.messageBrand = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        //$scope.loaderUserSelectedCategorys = $window.msgError;
                        Notification.error(responseData.message);
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
        });
    }

    $scope.brandLogoUploadedFile = function (element) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $scope.$apply(function ($scope) {
                $scope.requestDataBranding.brandLogo = element.files[0];
            });
        }
        reader.readAsDataURL(element.files[0]);
    }
}]);