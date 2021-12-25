bbAppServices.factory('productService', ['Restangular', 'userService', function(Restangular, userService) {

    function getUserSelectedCategoriesProducts(onSuccess, onError){
        Restangular.all('api/products').customGET().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function create(data, onSuccess, onError){
        Restangular.all('api/products').post(data).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    function update(id, data, onSuccess, onError){
        Restangular.one("api/products").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
    }

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        getUserSelectedCategoriesProducts: getUserSelectedCategoriesProducts,
        create: create,
        update: update,
    }

}]);