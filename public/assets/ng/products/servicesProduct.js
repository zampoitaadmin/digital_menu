bbAppServices.factory('productService', ['Restangular', 'userService', function(Restangular, userService) {

    function getUserSelectedCategoriesProducts(onSuccess, onError){
        Restangular.all('api/products').customGET().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        getUserSelectedCategoriesProducts: getUserSelectedCategoriesProducts,
    }

}]);