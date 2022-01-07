
bbAppControllers.controller('productsCtrl', ['$scope', '$location','userService', 'categoryService', 'productService','$window','Notification','$sce','$timeout',  function ($scope, $location, userService, categoryService, productService,$window,Notification,$sce,$timeout) {
    console.info("in productsCtrl");
    $('a[href="custom-menu#products"]').click();

    $scope.resetProductData = function(){
        $scope.requestDataProduct = {'categoryId':'',  'productName':'',  'productDescription':'',  'productTopa':'',  'product1r':'',  'product12r':'',  'productPrice':'',  'allergyId':[],  'status':'',  'id':0,  'productMainImage':''};
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
            // $scope.allAllergies = response.data.allAllergies;
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
                
                let updateItemCategoryKey = $scope.updateItem.categoryKey;
                let updateItemProductKey = $scope.updateItem.productKey;
                $scope.requestDataProduct.appLanguage = appLanguage;
                console.log("IN UPDATE");

                let formData = new FormData();
                formData.append('allergyId', JSON.stringify($scope.requestDataProduct.allergyId));
                formData.append('appLanguage', $scope.requestDataProduct.appLanguage);
                formData.append('categoryId', $scope.requestDataProduct.categoryId);
                formData.append('id', $scope.requestDataProduct.id);
                formData.append('product1r', $scope.requestDataProduct.product1r);
                formData.append('product12r', $scope.requestDataProduct.product12r);
                formData.append('productDescription', $scope.requestDataProduct.productDescription);
                if($scope.requestDataProduct.productMainImage){
                    formData.append('productMainImage', $scope.requestDataProduct.productMainImage);
                }else{
                    formData.append('productMainImage', '');
                }
                formData.append('productName', $scope.requestDataProduct.productName);
                formData.append('productPrice', $scope.requestDataProduct.productPrice);
                formData.append('productTopa', $scope.requestDataProduct.productTopa);
                formData.append('status', $scope.requestDataProduct.status);

                /*productService.update(
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
                        status: $scope.requestDataProduct.status,
                        appLanguage: appLanguage
                    },*/
                productService.update(formData,
                    function(response){
                        if(response.status){
                            $('#productModel').modal('hide');
                            $scope.requestDataProduct = {};
                            $scope.formCrudRequestErrors = {};
                            Notification.success(response.message);
                            // $scope.onLoadFun();
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
                console.log("IN ADD");
                $scope.requestDataProduct.appLanguage = appLanguage;

                let formData = new FormData();
                formData.append('allergyId', JSON.stringify($scope.requestDataProduct.allergyId));
                formData.append('appLanguage', $scope.requestDataProduct.appLanguage);
                formData.append('categoryId', $scope.requestDataProduct.categoryId);
                formData.append('id', $scope.requestDataProduct.id);
                formData.append('product1r', $scope.requestDataProduct.product1r);
                formData.append('product12r', $scope.requestDataProduct.product12r);
                formData.append('productDescription', $scope.requestDataProduct.productDescription);
                formData.append('productMainImage', $scope.requestDataProduct.productMainImage);
                formData.append('productName', $scope.requestDataProduct.productName);
                formData.append('productPrice', $scope.requestDataProduct.productPrice);
                formData.append('productTopa', $scope.requestDataProduct.productTopa);
                formData.append('status', $scope.requestDataProduct.status);

                // productService.create($scope.requestDataProduct, function(response){
                productService.create(formData, function(response){
                        if(response.status){
                            $scope.frmProduct.$setPristine();
                            $('#productModel').modal('hide');
                            $scope.requestDataProduct = {};
                            $scope.formCrudRequestErrors = {};
                            $scope.userSelectedCategoriesProducts[response.data.appendCategoryIndex].responseProducts.push(response.data.appendProduct);
                            Notification.success(response.message);
                            // $timeout(function(){
                                // $scope.onLoadFun();
                                // $('#faq .collapse').collapse('hide');
                                // $('#salads').collapse('toggle');
                            // }, 200);
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

    $scope.deleteRecordFun = function(record,categoryKey){
        swal.fire({
            // title: 'Are you sure you want to delete "'+record.product_name+'" product?',
            title: deleteConfirmationText,
            //text: "You won't be able to revert this("+record.name+")!",
            icon: 'warning',
            showCancelButton: true,
            //confirmButtonColor: '#3085d6',
            //cancelButtonColor: '#d33',
            //confirmButtonColor: '#2EB973',
           // cancelButtonColor: '#FA4559',
            confirmButtonText: btnYesDelete,
            cancelButtonText: btnCancelDelete,
        }).
            then((result) => {
                if(result.value){
                    productService.remove(record.product_id, appLanguage, function(response){
                        console.log(response);
                        if(response.status){
                            Notification.success(response.message);
                            // $scope.onLoadFun();
                            $scope.userSelectedCategoriesProducts[categoryKey].responseProducts = response.data;
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

    $scope.getDropifyConfig = function(){
        let drConfig = {};
        if(appLanguage == "en"){
            drConfig = {
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            };
        }else if(appLanguage == "es"){
            drConfig = {
                messages: {
                    'default': 'es Drag and drop a file here or click',
                    'replace': 'es Drag and drop or click to replace',
                    'remove':  'es Remove',
                    'error':   'es Ooops, something wrong happended.'
                }
            };
        }
        return drConfig;
    }

    var dropifyProduct;
    dropifyProduct = $('.dropifyProduct').dropify( $scope.getDropifyConfig() );

    dropifyProduct.on('dropify.beforeClear', function(event, element){
        if( $('#productModel').is(':visible') ){
            let productId = $scope.requestDataProduct.id;
            if(productId>0){
                swal.fire({
                    title: 'Are you sure you want to delete?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).
                then((result) => {
                    if(result.value){
                        productService.removeProductMainImage(productId, function(response){
                            console.log(response);
                            if(response.status){
                                Notification.success(response.message);
                                // $scope.onLoadFun();
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
            }
            else{
                // event.preventDefault();
            }
        }
    });

    dropifyProduct = dropifyProduct.data('dropify');
    if(!dropifyProduct.isDropified()){
        dropifyProduct.init();
    }

    $scope.openAddProductModal = function(){
        $('#productModel').modal('show');
        $scope.resetProductData();
        $scope.frmProduct.$setPristine();
        $scope.addModalTitle = true;
        $scope.updateModalTitle = false;

        var dropifyProduct = $('.dropifyProduct').dropify( $scope.getDropifyConfig() );
        dropifyProduct = dropifyProduct.data('dropify');
        dropifyProduct.resetPreview();
        dropifyProduct.clearElement();
        dropifyProduct.settings['defaultFile'] = '';
        dropifyProduct.destroy();
        dropifyProduct.init();
    };

    $scope.openEditProductModal = function(record,categoryKey,productKey){
        var dropifyProduct = $('.dropifyProduct').dropify( $scope.getDropifyConfig() );
        dropifyProduct = dropifyProduct.data('dropify');
        dropifyProduct.resetPreview();
        dropifyProduct.clearElement();
        dropifyProduct.settings['defaultFile'] = record.productMainImageUrl;
        dropifyProduct.destroy();
        dropifyProduct.init();

        $scope.updateItem = {categoryKey, productKey};
        $scope.resetProductData();
        $scope.frmProduct.$setPristine();
        $scope.requestDataProduct = {'categoryId':record.category_id.toString(),  'productName':record.product_name,  'productDescription':record.product_description,  'productTopa':record.product_topa,  'product1r':record.product_1r,  'product12r':record.product_12r,  'productPrice':record.product_price,  
        // 'allergyId':record.allergyIdArray,  
        'allergyId':[],  
        // 'productMainImage':'',  
        'status':record.status,  'id':record.product_id};
        
        console.log($scope.allAllergies);
        console.log(record.allergyIdArray);

        if(record.allergyIdArray.length>0){
            record.allergyIdArray.map(function(currentValue, index, arr){
                for (var i = 0; i < $scope.allAllergies.length; i++) {
                    if($scope.allAllergies[i].id==currentValue.id){
                        $scope.requestDataProduct.allergyId.push($scope.allAllergies[i]);
                    }
                }
            });
        }

        $('#productModel').modal('show');
        // $('.dropifyProduct').data('product_id', record.product_id);
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

    $scope.currentProductOrder= [];
    $scope.newProductOrder = [];

    $scope.sortableOptionsProducts = {
        update: function (e, ui) {
            let categoryId = $(e.target).data("data_category_id");
            let currentProductOrder = [];
            for(var i = 0; i < $scope.userSelectedCategoriesProducts.length; i++)
            {
                if(categoryId == $scope.userSelectedCategoriesProducts[i].id){
                    if($scope.userSelectedCategoriesProducts[i].responseProducts.length > 0){
                        for(var j = 0; j < $scope.userSelectedCategoriesProducts[i].responseProducts.length; j++)
                        {
                            currentProductOrder.push($scope.userSelectedCategoriesProducts[i].responseProducts[j].product_id);
                        }
                    }
                }
            }
            $scope.currentProductOrder= currentProductOrder;
            console.log("$scope.currentProductOrder " + $scope.currentProductOrder);
        },
        stop: function (e, ui) {
            let categoryId = $(e.target).data("data_category_id");
            let newProductOrder = [];
            for(var i = 0; i < $scope.userSelectedCategoriesProducts.length; i++)
            {
                if(categoryId == $scope.userSelectedCategoriesProducts[i].id){
                    if($scope.userSelectedCategoriesProducts[i].responseProducts.length > 0){
                        for(var j = 0; j < $scope.userSelectedCategoriesProducts[i].responseProducts.length; j++)
                        {
                            newProductOrder.push($scope.userSelectedCategoriesProducts[i].responseProducts[j].product_id);
                        }
                    }
                }
            }
            $scope.newProductOrder = newProductOrder;
            console.log($scope.newProductOrder);
            console.log("$scope.newProductOrder " + $scope.newProductOrder);

            let isArrayDifferent = $scope.isArrayDifferentFun($scope.currentProductOrder, $scope.newProductOrder);
            
            if(isArrayDifferent){
                let jsObject = {'categoryId':categoryId,'newProductOrder':newProductOrder};
                productService.updateUserCategoryProductOrder(jsObject, function(response){
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
    $timeout(function(){
        $('.ui-select-container').find('input[type="text"]').css('width', '100%');
    }, 200);

    $scope.productUploadedFile = function (element) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $scope.$apply(function ($scope) {
                $scope.requestDataProduct.productMainImage = element.files[0];
            });
        }
        reader.readAsDataURL(element.files[0]);
    }
}]);