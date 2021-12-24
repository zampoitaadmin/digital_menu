var loader = '<div class="Box">Loading...<span></span></div>';
var loaderInner = '<span class="loader-inner"></span></h3>';
var loaderText = '<span class="loader">Loading</span>';
var msgError = '<span class="text-danger">Some errors occurred while communicating with the service. Try again...</span>';
var msgErrorSWR = 'Something went wrong...!!!';
var msgStripeTransactionProcessing = "Note: Please do not press 'Refresh' or 'Back' button";


var bbApp = angular.module('bbApp', [
    //'ngRoute',
    'ui.router',
    'ngSanitize',
    'ui-notification',
    //'ngResource',
    'bbAppControllers',
    'ui.sortable'
]);
bbApp.config(function (localStorageServiceProvider) {
    localStorageServiceProvider
        .setPrefix('bbApp')
        .setStorageType('localStorage');
});



bbApp.factory('bbNotification', ['$window', function(msg) {
    var notification = {};
    var timer = 2500;
    notification.success = function(msg) {
        Swal.fire({
            type: 'success',
            //position: 'top-end',
            //text: "You won't be able to revert this!",
            title: msg,
            showConfirmButton: false,
            timer: timer
        });
    };
    notification.successRedirect = function(msg,url) {
        Swal.fire({
            type: 'success',
            //position: 'top-end',
            //text: "You won't be able to revert this!",
            title: msg,
            showConfirmButton: false,
            timer: timer
        }).then(function() {
            window.location = url;
        });
    };
    notification.error = function(msg) {
        Swal.fire({
            type: 'error',
            /*position: 'top-end',*/
            /*text: "You won't be able to revert this!",*/
            title: msg,
            showConfirmButton: false,
            timer: timer
        });
    };
    notification.errorRedirect = function(msg,url) {
        Swal.fire({
            type: 'error',
            //position: 'top-end',
            //text: "You won't be able to revert this!",
            title: msg,
            showConfirmButton: false,
            timer: timer
        }).then(function() {
            if(url!=''){
                window.location = url;
            }else{
                window.location.reload();
            }

        });
    };
    notification.warningWithHtml = function(msg) {
        Swal.fire({
            type: 'warning',
            html:msg,
            /*position: 'top-end',*/
            /*text: "You won't be able to revert this!",*/
            //title: msg,
            showConfirmButton: true,
            //timer: 5000
        });
    };
    return notification;
    /*return function(msg) {

     //win.alert(msgs.join('\n'));
     Swal.fire({
     type: 'success',
     /!*position: 'top-end',*!/
     text: "You won't be able to revert this!",
     title: 'Your work has been saved',
     showConfirmButton: false,
     timer: 1500
     });

     };*/
}]);
/*bbApp.factory('bbLoader', ['$window', function(X) {
    var bbLoader = {};
    bbLoader.show = function(X) {

    };
    return bbLoader ;
}]);

$scope.showLoaderFun = function(type){
    if (type=='P'){
        $scope.isProductLoader = true;
        $scope.loaderProduct = $window.loader;
    }else if (type=='S'){
        $scope.isSidesLoader = true;
        $scope.loaderSides= $window.loader;
    }  else if (type=='SC'){
        $scope.isSidesCartLoader = true;
        $scope.loaderSidesCart= $window.loader;
    }
    else if (type=='C'){
        $scope.isProductCartLoader = true;
        $scope.loaderProductCart = $window.loader;
    }
};*/
/*bbApp.config(['$locationProvider','$routeProvider', function($locationProvider,$routeProvider) {
    $locationProvider.html5Mode(true);
    console.log($routeProvider);
    $routeProvider.
        when('/sso/:sso', {
            templateUrl: 'sso.html',
            controller: 'SsoController'
        }).
        *//*when('/custom-menu', {
            templateUrl: 'categories.html',
            controller: 'CustomMenuCategoryController'
        }).*//*
        when('/custom-menu/categories', {
            templateUrl: 'categories.html',
            controller: 'CustomMenuCategoryController'
        }).
        when('/custom-menu/products', {
            templateUrl: 'products.html',
            controller: 'CustomMenuProductController'
        }).
        when('/custom-menu/branding', {
            templateUrl: 'branding.html',
            controller: 'CustomMenuProductController'
        }).
        when('/custom-menu/setting', {
            templateUrl: 'setting.html',
            controller: 'CustomMenuSettingController'
        }).

        otherwise({
            redirectTo: '/'
        });

}]);*/
