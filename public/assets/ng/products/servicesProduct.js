bbAppServices.factory('productService', ['Restangular', 'userService', 'localStorageService', function(Restangular, userService, localStorageService) {

    function getUserSelectedCategoriesProducts(onSuccess, onError){
        // Restangular.all(secondUriSegment+'/api/products').customGET(appLanguage).then(function(response){
        Restangular.all('api/products').customGET(appLanguage).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function create(data, onSuccess, onError){
        // Restangular.all(secondUriSegment+'/api/products').withHttpConfig({
        Restangular.all('api/products').withHttpConfig({
            transformRequest: angular.identity
        }).customPOST(data, undefined, undefined, {
            'Content-Type': undefined
        }).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });

        /*Restangular.all('api/products').post(data).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });*/
    }

    function update(data, onSuccess, onError){
    // function update(id, data, onSuccess, onError){
        // Restangular.all(secondUriSegment+'/api/products-update').withHttpConfig({
        Restangular.all('api/products-update').withHttpConfig({
            transformRequest: angular.identity
        }).customPOST(data, undefined, undefined, {
            'Content-Type': undefined
        }).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
        /*Restangular.one("api/products").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );*/
    }

    function remove(id, appLanguage, onSuccess, onError){
        // Restangular.one(secondUriSegment+'/api/products/'+id+'/'+appLanguage).remove().then(function(response){
        Restangular.one('api/products/'+id+'/'+appLanguage).remove().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    function getCurrentToken(){
        return localStorageService.get('token');
    }

    function updateUserCategoryProductOrder(data, onSuccess, onError){
        // Restangular.all(secondUriSegment+"/api/products/update-user-category-product-order").post(data).then(function(response) {
        Restangular.all("api/products/update-user-category-product-order").post(data).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
    }

    function removeProductMainImage(id, onSuccess, onError){
        // Restangular.one(secondUriSegment+'/api/remove-product-main-image/', id).remove().then(function(response){
        Restangular.one('api/remove-product-main-image/', id).remove().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        getUserSelectedCategoriesProducts: getUserSelectedCategoriesProducts,
        create: create,
        update: update,
        remove: remove,
        getCurrentToken: getCurrentToken,
        updateUserCategoryProductOrder: updateUserCategoryProductOrder,
        removeProductMainImage: removeProductMainImage
    }

}]);