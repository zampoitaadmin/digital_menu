
bbAppServices.factory('ssoService1', ['$http', 'localStorageService', function($http, localStorageService) {
    function checkIfLoggedIn() {
        if(localStorageService.get('token')){
            $scope.isLogged = 1;
            return true;
        }else{
            $scope.isLogged = 2;
            return false;
        }
    }

    function signup(name, email, password, onSuccess, onError) {

        $http.post('/api/auth/signup',
            {
                name: name,
                email: email,
                password: password
            }).
            then(function(response) {

                localStorageService.set('token', response.data.token);
                onSuccess(response);

            }, function(response) {

                onError(response);

            });

    }

    function login(email, password, onSuccess, onError){

        $http.post('/api/auth/login',
            {
                email: email,
                password: password
            }).
            then(function(response) {

                localStorageService.set('token', response.data.token);
                onSuccess(response);

            }, function(response) {

                onError(response);

            });

    }

    function logout(){

        localStorageService.remove('token');

    }

    function getCurrentToken(){
        return localStorageService.get('token');
    }

    return {
        checkIfLoggedIn: checkIfLoggedIn,
        signup: signup,
        login: login,
        logout: logout,
        getCurrentToken: getCurrentToken
    }

}]);

