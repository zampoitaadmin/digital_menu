// Default Load Cart and Preselected options and step
app.controller('signatureCollectionCtrl',['$scope','$http','$filter', '$window', '$location', '$anchorScroll','bbNotification', function($scope, $http, $filter, $window, $location, $anchorScroll,bbNotification) {
    $scope.apiURL = '';
    $scope.currentStep = 'step-size';//'GENERAL'; //ng-show="current_step=='product_info'" ng-cloak
    $scope.btnLoading = false;
    $scope.signatureCollectionList = [];
    $scope.signatureCollectionDetails = [];
    $scope.requestFormDataError = [];

    $scope.barBtnDisabled = false;
    $scope.products = [];

    $scope.isProductLoader = false;
    $scope.isProductCartLoader = false;
    $scope.loaderProduct = '';
    $scope.loaderProductCart = '';
    $scope.clickBusy = '';
    $scope.menuBtnText = 'Skip';
    $scope.retry = 0;
    $scope.screensize= jQuery(window).width();

    $scope.init = function(initData)
    {
        $scope.page = initData;
        $scope.setRequestData();
        if($scope.page=='SC'){
            $scope.getProductSignatureCollectionFun();
        }else{
            $scope.getProductSignatureCollectionDetailsFun();
        }

    };

    //Clear Cart
    $scope.setRequestData = function(){
        $scope.signatureCollectionList = [];
        $scope.requestFormData = {
            //cartPreview : {}, //'lin1':'','line2':'','line3':''
            yourHouseNumber: '',
            signatureCollection: '',
        };
        $scope.cartData = [];
        $scope.deliveryDays= [];
        $scope.type = 0;
        $scope.step = 0;
    };
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
    };
    $scope.hideLoaderFun = function(type){
        if (type=='P'){
            $scope.isProductLoader = false;
            $scope.loaderProduct = '';
        }else if (type=='S'){
            $scope.isSidesLoader = false;
            $scope.loaderSides = '';
        } else if (type=='SC'){
            $scope.isSidesCartLoader = false;
            $scope.loaderSidesCart= '';
        }
        else if (type=='C'){
            $scope.isProductCartLoader = false;
            $scope.loaderProductCart = $window.loader;
        }
    };

    //Get Products signature collection
    $scope.getProductSignatureCollectionFun =  function(){
        $scope.showLoaderFun('P');
        $scope.signatureCollectionList = [];
        $http({
            method  : 'GET',
            url     : $window.urlGetProductSignatureCollectionList,
            data    : {}
        })
        .then(function(response) {
                var responseData = response.data;
                if(responseData.status){
                    $scope.signatureCollectionList = responseData.data.signatureCollection;

                }else{
                    bbNotification.error($window.msgError);
                }
            },function(response){
                if(response.status ==500){
                    $scope.getProductFun();
                }else
                if(response.status !=200){
                    bbNotification.error($window.msgError);
                }
            }).finally(function() {
            $scope.hideLoaderFun('P');

        });
    };

    $scope.getProductSignatureCollectionDetailsFun =  function(){
        $scope.showLoaderFun('P');
        $scope.signatureCollectionDetails = [];
        $http({
            method  : 'GET',
            url     : $window.urlGetProductSignatureCollectionDetails,
            data    : {}
        })
            .then(function(response) {
                var responseData = response.data;
                if(responseData.status){
                    $scope.signatureCollectionDetails = responseData.data.signatureCollectionDetails;

                }else{
                    bbNotification.error($window.msgError);
                }
            },function(response){
                if(response.status ==500){
                    $scope.getProductFun();
                }else
                if(response.status !=200){
                    bbNotification.error($window.msgError);
                }
            }).finally(function() {
                $scope.hideLoaderFun('P');

            });
    };
    $scope.getkeys = function (event) {

        $scope.keyval = event.keyCode;
        if(1) {
            event = event || window.event;
            var keyCode = event.keyCode;
            //if ($scope.requestFormData.yourHouseNumber) {

                //jQuery("#t_line_custom").attr('maxlength', $scope.requestFormData.yourHouseNumber);
                //if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || (keyCode == 38 || keyCode == 40)) {} else {
                if (((keyCode > 97 && keyCode > 126) || (keyCode >= 48 && keyCode <= 57) || (keyCode.shiftKey))) {
                    $scope.requestFormDataError.yourHouseNumber = '';
                    if(window.which === 86 && event.ctrlKey){
                        //alert("COPY paset not allowe");
                    }
                } else {
                    event.preventDefault();
                }
           // }
        }

    };
    $scope.addToCartSignatureCollectionFun =  function(){
        $scope.btnDisabled = true;
        $scope.requestFormDataError = [];
        if($scope.requestFormData.yourHouseNumber.length>0){
            $scope.requestFormData.signatureCollection = $window.varSlug;
            $http({
                method  : 'POST',
                url     : $window.urlCartAddSignatureCollection,
                data    : $scope.requestFormData
            }).then(function(response) { //handle Success scenario
                var responseData = response.data;
                if(responseData.status){
                    //TODO
                     window.location.href = $window.urlReview;
                    //bbNotification.successRedirect(responseData.message,$window.urlReview);
                }else{
                    //bbNotification.error(responseData.message);
                }
            },function(response){ //Only Handle Error Scenario
                $scope.btnDisabled = false;
                var responseData = response.data;
                /*if(response.status ==500){
                 $scope.applyCouponCodeFun();
                 }else*/
                if(response.status !=200){
                    $scope.requestFormDataError = responseData.message;
                    if($scope.requestFormDataError.signatureCollection){
                        //bbNotification.error($scope.requestFormDataError.signatureCollection);
                    }
                    //bbNotification.error(responseData.message);
                }
            }).finally(function() {

            });
        }else{
            $scope.btnDisabled = false;
            $scope.requestFormDataError.yourHouseNumber = 'Please enter your house number';
            //bbNotification.error('Please enter your house number');
        }

    };
}]);
