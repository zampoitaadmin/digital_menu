bbAppServices.factory('fixedMenuService', ['Restangular', 'userService', 'localStorageService', function(Restangular, userService, localStorageService) {

	function create(data, onSuccess, onError){
        Restangular.all('api/merchant-fixed-menu').post(data).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    function update(id, data, onSuccess, onError){
        Restangular.one("api/merchant-fixed-menu").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
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

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        create: create,
        update: update,
        getMerchantFixedMenu: getMerchantFixedMenu,
        getCurrentToken: getCurrentToken,
    }

}]);