
bbAppControllers.controller('productsCtrl', ['$scope', '$location','userService', 'categoryService', 'productService','$window','Notification',  function ($scope, $location, userService, categoryService, productService,$window,Notification) {
    console.info("in productsCtrl");
    $('a[href="custom-menu#products"]').click();
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

    $scope.isArrayDifferentFun = ((firstArray, secondArray) => {
        let isArrayDifferent = false;
        firstArray.forEach((val, index) => {
            if(firstArray[index] !== secondArray[index]) {
                isArrayDifferent = true;
                return;
            }
        });
        return isArrayDifferent;
    });

    $scope.currentUserCategoryOrder = [];
    $scope.sortableOptions = {
        update: function (e, ui) {
            $scope.currentUserCategoryOrder = [];
            var currentUserCategoryOrder = $scope.userSelectedCategories.map(function(element){
                return element.id;
            });
            $scope.currentUserCategoryOrder = currentUserCategoryOrder;
            console.log("Update: " + $scope.currentUserCategoryOrder);
        },
        stop: function (e, ui) {
            var newUserCategoryOrder = $scope.userSelectedCategories.map(function(element){
                return element.id;
            });
            console.log("Stop currentUserCategoryOrder : " + $scope.currentUserCategoryOrder);
            console.log("Stop newUserCategoryOrder : " + newUserCategoryOrder);
            
            let isArrayDifferent = $scope.isArrayDifferentFun($scope.currentUserCategoryOrder, newUserCategoryOrder);
            
            if(isArrayDifferent){
                let jsObject = {'newUserCategoryOrder':newUserCategoryOrder};
                $scope.currentUserCategoryOrder = newUserCategoryOrder;
                categoryService.updateUserCategoryOrder(jsObject, function(response){
                    if(response.status){
                        Notification.success(response.message);
                        $scope.onLoadFun();
                    }else{
                        Notification.error(response.message);
                        //$scope.formCrudRequestErrors.message =  response.message;
                    }
                }, function(response){
                    //alert('Some errors occurred while communicating with the service. Try again later.');
                    console.error(" In assignCategoryToUserFun ERROR");
                    //console.error(response);
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

        }
    };
    
    $scope.onLoadFun = function(){
        $scope.refreshUserSelectedCategory();
        $scope.refreshUserSelectedCategoryProducts();
    };

    $scope.userSelectedCategories = [];
    $scope.onLoadFun();
    
}]);
