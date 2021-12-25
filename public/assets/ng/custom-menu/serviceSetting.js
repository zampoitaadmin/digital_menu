bbAppServices.factory('settingService', ['Restangular', 'userService', function(Restangular, userService) {

    function getAll(onSuccess, onError){
        Restangular.all('api/setting-by-user').customGET().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function update( data, onSuccess, onError){
        Restangular.all("api/setting-by-user").post(data).then(function(response) {
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



    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        getAll: getAll,
        update: update,
    }

}]);