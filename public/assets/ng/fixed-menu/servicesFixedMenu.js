bbAppServices.factory('fixedMenuService', ['Restangular', 'userService', 'localStorageService', function(Restangular, userService, localStorageService) {

    function getCurrentToken(){
        return localStorageService.get('token');
    }

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        getCurrentToken: getCurrentToken,
    }

}]);