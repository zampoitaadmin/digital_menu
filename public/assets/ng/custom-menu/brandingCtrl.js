
bbAppControllers.controller('brandingCtrl', ['$scope', '$location','userService', 'brandingService','$window','Notification',  function ($scope, $location, userService, brandingService,$window,Notification) {
    console.info("in brandingCtrl");
    $scope.requestDataBranding = {'mainColor':'','secondaryColor':'','thirdColor':'','fontColor':'','brandLogo':'','id':0};
    $scope.messageBrand = '';
    $scope.refreshBranding = function(){
        brandingService.getAll(function(response){
            $scope.branding  = response.data.branding;
            $scope.requestDataBranding.mainColor = $scope.branding.brand_color;
            $scope.requestDataBranding.secondaryColor = $scope.branding.secondary_color;
            $scope.requestDataBranding.thirdColor = $scope.branding.third_color;
            $scope.requestDataBranding.fontColor = $scope.branding.font_color;
            $scope.requestDataBranding.id = $scope.branding.menu_branding_id;
            console.log($scope.requestDataBranding);
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
    $scope.onLoadFun = function(){
        $scope.refreshBranding();
    };

    $scope.onLoadFun();
    $scope.updateUserBrandingFun = function(){
        //console.log($scope.requestDataBranding); return false;
        brandingService.update($scope.requestDataBranding.id,
            $scope.requestDataBranding , function(response){
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
            {'mainColor':'','secondaryColor':'','thirdColor':'','fontColor':'','brandLogo':'','id':$scope.requestDataBranding.id} , function(response){
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
}]);