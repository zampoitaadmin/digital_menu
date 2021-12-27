
bbAppControllers.controller('productsCtrl', ['$scope', '$location','userService', 'categoryService', 'productService','$window','Notification',  function ($scope, $location, userService, categoryService, productService,$window,Notification) {
    console.info("in productsCtrl");
    $('a[href="custom-menu#products"]').click();

    $scope.resetProductData = function(){
        $scope.requestDataProduct = {'categoryId':'',  'productName':'',  'productDescription':'',  'productTopa':'',  'product1r':'',  'product12r':'',  'productPrice':'',  'allergyId':'',  'status':'',  'id':0};
    };

    $scope.loaderProduct = false;

    $scope.refreshUserSelectedCategory = function(){
        $scope.userSelectedCategories = [];
        $scope.loaderUserSelectedCategory = $window.loaderInner;
        categoryService.getUserSelectedCategories(function(response){
            $scope.userSelectedCategories = response.data.categories;
            $scope.loaderUserSelectedCategory = '';
            if(!response.status){
                //$scope.loaderCategory =  response.data.message;
                $scope.loaderUserSelectedCategory = '<span class="text-info">' + response.message + '</span>';
            }
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            $scope.loaderUserSelectedCategory = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        $scope.loaderUserSelectedCategory = $window.msgError;
                    }else {
                        $scope.loaderUserSelectedCategorys = $window.msgError;
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
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

    $scope.refreshUserSelectedCategoryProducts = function(){
        $scope.loaderProduct = $window.loaderText;
        productService.getUserSelectedCategoriesProducts(function(response){
            $scope.loaderProduct = '';
            $scope.userSelectedCategoriesProducts = response.data.products;
            if(!response.status){
                $scope.loaderProduct =  response.data.message;
                $scope.loaderProduct = '<span class="text-info">' + response.message + '</span>';
            }

        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            $scope.loaderProduct = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        $scope.loaderProduct = $window.msgError;
                    }else {
                        $scope.loaderProduct = $window.msgError;
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };

    $scope.isArrayDifferentFun = ((firstArray, secondArray) => {
        let isArrayDifferent = false;
        firstArray.forEach((val, index) => {
            if(firstArray[index] !== secondArray[index]) {
                isArrayDifferent = true;
                return;
            }
        });
        return isArrayDifferent;
    });

    $scope.currentUserCategoryOrder = [];
    $scope.sortableOptions = {
        update: function (e, ui) {
            $scope.currentUserCategoryOrder = [];
            var currentUserCategoryOrder = $scope.userSelectedCategories.map(function(element){
                return element.id;
            });
            $scope.currentUserCategoryOrder = currentUserCategoryOrder;
            console.log("Update: " + $scope.currentUserCategoryOrder);
        },
        stop: function (e, ui) {
            var newUserCategoryOrder = $scope.userSelectedCategories.map(function(element){
                return element.id;
            });
            console.log("Stop currentUserCategoryOrder : " + $scope.currentUserCategoryOrder);
            console.log("Stop newUserCategoryOrder : " + newUserCategoryOrder);
            
            let isArrayDifferent = $scope.isArrayDifferentFun($scope.currentUserCategoryOrder, newUserCategoryOrder);
            
            if(isArrayDifferent){
                let jsObject = {'newUserCategoryOrder':newUserCategoryOrder};
                $scope.currentUserCategoryOrder = newUserCategoryOrder;
                categoryService.updateUserCategoryOrder(jsObject, function(response){
                    if(response.status){
                        Notification.success(response.message);
                        $scope.onLoadFun();
                    }else{
                        Notification.error(response.message);
                        //$scope.formCrudRequestErrors.message =  response.message;
                    }
                }, function(response){
                    //alert('Some errors occurred while communicating with the service. Try again later.');
                    console.error(" In assignCategoryToUserFun ERROR");
                    //console.error(response);
                    var responseData = response.data;
                    if(response.status != 200){
                        if(angular.isObject(responseData.message)){
                            //$scope.requestFormDataError = response.data.message;
                            console.warn(responseData.message);
                        }else{
                            // bbNotification.error(response.data.message);
                            if(responseData.message.length==0){
                                $scope.loaderUserSelectedCategory = $window.msgError;
                            }else {
                                //$scope.loaderUserSelectedCategorys = $window.msgError;
                                Notification.error(responseData.message);
                                //$scope.formCrudRequestErrors.message = responseData.message ;
                                //TODO Error Msg with Refresh
                                //alert("in "+responseData.message);
                            }
                        }
                    }
                });
            }

        }
    };

    $scope.productRecordFun = function(isValidForm){
        $scope.formCrudRequestErrors = {};
        console.log($scope.requestDataProduct);
        if(isValidForm){
            if($scope.requestDataProduct.id>0){ // Update
                console.log("IN UPDATE");
                debugger;
                productService.update(
                    $scope.requestDataProduct.id,
                    {
                        allergyId: $scope.requestDataProduct.allergyId,
                        categoryId: $scope.requestDataProduct.categoryId,
                        product1r: $scope.requestDataProduct.product1r,
                        product12r: $scope.requestDataProduct.product12r,
                        productDescription: $scope.requestDataProduct.productDescription,
                        productName: $scope.requestDataProduct.productName,
                        productPrice: $scope.requestDataProduct.productPrice,
                        productTopa: $scope.requestDataProduct.productTopa,
                        status: $scope.requestDataProduct.status
                    },
                    function(response){
                        if(response.status){
                            $('#productModel').modal('hide');
                            $scope.requestDataProduct = {};
                            $scope.formCrudRequestErrors = {};
                            //alert(response.message);
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
                productService.create($scope.requestDataProduct, function(response){
                        if(response.status){
                            $scope.frmProduct.$setPristine();
                            $('#productModel').modal('hide');
                            $scope.requestDataProduct = {};
                            $scope.formCrudRequestErrors = {};
                            //alert(response.message);
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
    };

    $scope.deleteRecordFun = function(record){

        swal.fire({
            title: 'Are you sure you want to delete "'+record.product_name+'" product?',
            //text: "You won't be able to revert this("+record.name+")!",
            icon: 'warning',
            showCancelButton: true,
            //confirmButtonColor: '#3085d6',
            //cancelButtonColor: '#d33',
            //confirmButtonColor: '#2EB973',
           // cancelButtonColor: '#FA4559',
            confirmButtonText: 'Yes, delete it!'
        }).
            then((result) => {
                if(result.value){
                    productService.remove(record.product_id, function(response){
                        console.log(response);
                        if(response.status){
                            Notification.success(response.message);
                            $scope.onLoadFun();
                        }else{
                            Notification.error(response.message);
                            $scope.formCrudRequestErrors.message =  response.message;
                        }
                    }, function(response){
                        //alert('Some errors occurred while communicating with the service. Try again later.');
                        var responseData = response.data;
                        if(response.status != 200){
                            if(angular.isObject(responseData.message)){
                                //$scope.requestFormDataError = response.data.message;
                                console.warn(responseData.message);
                            }else{
                                // bbNotification.error(response.data.message);
                                if(responseData.message.length==0){
                                    $scope.loaderUserSelectedCategory = $window.msgError;
                                }else {
                                    //$scope.loaderUserSelectedCategorys = $window.msgError;
                                    Notification.error(responseData.message);
                                    //$scope.formCrudRequestErrors.message = responseData.message ;
                                    //TODO Error Msg with Refresh
                                    //alert("in "+responseData.message);
                                }
                            }
                        }
                    });
                }
            });
    };

    $scope.openAddProductModal = function(){
        $('#productModel').modal('show');
        $scope.resetProductData();
        $scope.frmProduct.$setPristine();
        $scope.addModalTitle = true;
        $scope.updateModalTitle = false;
    };

    $scope.openEditProductModal = function(record){

        $scope.resetProductData();
        $scope.frmProduct.$setPristine();

        $scope.requestDataProduct = {'categoryId':record.category_id.toString(),  'productName':record.product_name,  'productDescription':record.product_description,  'productTopa':record.product_topa,  'product1r':record.product_1r,  'product12r':record.product_12r,  'productPrice':record.product_price,  'allergyId':record.allergyIdArray,  'status':record.status,  'id':record.product_id};

        $('#productModel').modal('show');

        $scope.addModalTitle = false;
        $scope.updateModalTitle = true;
    };

    $scope.onLoadFun = function(){
        $scope.refreshUserSelectedCategory();
        $scope.refreshAllAllergies();
        $scope.refreshUserSelectedCategoryProducts();
        $scope.resetProductData();
    };

    $scope.userSelectedCategories = [];
    $scope.onLoadFun();
    
}]);
