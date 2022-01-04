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

    $scope.mainCourses = [];
    $scope.mainCourses.push({
        'productId': '',
        'productName': '',
        'allergyId': '',
        'mainCourseProductMainImage': '',
        'productDescription': '',
    });

    $scope.deserts = [];
    $scope.deserts.push({
        'productId': '',
        'productName': '',
        'allergyId': '',
        'desertProductMainImage': '',
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
        $scope.initDropify();
    };
	$scope.removeStarter = function(starter){
		var index = $scope.starters.indexOf(starter);
		$scope.starters.splice(index, 1);
    };

    $scope.addNewMainCourse = function(){
        $scope.mainCourses.push({
            'productId': '',
            'productName': '',
            'allergyId': '',
            'mainCourseProductMainImage': '',
            'productDescription': '',
        });
        $scope.initDropify();
    };
    $scope.removeMainCourse = function(mainCourse){
        var index = $scope.mainCourses.indexOf(mainCourse);
        $scope.mainCourses.splice(index, 1);
    };

    $scope.addNewDesert = function(){
        $scope.deserts.push({
            'productId': '',
            'productName': '',
            'allergyId': '',
            'desertProductMainImage': '',
            'productDescription': '',
        });
        $scope.initDropify();
    };
    $scope.removeDesert = function(desert){
        var index = $scope.deserts.indexOf(desert);
        $scope.deserts.splice(index, 1);
    };

    $scope.refreshAllAllergies = function(){
        $scope.allAllergies = [];
        // $scope.loaderUserSelectedCategory = $window.loaderInner;
        categoryService.getAllAllergies(function(response){
            let allAllergies = [];
            angular.forEach(response.data.allAllergies, function (value, key) {
                this.push({
                    'id': value.id,
                    'name': value.name,
                });
            }, allAllergies);
            $scope.allAllergies = allAllergies;
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

    $scope.initDropify = function(){
        $timeout(function(){
            $('.dropify').dropify();
        }, 200);
    };

    $scope.refreshFixedMenuData = function(){
        let categoryId = $stateParams.categoryId;
        fixedMenuService.getMerchantFixedMenu(categoryId, function(response){
            if(response.status){
                $timeout(function(){
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
                            let tempJsObject = {
                                'productId': value.product_id,
                                'productName': value.product_name,
                                'allergyId': [],
                                // 'starterProductMainImage': '',
                                'fileUrl': value.fileUrl,
                                'productDescription': value.product_description,
                            };
                            let tempArr = [];
                            if(value.allergyIdArr.length>0){
                                value.allergyIdArr.map(function(currentValue, index, arr){
                                    for (var i = 0; i < $scope.allAllergies.length; i++) {
                                        if($scope.allAllergies[i].id==currentValue){
                                            tempArr.push($scope.allAllergies[i]);
                                        }
                                    }
                                });
                            }
                            tempJsObject["allergyId"] = tempArr;
                            $scope.starters.push(tempJsObject);
                        });
                    }
                    else{
                        $scope.starters.push({
                            'productId': '',
                            'productName': '',
                            'allergyId': '',
                            'starterProductMainImage': '',
                            'fileUrl': '',
                            'productDescription': '',
                        });
                    }
                    $scope.mainCourses = [];
                    if(response.data.courseProductData.length>0){
                        $.each(response.data.courseProductData, function (key, value) {
                            let tempJsObject = {
                                'productId': value.product_id,
                                'productName': value.product_name,
                                'allergyId': [],
                                // 'mainCourseProductMainImage': '',
                                'fileUrl': value.fileUrl,
                                'productDescription': value.product_description,
                            };
                            let tempArr = [];
                            if(value.allergyIdArr.length>0){
                                value.allergyIdArr.map(function(currentValue, index, arr){
                                    for (var i = 0; i < $scope.allAllergies.length; i++) {
                                        if($scope.allAllergies[i].id==currentValue){
                                            tempArr.push($scope.allAllergies[i]);
                                        }
                                    }
                                });
                            }
                            tempJsObject["allergyId"] = tempArr;
                            $scope.mainCourses.push(tempJsObject);
                        });
                    }
                    else{
                        $scope.mainCourses.push({
                            'productId': '',
                            'productName': '',
                            'allergyId': '',
                            'mainCourseProductMainImage': '',
                            'fileUrl': '',
                            'productDescription': '',
                        });
                    }
                    $scope.deserts = [];
                    if(response.data.desertProductData.length>0){
                        $.each(response.data.desertProductData, function (key, value) {
                            let tempJsObject = {
                                'productId': value.product_id,
                                'productName': value.product_name,
                                'allergyId': [],
                                // 'desertProductMainImage': '',
                                'fileUrl': value.fileUrl,
                                'productDescription': value.product_description,
                            };
                            let tempArr = [];
                            if(value.allergyIdArr.length>0){
                                value.allergyIdArr.map(function(currentValue, index, arr){
                                    for (var i = 0; i < $scope.allAllergies.length; i++) {
                                        if($scope.allAllergies[i].id==currentValue){
                                            tempArr.push($scope.allAllergies[i]);
                                        }
                                    }
                                });
                            }
                            tempJsObject["allergyId"] = tempArr;
                            $scope.deserts.push(tempJsObject);
                        });
                    }
                    else{
                        $scope.deserts.push({
                            'productId': '',
                            'productName': '',
                            'allergyId': '',
                            'desertProductMainImage': '',
                            'fileUrl': '',
                            'productDescription': '',
                        });
                    }

                    $scope.initDropify();
                }, 200);
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
    };

    $scope.onLoadFun = function(){
        $scope.refreshAllAllergies();
        $scope.refreshFixedMenuData();

        $scope.initDropify();
    };

    $scope.onLoadFun();

    $scope.fixedMenuRecordFun = function(isValidForm){
        $scope.formCrudRequestErrors = {};
        // console.log($scope.requestDataFixedMenu);
        // console.log($scope.starters);

        if(isValidForm){
            let responseStarter = [];
            angular.forEach($scope.starters, function (value, key) {
                this.push({
                    'productId': value.productId,
                    'allergyId': value.allergyId,
                    'productDescription': value.productDescription,
                    'productName': value.productName,
                    'starterProductMainImage': value.starterProductMainImage,
                    'fileUrl': value.fileUrl
                });
            }, responseStarter);
            $scope.requestDataFixedMenu.starterData = responseStarter;

            let responseMainCourse = [];
            angular.forEach($scope.mainCourses, function (value, key) {
                this.push({
                    'productId': value.productId,
                    'allergyId': value.allergyId,
                    'productDescription': value.productDescription,
                    'productName': value.productName,
                    'mainCourseProductMainImage': value.mainCourseProductMainImage,
                    'fileUrl': value.fileUrl
                });
            }, responseMainCourse);
            $scope.requestDataFixedMenu.mainCourseData = responseMainCourse;

            let responseDesert = [];
            angular.forEach($scope.deserts, function (value, key) {
                this.push({
                    'productId': value.productId,
                    'allergyId': value.allergyId,
                    'productDescription': value.productDescription,
                    'productName': value.productName,
                    'desertProductMainImage': value.desertProductMainImage,
                    'fileUrl': value.fileUrl
                });
            }, responseDesert);
            $scope.requestDataFixedMenu.desertData = responseDesert;

            // console.log("Valid: " + JSON.stringify($scope.requestDataFixedMenu));

            // return;

            if($scope.requestDataFixedMenu.merchantFixedMenuDataId>0){ // Update
                console.log("IN UPDATE");
                // console.log($scope.requestDataFixedMenu);

                let formData = new FormData();
                formData.append('categoryId', $scope.requestDataFixedMenu.categoryId);
                formData.append('categoryName', $scope.requestDataFixedMenu.categoryName);
                formData.append('changeCategoryName', $scope.requestDataFixedMenu.changeCategoryName);
                formData.append('desertData', $scope.requestDataFixedMenu.desertData);
                formData.append('fixedMenuPrice', $scope.requestDataFixedMenu.fixedMenuPrice);
                formData.append('id', $scope.requestDataFixedMenu.id);
                formData.append('mainCourseData', $scope.requestDataFixedMenu.mainCourseData);
                formData.append('menuDescriptionConditions', $scope.requestDataFixedMenu.menuDescriptionConditions);
                formData.append('merchantFixedMenuDataId', $scope.requestDataFixedMenu.merchantFixedMenuDataId);
                formData.append('starterData', JSON.stringify($scope.requestDataFixedMenu.starterData));
                angular.forEach($scope.requestDataFixedMenu.starterData, function (value, key) {
                    if(value.starterProductMainImage!="")
                        formData.append(`starter_${key}`,value.starterProductMainImage);
                });
                formData.append('mainCourseData', JSON.stringify($scope.requestDataFixedMenu.mainCourseData));
                angular.forEach($scope.requestDataFixedMenu.mainCourseData, function (value, key) {
                    if(value.mainCourseProductMainImage!="")
                        formData.append(`mainCourse_${key}`,value.mainCourseProductMainImage);
                });
                formData.append('desertData', JSON.stringify($scope.requestDataFixedMenu.desertData));
                angular.forEach($scope.requestDataFixedMenu.desertData, function (value, key) {
                    if(value.desertProductMainImage!="")
                        formData.append(`desert_${key}`,value.desertProductMainImage);
                });

                fixedMenuService.update(formData,
                    function(response){
                        if(response.status){
                            Notification.success(response.message);
                            $scope.onLoadFun();
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
                console.log("IN ADD");
                console.log($scope.requestDataFixedMenu);
                let formData = new FormData();
                formData.append('categoryId', $scope.requestDataFixedMenu.categoryId);
                formData.append('categoryName', $scope.requestDataFixedMenu.categoryName);
                formData.append('changeCategoryName', $scope.requestDataFixedMenu.changeCategoryName);
                formData.append('desertData', $scope.requestDataFixedMenu.desertData);
                formData.append('fixedMenuPrice', $scope.requestDataFixedMenu.fixedMenuPrice);
                formData.append('id', $scope.requestDataFixedMenu.id);
                formData.append('mainCourseData', $scope.requestDataFixedMenu.mainCourseData);
                formData.append('menuDescriptionConditions', $scope.requestDataFixedMenu.menuDescriptionConditions);
                formData.append('merchantFixedMenuDataId', $scope.requestDataFixedMenu.merchantFixedMenuDataId);
                formData.append('starterData', JSON.stringify($scope.requestDataFixedMenu.starterData));
                angular.forEach($scope.requestDataFixedMenu.starterData, function (value, key) {
                    if(value.starterProductMainImage!="")
                        formData.append(`starter_${key}`,value.starterProductMainImage);
                });
                formData.append('mainCourseData', JSON.stringify($scope.requestDataFixedMenu.mainCourseData));
                angular.forEach($scope.requestDataFixedMenu.mainCourseData, function (value, key) {
                    if(value.mainCourseProductMainImage!="")
                        formData.append(`mainCourse_${key}`,value.mainCourseProductMainImage);
                });
                formData.append('desertData', JSON.stringify($scope.requestDataFixedMenu.desertData));
                angular.forEach($scope.requestDataFixedMenu.desertData, function (value, key) {
                    if(value.desertProductMainImage!="")
                        formData.append(`desert_${key}`,value.desertProductMainImage);
                });
                fixedMenuService.create(formData, function(response){
                // fixedMenuService.create($scope.requestDataFixedMenu, function(response){
                        if(response.status){
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

    $scope.starterUploadedFile = function (element) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $scope.$apply(function ($scope) {
                let ngRepeatIndex = $(element).data("ng_repeat_index_starter");
                $scope.starters[ngRepeatIndex].starterProductMainImage = element.files[0];
            });
        }
        reader.readAsDataURL(element.files[0]);
    }

    $scope.mainCourseUploadedFile = function (element) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $scope.$apply(function ($scope) {
                let ngRepeatIndex = $(element).data("ng_repeat_index_main_course");
                $scope.mainCourses[ngRepeatIndex].mainCourseProductMainImage = element.files[0];
            });
        }
        reader.readAsDataURL(element.files[0]);
    }

    $scope.desertUploadedFile = function (element) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $scope.$apply(function ($scope) {
                let ngRepeatIndex = $(element).data("ng_repeat_index_desert");
                $scope.deserts[ngRepeatIndex].desertProductMainImage = element.files[0];
            });
        }
        reader.readAsDataURL(element.files[0]);
    }
}]);