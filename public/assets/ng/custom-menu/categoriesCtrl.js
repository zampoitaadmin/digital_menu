bbAppControllers.controller('categoriesCtrl', ['$scope', '$location','userService', 'categoryService','bbNotification','$window','Notification', function ($scope, $location, userService, categoryService,bbNotification,$window,Notification) {
    //if(!userService.checkIfLoggedIn())
    //Notification.error('Error notification');
  //  Notification.success({message: 'Success notification<br>Some other <b>content</b><br><a href="https://github.com/alexcrack/angular-ui-notification">This is a link</a><br><img src="https://angularjs.org/img/AngularJS-small.png">', title: 'Html content'});
    //  window.location = '/';//$location.path('/sso/');
    console.info("in CustomMenuCategoryController");
    $('a[href="custom-menu#categories"]').click();
    $scope.isCategoryLoader = false;
    $scope.loaderCategory = false;
    $scope.loaderUserCategory = false;
    $scope.loaderUserSelectedCategory = false;
    $scope.refreshRecords = function(){
        $scope.categories = [];
        $scope.userCategoryIdsArray = [];
        $scope.loaderCategory = $window.loaderText;
        categoryService.getAll(function(response){
            $scope.loaderCategory = '';
            $scope.categories = response.data.categories;
            $scope.userCategoryIdsArray = response.data.userCategoryIdsArray;
            $scope.userCreatedCategoryIdsArray = response.data.userCreatedCategoryIdsArray;
            if(!response.status){
                //$scope.loaderCategory =  response.data.message;
                $scope.loaderCategory = '<span class="text-info">' + response.message + '</span>';
            }
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            $scope.loaderCategory = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        $scope.loaderCategory = $window.msgError;
                    }else {
                        $scope.loaderCategory = $window.msgError;
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
    $scope.refreshUserCategory = function(){
        $scope.userCategories = [];
        $scope.loaderUserCategory = $window.loaderText;
        categoryService.getAllOnlyByUser(function(response){
            $scope.userCategories = response.data.categories;
            $scope.loaderUserCategory = '';
            if(!response.status){
                //$scope.loaderCategory =  response.data.message;
                $scope.loaderUserCategory = '<span class="text-info">' + response.message + '</span>';
            }
        }, function(response){
            console.error("IN CustomMenuCategoryController Ctrl Error");
            $scope.loaderUserCategory = '';
            var responseData = response.data;
            console.log(response);
            if(response.status != 200){
                if(angular.isObject(responseData.message)){
                    //$scope.requestFormDataError = response.data.message;
                    console.warn(responseData.message);
                }else{
                    // bbNotification.error(response.data.message);
                    if(responseData.message.length==0){
                        $scope.loaderUserCategory = $window.msgError;
                    }else {
                        $scope.loaderUserCategory = $window.msgError;
                        //$scope.formCrudRequestErrors.message = responseData.message ;
                        //TODO Error Msg with Refresh
                        //alert("in "+responseData.message);
                    }
                }
            }
            //alert('Some errors occurred while communicating with the service. Try again later.');
        });
    };
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
    //if(!userService.checkIfLoggedIn())
    //    window.location = '/';//$location.path('/sso/');

    $scope.categorySubSectionChange = function(categorySubSection){
        $scope.requestDataCategory = {'categoryNameSp':'','categoryNameEn':''};
        $scope.formCrudRequestData = {'categoryNameSp':'','categoryNameEn':'','id':''};
        $scope.formCrudRequestErrors.message =  '';
        if(categorySubSection == "chooseCategory"){
            $scope.categorySubSection = 'chooseCategory';
            $scope.refreshRecords();
            $scope.refreshUserCategory();
        }
        else if(categorySubSection == "createOwnCategory"){
            $scope.categorySubSection = 'createOwnCategory';
        }
    };

    $scope.categories = [];
    $scope.userCategories = [];
    $scope.userSelectedCategories = [];
    $scope.userCreatedCategories = [];
    $scope.categorySubSection = '';
    $scope.requestDataCategory = {'categoryNameSp':'','categoryNameEn':''};
    $scope.formCrudRequestData = {'categoryNameSp':'','categoryNameEn':''};
    $scope.formCrudRequestErrors = {};

    $scope.onLoadFun = function(){
        $scope.refreshRecords();
        $scope.refreshUserCategory();
        $scope.refreshUserSelectedCategory();
    };

    $scope.onLoadFun();
    $scope.formCategoryError = '';
    $scope.createRecordFun = function(isValidForm){
        //$scope.formCrudRequestData = {'categoryNameSp':'','categoryNameEn':''};
        $scope.formCrudRequestErrors = {};
        //$scope.categorySubSectionChange('chooseCategory');
        //$scope.categorySubSectionChange('createOwnCategory');
        if(isValidForm){
            categoryService.create($scope.requestDataCategory, function(response){
                if(response.status){
                    $scope.requestDataCategory = {};
                    $scope.formCrudRequestErrors = {};
                    $scope.frmAddCategory.$setPristine();
                    //alert(response.message);
                    Notification.success(response.message);
                    $scope.onLoadFun();
                }else{
                    Notification.error(response.message);
                    $scope.formCrudRequestErrors.message =  response.message;
                }
            }, function(response){
                //alert('Some errors occurred while communicating with the service. Try again later.');
                console.error(" In CREATE ERROR");
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
    };
    $scope.deleteRecordFun = function(record){

        swal.fire({
            title: 'Are you sure you want to delete "'+record.name+'" category?',
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
                    categoryService.remove(record.id, function(response){
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


    $scope.showRecordFun = function(record){
        $scope.formCrudRequestData = {'categoryNameSp':record.spanish,'categoryNameEn':record.name,'id':record.id};
        $('#updateModel').modal('show');

    };

    $scope.updateRecordFun = function(isValidForm){
        //$scope.formCrudRequestData = {'categoryNameSp':'','categoryNameEn':''};
        $scope.formCrudRequestErrors = {};
        //$scope.categorySubSectionChange('chooseCategory');
        //$scope.categorySubSectionChange('createOwnCategory');
        console.log("IN UPDATE");
        console.log($scope.formCrudRequestData);
        if(isValidForm){
            categoryService.update(
                $scope.formCrudRequestData.id,
                {
                    categoryNameSp: $scope.formCrudRequestData.categoryNameSp,
                    categoryNameEn: $scope.formCrudRequestData.categoryNameEn
                },
                function(response){
                    if(response.status){
                        $('#updateModel').modal('hide');
                        $scope.formCrudRequestData = {};
                        $scope.formCrudRequestErrors = {};
                        //alert(response.message);
                        $scope.frmUpdateCategory.$setPristine();
                        Notification.success(response.message);
                        $scope.onLoadFun();
                    }else{
                        Notification.error(response.message);
                        $scope.formCrudRequestErrors.message =  response.message;
                    }

                }, function(response){
                    //alert('Some errors occurred while communicating with the service. Try again later.');
                    //alert('Some errors occurred while communicating with the service. Try again later.');
                    console.error(" In Update ERROR");
                    //console.error(response);
                    var responseData = response.data;
                    if(response.status != 200){
                        if(angular.isObject(responseData.message)){
                            //$scope.requestFormDataError = response.data.message;
                            $scope.formCrudRequestErrors =  responseData.message;
                        }else{
                            // bbNotification.error(response.data.message);
                            if(responseData.message.length==0){
                                $scope.formCrudRequestErrors.message = $window.msgError;
                            }else {
                                //$scope.loaderUserSelectedCategorys = $window.msgError;
                                Notification.error(responseData.message);
                                //$scope.formCrudRequestErrors.message = responseData.message ;
                                //TODO Error Msg with Refresh
                                //alert("in "+responseData.message);
                            }
                        }
                    }
                }
            );
        }
    };


    $scope.checkUnCheckCategoryFun = function(check,value){
        var isExistCategory = check.indexOf(value);
        if(isExistCategory != -1){
            $scope.userCategoryIdsArray.splice(isExistCategory, 1);
        }else{
            //$scope.userCategoryIdsArray = [];
            $scope.userCategoryIdsArray.push(value);
        }
        console.log("In value : "+value);
        console.log($scope.userCategoryIdsArray);
    };
    $scope.assignCategoryToUserFun = function(){
        console.log($scope.userCategoryIdsArray);
        //$scope.formCrudRequestData = {'categoryNameSp':'','categoryNameEn':''};
        //$scope.categorySubSectionChange('chooseCategory');
        //$scope.categorySubSectionChange('createOwnCategory');

        $scope.requestAssignData = {'selectedCategory':$scope.userCategoryIdsArray};
        categoryService.assignCategory($scope.requestAssignData, function(response){
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
    };



    //NOT USED
    $scope.updateFormFun = function(){
        var html = '<div class=""> <div class="column">';
        html += `<div class="form-group text-left">
                    <label for="exampleInputEmail1" class="text-bold">Category Name (SP)</label>
                    <input type="text" class="form-control" id="categoryNameSpUp"  placeholder="Enter Category Name (SP)" value="`+$scope.formCrudRequestData.categoryNameSp+`" onKeyup="checkSAValidation()">
                </div>
            <div class="form-group text-left">
            <label for="exampleInputEmail1" class="text-bold">Category Name (EN)</label>
            <input type="text" class="form-control" id="categoryNameEnUp" placeholder="Enter Category Name (EN)"  value="`+$scope.formCrudRequestData.categoryNameEn+`" onKeyup="checkSAValidation()">
            </div>
        `;
        //html += ``;

        html += '</div></div></div>';
        return html;
    };

    //NOT USED updateRecordFunV1
    $scope.updateRecordFunV1 = function(record){
        $scope.formCrudRequestData = {'categoryNameSp':record.spanish,'categoryNameEn':record.name,'id':record.id};

        swal.fire({
            title: 'Update Category',
            //type: 'warning',
            showCancelButton: true,
            //cancelButtonColor: '#d33',
            focusCancel: true,
            //confirmButtonColor: '#3085d6',
            confirmButtonText: 'Update',
            closeOnConfirm: false,

            //cancelButtonText: 'Dismiss',
            //<input type="text" id="login" class="swal2-input" placeholder="Username">
            html:   ' '+ $scope.updateFormFun(record),
            preConfirm: () => {
                $scope.formCrudRequestData.categoryNameSp = $('#categoryNameSpUp').val(),
                $scope.formCrudRequestData.categoryNameEn = $('#categoryNameEnUp').val();
                if ($scope.formCrudRequestData.categoryNameSp.length == 0 && $scope.formCrudRequestData.categoryNameEn.length == 0) {
                    Swal.showValidationMessage(`Both fields are required`)
                }
                else if ($scope.formCrudRequestData.categoryNameSp.length == 0) {
                    Swal.showValidationMessage(`Required Category Name (SP)`)
                }else
                if ($scope.formCrudRequestData.categoryNameEn.length == 0) {
                    Swal.showValidationMessage(`Required Category Name (EN)`)
                }

                return $scope.formCrudRequestData; //{ reasons: $scope.selectedOptionForSubscriptionPause,reasonSpecific: $scope.reasonSpecific}
            }
        }).
        then((result) => {
            //swal(JSON.stringify(result))
            if(result.dismiss == "cancel")
            {

            }else{
                categoryService.update(
                    $scope.formCrudRequestData.id,
                    {
                        categoryNameSp: $scope.formCrudRequestData.categoryNameSp,
                        categoryNameEn: $scope.formCrudRequestData.categoryNameEn
                    },
                    function(response){
                        if(response.status){
                            $scope.formCrudRequestData = {};
                            $scope.formCrudRequestErrors = {};
                            //alert(response.message);
                            Notification.success(response.message);
                            $scope.onLoadFun();
                        }else{
                            Notification.error(response.message);
                            $scope.formCrudRequestErrors.message =  response.message;
                        }

                    }, function(response){
                        //alert('Some errors occurred while communicating with the service. Try again later.');
                        //alert('Some errors occurred while communicating with the service. Try again later.');
                        console.error(" In Update ERROR");
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
                    }
                );



            }
        }).catch(swal.noop);
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
        },
        stop: function (e, ui) {
            var newUserCategoryOrder = $scope.userSelectedCategories.map(function(element){
                return element.id;
            });
            
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

}]);

function checkSAValidation(){
    var categoryNameSp = $('#categoryNameSpUp').val();
    var categoryNameEn = $('#categoryNameEnUp').val();
    if(categoryNameSp.length > 0 || categoryNameEn.length > 0){
        jQuery('.swal2-validation-message').hide();
    }
}
