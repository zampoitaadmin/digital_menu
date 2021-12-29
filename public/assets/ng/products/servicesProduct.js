bbAppServices.factory('productService', ['Restangular', 'userService', 'localStorageService', function(Restangular, userService, localStorageService) {

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

    function remove(id, onSuccess, onError){
        Restangular.one('api/products/', id).remove().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    function removeProductImage(){
        Restangular.one('api/product-image/', id).remove().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    function getCurrentToken(){
        return localStorageService.get('token');
    }

    function updateUserCategoryProductOrder(data, onSuccess, onError){
        Restangular.all("api/products/update-user-category-product-order").post(data).then(function(response) {
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
        remove: remove,
        getCurrentToken: getCurrentToken,
        removeProductImage: removeProductImage,
        updateUserCategoryProductOrder: updateUserCategoryProductOrder
    }

}]);