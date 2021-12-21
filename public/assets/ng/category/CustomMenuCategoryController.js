
bbAppControllers.controller('CustomMenuCategoryController', ['$scope', '$location','$routeParams', 'userService', 'categoryService', function ($scope, $location, $routeParams, userService, categoryService) {
    console.info("in CustomMenuCategoryController");
    $scope.message = '';
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
    $scope.refreshUserSelectedCategory();

}]);