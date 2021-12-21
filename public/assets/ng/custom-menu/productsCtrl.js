
bbAppControllers.controller('productsCtrl', ['$scope', '$location','userService', 'categoryService','$window','Notification',  function ($scope, $location, userService, categoryService,$window,Notification) {
    console.info("in productsCtrl");
    $scope.refreshUserSelectedCategory = function(){
        $scope.userSelectedCategories = [];
        $scope.loaderUserSelectedCategory = $window.loaderInner;
        categoryService.getUserSelectedCategories(function(response){
            $scope.userSelectedCategories = response.data.categories;
            $scope.loaderUserSelectedCategory = '';
            if(!response.status){
                //$scope.loaderCategory =  response.data.message;
                $scope.loaderUserSelectedCategory = '<span class="text-info">' + response.message + '</span>';
            }
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            $scope.loaderUserSelectedCategory = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        $scope.loaderUserSelectedCategory = $window.msgError;
                    }else {
                        $scope.loaderUserSelectedCategorys = $window.msgError;
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    $scope.onLoadFun = function(){
        $scope.refreshUserSelectedCategory();
    };
    $scope.loaderUserSelectedCategory = false;
    $scope.userSelectedCategories = [];
    $scope.onLoadFun();
    /*$scope.message = '';
    $scope.refreshCategory = function(){
        categoryService.getAll(function(response){
            console.log(response);
            $scope.categories = response.data.categories;
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            if(response.status!=200){
                if(angular.isObject(response.data.message)){
                    //$scope.requestFormDataError = response.data.message;
                }else{
                    // bbNotification.error(response.data.message);
                    if(!$scope.message){
                        $scope.message = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        $scope.message = '<span class="text-danger">' + response.data.message + '</span>';
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    $scope.refreshUserCategory = function(){
        categoryService.getAllOnlyByUser(function(response){
            $scope.userCategories = response.data.categories;
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            if(response.status!=200){
                if(angular.isObject(response.data.message)){
                    //$scope.requestFormDataError = response.data.message;
                }else{
                    // bbNotification.error(response.data.message);
                    if(!$scope.message){
                        $scope.message = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        $scope.message = '<span class="text-danger">' + response.data.message + '</span>';
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    $scope.refreshUserSelectedCategory = function(){
        categoryService.getUserSelectedCategories(function(response){
            $scope.userSelectedCategories = response.data.categories;
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            if(response.status!=200){
                if(angular.isObject(response.data.message)){
                    //$scope.requestFormDataError = response.data.message;
                }else{
                    // bbNotification.error(response.data.message);
                    if(!$scope.message){
                        $scope.message = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        $scope.message = '<span class="text-danger">' + response.data.message + '</span>';
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    if(!userService.checkIfLoggedIn())
        window.location = '/';//$location.path('/sso/');

    $scope.categories = [];
    $scope.userCategories = [];
    $scope.userSelectedCategories = [];

    $scope.refreshCategory();
    $scope.refreshUserCategory();
    $scope.refreshUserSelectedCategory();*/

}]);