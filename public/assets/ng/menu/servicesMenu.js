
bbAppServices.factory('menuService', ['$http', 'localStorageService', function($http, localStorageService) {

    /*function getBySlug(slug, appLanguage, onSuccess, onError){
        Restangular.one('api/menu/'+slug+'/'+appLanguage).get().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }*/

    function getBySlug(slug, appLanguage, onSuccess, onError){
        $http.get('api/menu/'+slug+'/'+appLanguage).
            then(function(response) {
                onSuccess(response);
            }, function(response) {
                onError(response);
            });
    }

    /*function getBySlug(slug, onSuccess, onError){
        Restangular.one('api/menu', slug).get().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }*/
    return {
        getBySlug: getBySlug
    }
}]);

