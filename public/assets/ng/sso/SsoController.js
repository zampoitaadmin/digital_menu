
bbAppControllers.controller('SsoController', ['$scope', '$location','$stateParams', 'ssoService', function ($scope, $location, $stateParams, ssoService) {
    console.info("IN SSO Ctrl");
    //alert("IN SSO Ctrl");
    //alert($stateParams.sso);
    //$log.error($scope.requestFormData);
    $scope.message = 'Connecting Custom Menu Server...';
    $scope.connectSso = function() {
        ssoService.connectSso(
            $stateParams.sso,
            function(response){
                console.info("IN SSO Ctrl Success");
                //$location.path('/'); //Redirect on merchant page
                window.location = '/custom-menu';
            },
            function(response){
                // console.error(response);
                console.error("IN SSO Ctrl Error");
                if(response.status!=200){
                    if(angular.isObject(response.data.message)){
                        //$scope.requestFormDataError = response.data.message;
                    }else{
                        // bbNotification.error(response.data.message);
                        $scope.message = '<span class="text-danger">'+response.data.message+'</span>';
                    }

                    //alert('Something went wrong with the login process. Try again later!');
                }
                //$location.path('/custom-menu'); //Redirect on merchant page
                //window.location = '/custom-menu/';
            }
        );
    }
    //if(ssoService.checkIfLoggedIn())
    //$location.path('/'); //Redirect on merchant page
    $scope.connectSso();

}]);