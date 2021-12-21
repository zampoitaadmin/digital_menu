bbApp.config(function ($locationProvider,$stateProvider, $urlRouterProvider) {
   // $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/custom-menu/categories');
    $stateProvider.state('categories', {
        url: '/custom-menu/categories',
        templateUrl: 'categories.html',
        controller: 'categoriesCtrl',
        resolve: {
            loggedIn: function(){
                //do your checking here
                //alert(" inin  ");
            }
        }
    }).state('products', {
        url: '/custom-menu/products',
        templateUrl: 'products.html',
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