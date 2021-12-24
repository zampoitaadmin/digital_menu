bbApp.config(function ($locationProvider,$stateProvider, $urlRouterProvider) {
    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/');
    $stateProvider.state('menu', {
        url: '/menu/:slug',
        templateUrl: 'menu.html',
        controller: 'menuCtrl',
        /*resolve: {
            check: ($stateParams, $location) => {
              alert($stateParams.sso);
            }
        }*/
    });
});
