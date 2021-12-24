
bbAppServices.factory('menuService', ['$http', 'localStorageService', function($http, localStorageService) {

    function getBySlug(slug, onSuccess, onError){
        Restangular.one('api/menu', slug).get().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }
    return {
        getBySlug: getBySlug
    }
}]);

