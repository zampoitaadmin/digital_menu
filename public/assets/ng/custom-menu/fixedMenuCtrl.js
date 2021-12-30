// Dropzone.autoDiscover = false;
// var starterDropzone;
bbAppControllers.controller('fixedMenuCtrl', ['$scope', '$location','userService', 'categoryService', 'fixedMenuService','$window','Notification','$sce','$timeout',  function ($scope, $location, userService, categoryService, productService,$window,Notification,$sce,$timeout) {
	
	$scope.starters = [];
	$scope.starters.push({
		'productName': '',
		'allergyId': '',
		'starterProductMainImage': '',
		'productMainDescription': '',
	});

	$scope.requestDataFixedMenu = {'categoryName':'','changeCategoryName':'','menuDescriptionConditions':'','fixedMenuPrice':'','id':0};

	$scope.addNewStarter = function(){
		$scope.starters.push({
			'productName': '',
			'allergyId': '',
			'starterProductMainImage': '',
			'productMainDescription': '',
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

    $scope.onLoadFun = function(){
        $scope.refreshAllAllergies();
        // initStarterDropzone();
        $scope.initStarterDropify();
    };

    $scope.onLoadFun();

    $scope.fixedMenuRecordFun = function(isValidForm){

        var responses = [];
        angular.forEach($scope.starters, function (value, key) {
            this.push({
                'allergyId': value.allergyId,
                'productMainDescription': value.productMainDescription,
                'productName': value.productName,
                'starterProductMainImage': value.starterProductMainImage
            });
        }, responses);

        let requestData = [];
        requestData.push({
            'requestDataFixedMenu': $scope.requestDataFixedMenu,
            'responses': responses
        });
        console.log(requestData);

        // debugger;
        
        let formData = new FormData();
        // debugger;
        angular.forEach($scope.files, function (file) {
            formData.append('file', file);
        });

        // debugger;

        $scope.formCrudRequestErrors = {};
        if(isValidForm){
        }
    };
}]);