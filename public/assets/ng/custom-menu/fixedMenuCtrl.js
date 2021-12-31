// Dropzone.autoDiscover = false;
// var starterDropzone;
bbAppControllers.controller('fixedMenuCtrl', ['$scope', '$location','$stateParams','userService', 'categoryService', 'productService', 'fixedMenuService','$window','Notification','$sce','$timeout',  function ($scope, $location, $stateParams, userService, categoryService, productService, fixedMenuService, $window,Notification,$sce,$timeout) {
	
	$scope.starters = [];
	$scope.starters.push({
		'productId': '',
        'productName': '',
		'allergyId': '',
		'starterProductMainImage': '',
		'productDescription': '',
	});
	$scope.requestDataFixedMenu = {'categoryId':$stateParams.categoryId,
        'categoryName':'',
        'changeCategoryName':'',
        'menuDescriptionConditions':'',
        'fixedMenuPrice':'',
        'id':0,
        'merchantFixedMenuDataId':0,
    };

	$scope.addNewStarter = function(){
		$scope.starters.push({
			'productId': '',
            'productName': '',
			'allergyId': '',
			'starterProductMainImage': '',
			'productDescription': '',
		});
        $scope.initStarterDropify();
    };

	$scope.removeStarter = function(starter){
		var index = $scope.starters.indexOf(starter);
		$scope.starters.splice(index, 1);
    };

    $scope.refreshAllAllergies = function(){
        $scope.allAllergies = [];
        // $scope.loaderUserSelectedCategory = $window.loaderInner;
        categoryService.getAllAllergies(function(response){
            $scope.allAllergies = response.data.allAllergies;
            // $scope.loaderUserSelectedCategory = '';
            if(!response.status){
                // $scope.loaderUserSelectedCategory = '<span class="text-info">' + response.message + '</span>';
            }
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            // $scope.loaderUserSelectedCategory = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    console.warn(responseData.message);
                }else{
                    if(responseData.message.length==0){
                        // $scope.loaderUserSelectedCategory = $window.msgError;
                    }else {
                        // $scope.loaderUserSelectedCategorys = $window.msgError;
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };

    $scope.initStarterDropify = function(){
        $timeout(function(){
            $('.dropify').dropify();
        }, 200);
    };

    $scope.refreshFixedMenuData = function(){
        let categoryId = $stateParams.categoryId;
        fixedMenuService.getMerchantFixedMenu(categoryId, function(response){
            if(response.status){
                $scope.requestDataFixedMenu = {'categoryId':$stateParams.categoryId,
                    'categoryName':response.data.categoryInfo.name,
                    'changeCategoryName':(response.data.userCategoryInfo) ? response.data.userCategoryInfo.change_category_name : '',
                    'menuDescriptionConditions':(response.data.fixedMenuInfo) ? response.data.fixedMenuInfo.menu_description_conditions : '',
                    'fixedMenuPrice':(response.data.fixedMenuInfo) ? response.data.fixedMenuInfo.price : 0,
                    'id':0,
                    'merchantFixedMenuDataId':(response.data.fixedMenuInfo) ? response.data.fixedMenuInfo.id : 0,
                };
                $scope.starters = [];
                if(response.data.starterProductData.length>0){
                    $.each(response.data.starterProductData, function (key, value) {
                        $scope.starters.push({
                            'productId': value.product_id,
                            'productName': value.product_name,
                            'allergyId': value.allergyIdArr,
                            // 'starterProductMainImage': '',
                            'productDescription': value.product_description,
                        });
                    });
                }
                else{
                    $scope.starters.push({
                        'productId': '',
                        'productName': '',
                        'allergyId': '',
                        'starterProductMainImage': '',
                        'productDescription': '',
                    });
                }
            }
        }, function(response){
            if(response.status!=200){
                if(angular.isObject(response.data.message)){
                    //$scope.requestFormDataError = response.data.message;
                }else{
                    // bbNotification.error(response.data.message);
                    if(!$scope.messageBrand){
                        $scope.messageBrand = '<span class="text-danger">Some errors occurred while communicating with the service. Try again later.</span>';
                    }else {
                        $scope.messageBrand = '<span class="text-danger">' + response.data.message + '</span>';
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
        //
        /*categoryService.getById(categoryId, function(response){
            $scope.requestDataFixedMenu.categoryName = response.data.name;
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    console.warn(responseData.message);
                }else{
                    if(responseData.message.length==0){
                    }else {
                    }
                }
            }
        });*/
    };

    $scope.onLoadFun = function(){
        $scope.refreshAllAllergies();
        $scope.refreshFixedMenuData();
        // initStarterDropzone();
        $scope.initStarterDropify();
    };

    $scope.onLoadFun();

    $scope.fixedMenuRecordFun = function(isValidForm){

        $scope.formCrudRequestErrors = {};
        console.log($scope.requestDataFixedMenu);

        // if(isValidForm){
        if(1){
            let responseStarter = [];
            angular.forEach($scope.starters, function (value, key) {
                this.push({
                    'productId': value.productId,
                    'allergyId': value.allergyId,
                    'productDescription': value.productDescription,
                    'productName': value.productName,
                    'starterProductMainImage': value.starterProductMainImage
                });
            }, responseStarter);
            $scope.requestDataFixedMenu.starterData = responseStarter;

            if($scope.requestDataFixedMenu.merchantFixedMenuDataId>0){ // Update
                console.log("IN UPDATE");
                console.log($scope.requestDataFixedMenu);
                fixedMenuService.update(
                    $scope.requestDataFixedMenu.merchantFixedMenuDataId,
                    {
                        categoryId: $scope.requestDataFixedMenu.categoryId,
                        categoryName: $scope.requestDataFixedMenu.categoryName,
                        changeCategoryName: $scope.requestDataFixedMenu.changeCategoryName,
                        fixedMenuPrice: $scope.requestDataFixedMenu.fixedMenuPrice,
                        id: $scope.requestDataFixedMenu.id,
                        menuDescriptionConditions: $scope.requestDataFixedMenu.menuDescriptionConditions,
                        starterData: $scope.requestDataFixedMenu.starterData,
                        courseData: $scope.requestDataFixedMenu.courseData,
                        desertData: $scope.requestDataFixedMenu.desertData,
                    },
                    function(response){
                        debugger;
                        return;
                        if(response.status){
                            $('#productModel').modal('hide');
                            let productId = $scope.requestDataProduct.id;
                            $scope.requestDataProduct = {};
                            $scope.formCrudRequestErrors = {};

                            Notification.success(response.message);
                            // $scope.onLoadFun();
                            // 
                            $scope.userSelectedCategoriesProducts[updateItemCategoryKey].responseProducts[updateItemProductKey] = response.data;
                        }else{
                            Notification.error(response.message);
                            $scope.formCrudRequestErrors.message =  response.message;
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
            }
            else{ // Add
                return;
                console.log("IN ADD");
                // console.log($scope.requestDataFixedMenu);
                fixedMenuService.create($scope.requestDataFixedMenu, function(response){
                        if(response.status){
                            /*$scope.frmFixedMenu.$setPristine();
                            $scope.requestDataFixedMenu = {'categoryId':$stateParams.categoryId,
                                'categoryName':'',
                                'changeCategoryName':'',
                                'menuDescriptionConditions':'',
                                'fixedMenuPrice':'',
                                'id':0,
                                'merchantFixedMenuDataId':0,
                            };
                            $scope.requestDataFixedMenu.starterData = [];
                            $scope.starters = [];
                            $scope.starters.push({
                                'productId': '',
                                'productName': '',
                                'allergyId': '',
                                'starterProductMainImage': '',
                                'productDescription': '',
                            });
                            $scope.formCrudRequestErrors = {};*/
                            Notification.success(response.message);
                            $scope.onLoadFun();
                        }else{
                            Notification.error(response.message);
                            $scope.formCrudRequestErrors.message =  response.message;
                        }
                    }, function(response){
                        console.error(" In CREATE ERROR");
                        var responseData = response.data;
                        if(response.status != 200){
                            if(angular.isObject(responseData.message)){
                                console.warn(responseData.message);
                                $scope.formCrudRequestErrors =  responseData.message;
                            }else{
                                if(responseData.message.length==0){
                                    // $scope.loaderUserSelectedCategory = $window.msgError;
                                    $scope.formCrudRequestErrors.message = $window.msgError;
                                }else {
                                    Notification.error(responseData.message);
                                }
                            }
                        }
                    }
                );
            }
        }
        else{
            //
        }

    };
}]);