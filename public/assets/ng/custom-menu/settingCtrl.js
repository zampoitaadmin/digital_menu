
bbAppControllers.controller('settingCtrl', ['$scope', '$location','userService', 'settingService','$window','Notification',  function ($scope, $location, userService, settingService,$window,Notification) {
    console.info("in settingCtrl");
    $('a[href="custom-menu#setting"]').click();
    $scope.requestDataSetting = {'isActiveWebsiteTemplate':0,'websiteURL':'','standardDeliveryCharge':'0.00','minimumDeliveryCharge':'0.00','freeDeliveryCharge':'0.00'};
    $scope.messageSetting = '';
    $scope.loaderSetting = '';
    $scope.refreshSetting = function(){
        $scope.loaderSetting = $window.loaderText;
        settingService.getAll(function(response){
            $scope.loaderSetting = '';
            $scope.userSetting  = response.data.userSetting;
            $scope.requestDataSetting.isActiveWebsiteTemplate = $scope.userSetting.is_actv_mnu;
            $scope.requestDataSetting.websiteURL = $scope.userSetting.website_url;
            $scope.requestDataSetting.standardDeliveryCharge = $scope.userSetting.standard_delivery_charge;
            $scope.requestDataSetting.minimumDeliveryCharge = $scope.userSetting.min_order_delivery_charge;
            $scope.requestDataSetting.freeDeliveryCharge = $scope.userSetting.free_delivery_charge_order;
        }, function(response){
            $scope.loaderSetting = '';
            if(response.status!=200){
                if(angular.isObject(response.data.message)){
                    //$scope.requestFormDataError = response.data.message;
                }else{
                    // bbNotification.error(response.data.message);
                    if(!$scope.loaderSetting){
                        $scope.loaderSetting = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        $scope.loaderSetting = '<span class="text-danger">' + response.data.message + '</span>';
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    $scope.onLoadFun = function(){
        $scope.refreshSetting();
    };

    $scope.onLoadFun();

    $scope.copyURLFun = function(){
        var copyTextarea = document.getElementById("websiteURL");
        copyTextarea.select(); //select the text area
        document.execCommand("copy"); //copy to clipboard
    }

    $scope.updateUserSettingFun = function(){
        //sconsole.log($scope.requestDataSetting); return false;
        $scope.requestDataSetting.appLanguage = appLanguage;
        settingService.update($scope.requestDataSetting , function(response){
                if(response.status){
                    Notification.success(response.message);
                    //$scope.onLoadFun();
                }else{
                    Notification.error(response.message);
                    $scope.messageSetting =  response.message;
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
                            $scope.messageSetting = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
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

}]);