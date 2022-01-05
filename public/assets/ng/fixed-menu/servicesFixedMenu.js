bbAppServices.factory('fixedMenuService', ['Restangular', 'userService', 'localStorageService', function(Restangular, userService, localStorageService) {

	function create(data, onSuccess, onError){

        Restangular.all('api/merchant-fixed-menu').withHttpConfig({
            transformRequest: angular.identity
        }).customPOST(data, undefined, undefined, {
            'Content-Type': undefined
        }).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });

        /*Restangular.all('api/merchant-fixed-menu').post(data).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });*/
    }

    // function update(id, data, onSuccess, onError){
    function update(data, onSuccess, onError){

        Restangular.all('api/merchant-fixed-menu-update').withHttpConfig({
            transformRequest: angular.identity
        }).customPOST(data, undefined, undefined, {
            'Content-Type': undefined
        }).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });

        /* // Not Working
        Restangular.one('api/merchant-fixed-menu').withHttpConfig({
            transformRequest: angular.identity
        }).customPUT(data, id, undefined, {
            'Content-Type': undefined
        }).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });*/
        
        /*Restangular.one("api/merchant-fixed-menu").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );*/
    }

    function getMerchantFixedMenu(categoryId, onSuccess, onError){
        Restangular.one('api/merchant-fixed-menu', categoryId).get().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    function getCurrentToken(){
        return localStorageService.get('token');
    }

    function removeProductImage(id, onSuccess, onError){
        Restangular.one('api/merchant-fixed-menu/', id).remove().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        create: create,
        update: update,
        getMerchantFixedMenu: getMerchantFixedMenu,
        removeProductImage: removeProductImage,
        getCurrentToken: getCurrentToken,
    }

}]);