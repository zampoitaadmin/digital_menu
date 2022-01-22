
bbAppServices.factory('menuService', ['Restangular', '$http', 'localStorageService', function(Restangular, $http, localStorageService) {

    /*function getBySlug(slug, appLanguage, onSuccess, onError){
        Restangular.one('api/menu/'+slug+'/'+appLanguage).get().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }*/

    function getBySlug(slug, appLanguage, onSuccess, onError){
        // $http.get(secondUriSegment+'/api/menu/'+slug+'/'+appLanguage).
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

    function searchItem(data, onSuccess, onError){
        // Restangular.all(secondUriSegment+'/api/menu').withHttpConfig({
        Restangular.all('api/menu').withHttpConfig({
            transformRequest: angular.identity
        }).customPOST(data, undefined, undefined, {
            'Content-Type': undefined
        }).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    return {
        getBySlug: getBySlug,
        searchItem: searchItem
    }
}]);

