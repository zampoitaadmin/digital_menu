bbAppServices.factory('brandingService', ['Restangular', 'userService', 'localStorageService', function(Restangular, userService, localStorageService) {

    function getById(bookId, onSuccess, onError){
        Restangular.one('api/books', bookId).get().then(function(response){

            onSuccess(response);

        }, function(response){

            onError(response);

        });

    }

    function getAll(onSuccess, onError){
        Restangular.all('api/branding-by-user').customGET().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function update(id, data, onSuccess, onError){
        Restangular.one("api/branding-by-user").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
    }
    function revertToDefault(id, data, onSuccess, onError){
        Restangular.one("api/branding-revert-default").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
    }

    function create(data, onSuccess, onError){
        Restangular.all('api/branding-by-user').post(data).then(function(response){

            onSuccess(response);

        }, function(response){

            onError(response);

        });
    }

    function remove(id, onSuccess, onError){
        Restangular.one('api/branding-by-user/', id).remove().then(function(response){

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
        getAll: getAll,
        getById: getById,
        create: create,
        update: update,
        revertToDefault: revertToDefault,
        remove: remove,
        getCurrentToken: getCurrentToken,
    }

}]);