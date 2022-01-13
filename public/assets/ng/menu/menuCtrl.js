
bbAppControllers.controller('menuCtrl', ['$scope', '$location','$stateParams', 'menuService', function ($scope, $location, $stateParams, menuService) {
    console.info("IN Menu Ctrl");
    alert("IN Menu Ctrl");
    //alert($stateParams.sso);
    //$log.error($scope.requestFormData);
    // $scope.message = 'Connecting Custom Menu Server...';

    //alert("IN SSO Ctrl");
    //alert($stateParams.sso);
    //$log.error($scope.requestFormData);
    // $scope.message = 'Connecting Custom Menu Server...';
    $scope.loadMenuPage = function() {
        var appLanguage = "en";
        menuService.getBySlug(
            $stateParams.slug,
            appLanguage,
            function(response){
                debugger;
                // console.info("IN SSO Ctrl Success");
                // //$location.path('/'); //Redirect on merchant page
                // window.location = '/custom-menu';
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
    $scope.loadMenuPage();


    
}]);