
bbAppControllers.controller('brandingCtrl', ['$scope', '$location','userService', 'brandingService','$window','Notification','$timeout',  function ($scope, $location, userService, brandingService,$window,Notification,$timeout) {
    console.info("in brandingCtrl");
    $('a[href="custom-menu#branding"]').click();
    $scope.requestDataBranding = {'mainColor':'','secondaryColor':'','thirdColor':'','fontColor':'','brandLogo':'','id':0};
    $scope.messageBrand = '';
    $scope._refreshBranding = function(){
        brandingService.getAll(function(response){
            $scope.branding  = response.data.branding;
            $scope.requestDataBranding.mainColor = $scope.branding.brand_color;
            $scope.requestDataBranding.secondaryColor = $scope.branding.secondary_color;
            $scope.requestDataBranding.thirdColor = $scope.branding.third_color;
            $scope.requestDataBranding.fontColor = $scope.branding.font_color;
            $scope.requestDataBranding.id = $scope.branding.menu_branding_id;
            console.log($scope.requestDataBranding);
            $.each(response.data.fileList, function (key, value) {
                var mockFile = {
                    name: value.name,
                    size: value.size,
                    id: value.id
                };
                brandingDropzone.emit("addedfile", mockFile);
                brandingDropzone.emit("thumbnail", mockFile, value.url);
                brandingDropzone.emit("complete", mockFile);
            });
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
        //console.log($scope.requestDataBranding); return false;
        $scope.requestDataBranding.appLanguage = appLanguage;
        brandingService.update($scope.requestDataBranding.id,
            $scope.requestDataBranding , function(response){
            if(response.status){

                if(brandingDropzone.files.length > 0){
                    $('input:hidden[name=hdnMenuBrandingId]').val($scope.requestDataBranding.id);
                    brandingDropzone.options.headers = {
                        'Authorization': 'Bearer ' + brandingService.getCurrentToken()
                    };
                    brandingDropzone.processQueue();
                }
                else{
                }

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
    $timeout(function(){
        brandingDropzone.on("removedfile", function (file) {
            let fileName = file.name;
            let id = file.id;
            if(id){
                brandingService.removeBrandingLogo(id,
                    {fileName} , function(response){
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
        });
    }, 200);
}]);