bbApp.config(function ($locationProvider,$stateProvider, $urlRouterProvider) {
   // $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/categories');
    $stateProvider.state('categories', {
        url: '/categories',
        templateUrl: 'categories.html',
        controller: 'categoriesCtrl',
        resolve: {
            loggedIn: function(){
                //do your checking here
                //alert(" inin  ");
            }
        }
    }).state('products', {
        url: '/products',
        templateUrl: 'products.html',
        controller: 'productsCtrl',
    }).state('branding', {
        url: '/branding',
        templateUrl: 'branding.html',
        controller: 'brandingCtrl',
    }).state('setting', {
        url: '/setting',
        templateUrl: 'setting.html',
        controller: 'productsCtrl',
    });/*.state('detail', {
     url: '/detail/:taxId',
     templateUrl: 'detail.html',
     controller: 'detailCtrl',
     resolve: {
     check: ($stateParams, $location) => {
     if (!parseInt($stateParams.taxId)) {
     $location.path('/taxId');
     }
     }
     }
     }).state('update', {
     url: '/update/:taxId',
     templateUrl: 'update.html',
     controller: 'updateCtrl',
     resolve: {
     check: ($stateParams, $location) => {
     if (!parseInt($stateParams.taxId)) {
     $location.path('/listing');
     }
     }
     }
     });*/
});