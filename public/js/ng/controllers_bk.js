var bbAppControllers = angular.module('bbAppControllers', [
    'bbAppServices'
]);
bbAppControllers.controller('SsoController', ['$scope', '$location','$routeParams', 'ssoService', function ($scope, $location, $routeParams, ssoService) {
    console.info("IN SSO Ctrl");
    //$log.error($scope.requestFormData);
    $scope.message = 'Connecting Custom Menu Server...';
    $scope.connectSso = function() {
        ssoService.connectSso(
            $routeParams.sso,
            function(response){
                console.info("IN SSO Ctrl Success");
                //$location.path('/'); //Redirect on merchant page
                window.location = '/custom-menu/categories';
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

bbAppControllers.controller('CustomMenuController', ['$scope', '$location','$routeParams', 'ssoService', function ($scope, $location, $routeParams, ssoService) {
    console.info("in CustomMenuController");


}]);/*
bbAppControllers.controller('CustomMenuProductController', ['$scope', '$location','$routeParams', 'ssoService', function ($scope, $location, $routeParams, ssoService) {
    console.info("in CustomMenuProductController");

}]);*/
bbAppControllers.controller('CustomMenuSettingController', ['$scope', '$location','$routeParams', 'ssoService', function ($scope, $location, $routeParams, ssoService) {
    console.info("in CustomMenuSettingController");

}]);
bbAppControllers.controller('LoginController', ['$scope', '$location', 'userService', function ($scope, $location, userService) {

    $scope.login = function() {
        userService.login(
            $scope.email, $scope.password,
            function(response){
                $location.path('/');
            },
            function(response){
                alert('Something went wrong with the login process. Try again later!');
            }
        );
    }

    $scope.email = '';
    $scope.password = '';

    if(userService.checkIfLoggedIn())
        $location.path('/');

}]);

bbAppControllers.controller('SignupController', ['$scope', '$location', 'userService', function ($scope, $location, userService) {

    $scope.signup = function() {
        userService.signup(
            $scope.name, $scope.email, $scope.password,
            function(response){
                alert('Great! You are now signed in! Welcome, ' + $scope.name + '!');
                $location.path('/');
            },
            function(response){
                alert('Something went wrong with the signup process. Try again later.');
            }
        );
    }

    $scope.name = '';
    $scope.email = '';
    $scope.password = '';

    if(userService.checkIfLoggedIn())
        $location.path('/');

}]);

bbAppControllers.controller('MainController', ['$scope', '$location', 'userService', 'bookService', function ($scope, $location, userService, bookService) {
    $scope.logout = function(){
        userService.logout();
        $location.path('/login');
    }

    $scope.create = function(){

        bookService.create({
            title: $scope.currentBookTitle,
            author_name: $scope.currentBookAuthorName,
            pages_count: $scope.currentBookPagesCount
        }, function(){

            $('#addBookModal').modal('toggle');
            $scope.currentBookReset();
            $scope.refresh();

        }, function(){

            alert('Some errors occurred while communicating with the service. Try again later.');

        });

    }

    $scope.refresh = function(){

        bookService.getAll(function(response){

            $scope.books = response;

        }, function(){

            alert('Some errors occurred while communicating with the service. Try again later.');

        });

    }

    $scope.load = function(bookId){

        bookService.getById(bookId, function(response){

            $scope.currentBookId = response.book.id;
            $scope.currentBookTitle = response.book.title;
            $scope.currentBookAuthorName = response.book.author_name;
            $scope.currentBookPagesCount = response.book.pages_count;

            $('#updateBookModal').modal('toggle');

        }, function(){

            alert('Some errors occurred while communicating with the service. Try again later.');

        });

    }

    $scope.update = function(){

        bookService.update(
            $scope.currentBookId,
            {
                title: $scope.currentBookTitle,
                author_name: $scope.currentBookAuthorName,
                pages_count: $scope.currentBookPagesCount
            },
            function(response){

                $('#updateBookModal').modal('toggle');
                $scope.currentBookReset();
                $scope.refresh();

            }, function(response){
                alert('Some errors occurred while communicating with the service. Try again later.');
            }
        );

    }

    $scope.remove = function(bookId){

        if(confirm('Are you sure to remove this book from your wishlist?')){
            bookService.remove(bookId, function(){

                alert('Book removed successfully.');

            }, function(){

                alert('Some errors occurred while communicating with the service. Try again later.');

            });
        }

    }

    $scope.currentBookReset = function(){
        $scope.currentBookTitle = '';
        $scope.currentBookAuthorName = '';
        $scope.currentBookPagesCount = '';
        $scope.currentBookId = '';
    }

    if(!userService.checkIfLoggedIn())
        $location.path('/login');

    $scope.books = [];

    $scope.currentBookReset();
    $scope.refresh();

}]);