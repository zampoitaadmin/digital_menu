bbApp.config(function ($locationProvider,$stateProvider, $urlRouterProvider) {
    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/');
    $stateProvider.state('sso', {
        url: '/sso/:sso',
        templateUrl: 'sso.html',
        controller: 'SsoController',
        /*resolve: {
            check: ($stateParams, $location) => {
              alert($stateParams.sso);
            }
        }*/
    });
});
