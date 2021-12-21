// create angular controller

app.controller('gitVoucherController', ['$scope','$http','$filter', '$window', '$location', '$anchorScroll','$timeout','bbNotification','bbLoader','$log', function($scope, $http, $filter, $window, $location, $anchorScroll,$timeout,bbNotification,bbLoader,$log){
    $scope.stripeTextMsg = '';
    $scope.btnSubmtText = 'Place Order';
    $scope.btnDisabled = false;
    $scope.isLoader = false;
    $scope.isLoaderCart = false;
    $scope.loaderView = '';
    $scope.requestFormDataError = [];
    $scope.requestFormData= {recipientFirstName:'', recipientLastName:'', recipientEmail:'', voucherFrom:'', personalMessage:'', whenToEmailVoucher:'today', day:'', month:'', year:'', voucherValue:''};
    $scope.subscriptionId = '';
    $scope.uType = true;
    $scope.init = function(initData)
    {
        $scope.uType = initData;
        //bbLoader.show('P');
        /*console.debug("Calling console.debug");
        console.info("Calling console.info");
        console.log("Calling console.log");
        console.warn("Calling console.warn");
        console.error("Calling console.error");

        $log.debug("Some debug");
        $log.info("Some info");
        $log.log("Some log");
        $log.warn("Some warning");
        $log.error($scope.requestFormData);*/


    };
    $scope.formError = '';

    $scope.changeSendVoucherFun = function(){
      console.log($scope.requestFormData.whenToEmailVoucher);
      if($scope.requestFormData.whenToEmailVoucher==='on_specific_date'){

      }
      /*
      alert(moment("05/22/2012", 'MM/DD/YYYY',true).isValid()); //true

alert(moment("15/12/2012", 'MM/DD/YYYY',true).isValid()); //false

alert(moment("11/22/1987", 'MM/DD/YYYY',true).isValid()); //true
      * */
    };
    $scope.submitVoucherFun =  function(){
        console.log($scope.requestFormData);//return false;
        $scope.formError = '';
        $scope.requestFormDataError = [];
        $http({
            method  : 'POST',
            url     : $window.urlCartAddVoucher,
            data    : $scope.requestFormData
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            if(responseData.status){
                bbNotification.successRedirect(responseData.message,$window.urlReview);
            }else{
                bbNotification.error(responseData.message);
            }
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status ==400){
                if(angular.isObject(response.data.message)){
                    $scope.requestFormDataError = response.data.message;
                    //throw {message: response.data};
                    //$log.error(response.status,response.data);
                }else{
                    //$scope.formError = response.data.message;
                    bbNotification.error(response.data.message);
                }
            }else
            if(response.status !=200){
                bbNotification.error(responseData.message);
            }
        }).finally(function() {
        });
    };

}]);
