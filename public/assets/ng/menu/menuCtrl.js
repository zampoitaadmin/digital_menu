
bbAppControllers.controller('menuCtrl', ['$scope', '$window', '$location','$stateParams', 'menuService', 'Notification', function ($scope, $window, $location, $stateParams, menuService, Notification) {
    console.info("IN Menu Ctrl");
    $scope.searchText = "";
    $scope.brandColor = '#A77337'; // 
    $scope.secondaryColor = '#000000'; // 
    $scope.thirdColor = '#ffffff'; // 
    $scope.loaderMenu = false;
    $scope.loadMenuPage = function() {
        $scope.loaderMenu = $window.loaderText;
        var appLanguage = "en";
        menuService.getBySlug($stateParams.slug, appLanguage, function(response){
                $scope.loaderMenu = '';
                $scope.userInfo = response.data.data.userInfo;
                $scope.branding = response.data.data.branding;
                $scope.userSelectedCategories = response.data.data.categories;
                let allAllergies = [];
                angular.forEach(response.data.data.allAllergies, function (value, key) {
                    this.push({
                        'id': value.id,
                        'name': value.name,
                    });
                }, allAllergies);
                $scope.allAllergies = allAllergies;

                if($scope.branding){
                    $scope.brandColor = $scope.branding.brand_color;
                    $scope.secondaryColor = $scope.branding.secondary_color;
                    $scope.thirdColor = $scope.branding.third_color;
                }

                if(!response.status){
                    $scope.loaderMenu =  response.data.data.message;
                    $scope.loaderMenu = '<span class="text-info">' + response.message + '</span>';
                }
            },
            function(response){
                // console.error(response);
                console.error("IN SSO Ctrl Error");
                $scope.loaderMenu = '';
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
    };
    $scope.searchItem = function() {
        // console.log($scope.searchText);
        $scope.loaderMenu = $window.loaderText;
        let formData = new FormData();
        formData.append('slug', $stateParams.slug);
        formData.append('searchText', $scope.searchText);
        menuService.searchItem(formData, function(response){
                $scope.loaderMenu = '';
                if(response.status){
                    $scope.userSelectedCategories = response.data.categories;
                }else{
                    //
                }
            }, function(response){
                console.error(" In Update ERROR");
                var responseData = response.data;
                if(response.status != 200){
                    if(angular.isObject(responseData.message)){
                        $scope.formCrudRequestErrors =  responseData.message;
                    }else{
                        if(responseData.message.length==0){
                            $scope.formCrudRequestErrors.message = $window.msgError;
                        }else {
                            Notification.error(responseData.message);
                        }
                    }
                }
            }
        );
    };
    $scope.showRecordFun = function(record){
        $scope.formCrudRequestData = { 'productMainImageUrl':record.productMainImageUrl,
            'responseAllergies':record.responseAllergies,
            'productPrice':record.product_price,
            'productName':record.product_name,
            'productDescription':record.product_description,
            'id':record.product_id };
        $('#regular_modal').modal('show');
    };
    //if(ssoService.checkIfLoggedIn())
    //$location.path('/'); //Redirect on merchant page
    $scope.loadMenuPage();
}]);