
bbAppControllers.controller('productsCtrl', ['$scope', '$location','userService', 'categoryService', 'productService','$window','Notification',  function ($scope, $location, userService, categoryService, productService,$window,Notification) {
    console.info("in productsCtrl");
    $scope.loaderProduct = false;
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

    $scope.refreshUserSelectedCategoryProducts = function(){
        $scope.loaderProduct = $window.loaderText;
        productService.getUserSelectedCategoriesProducts(function(response){
            $scope.loaderProduct = '';
            $scope.userSelectedCategoriesProducts = response.data.products;
            if(!response.status){
                $scope.loaderProduct =  response.data.message;
                $scope.loaderProduct = '<span class="text-info">' + response.message + '</span>';
            }

        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            $scope.loaderProduct = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        $scope.loaderProduct = $window.msgError;
                    }else {
                        $scope.loaderProduct = $window.msgError;
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
        $scope.refreshUserSelectedCategoryProducts();
    };

    $scope.userSelectedCategories = [];
    $scope.onLoadFun();
    
}]);
