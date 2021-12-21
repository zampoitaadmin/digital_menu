// create angular controller

app.controller('checkoutController', ['$scope','$http','$filter', '$window', '$location', '$anchorScroll','$timeout','bbNotification','bbLoader', function($scope, $http, $filter, $window, $location, $anchorScroll,$timeout,bbNotification,bbLoader){
    $scope.orderNotesMaxChar = 50;
    //$scope.checkoutRequestData = [];
    $scope.paymentMethodType = $window.pType ;//'Paypal';
    $scope.stripeTextMsg = '';
    $scope.btnSubmitText = 'Checkout';
    $scope.btnDisabled = false;
    $scope.isLoader = false;
    $scope.isLoaderCart = false;
    $scope.loaderView = '';
    $scope.checkoutRequestDataError = {};
    $scope.checkoutRequestData = {shippingName:'', shippingEmail:'', shippingPhone:'', shippingAddress:'', shippingPostCode:'',isUrgentOrder:0 , shippingAddressLine1:'', shippingAddressLine2 : '', shippingCity: ''};
    $scope.promoCodeData = {};
    $scope.cartData={};
    $scope.subscriptionId = '';
    $scope.uType = true;
    $scope.init = function(initData)
    {
        $scope.uType = initData;
        //bbLoader.show('P');
        $scope.paymentRequest='';
        $scope.elementsAP ='';
        $scope.paymentRequestElement='';

        $scope.stripe = Stripe($window.stripePublishableKey,{
            apiVersion: "2020-08-27",
        });
        $scope.stripeAP = Stripe($window.stripePublishableKey,{
            apiVersion: "2020-08-27",
        });
        $scope.getCartFun();
        $scope.setStripeFun();
       // $scope.sapPaymentRequest();
    };
    $scope.showLoaderFun = function(type){
        if (type=='P'){
            $scope.isProductLoader = true;
            $scope.loaderProduct = $window.loader;
        }
        else if (type=='C'){
            $scope.isLoaderCart = true;
            $scope.loaderView = $window.loader;
        }
    };
    $scope.hideLoaderFun = function(type){
        if (type=='P'){
            $scope.isProductLoader = false;
            $scope.loaderProduct = '';
            //jQuery(".loaderProduct").html('');
        }
        else if (type=='C'){
            $scope.isLoaderCart = false;
            $scope.loaderView = '';
            //jQuery(".loaderProductCart").html('');
        }
    };
    //Fetch Cart Data
    $scope.getCartFun = function(isLoader=true){
        $scope.cartData = {};
        //console.log("=getCartFun");
        if(isLoader){
            $scope.showLoaderFun('C');
        }

        $http({
            method  : 'GET',
            url     : $window.urlCart,
            params    : {}
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            if(responseData.status){
                $scope.cartData = responseData.data.cart;

                if($scope.cartData){
                    $scope.checkoutRequestData.isUrgentOrder = parseInt($scope.cartData.is_urgent_order);
                    $scope.promoCodeData.discountCode = $scope.cartData.discount_code;
                    /*if($scope.cartData.discountCode){
                     $scope.isVisibleCoupon = true;
                     }
                     jQuery('#basket_count').html($scope.cartData.totalCartItems);*/
                    $scope.checkoutRequestData.shippingName = $scope.cartData.customer_name;
                    $scope.checkoutRequestData.shippingEmail = $scope.cartData.customer_email;
                    $scope.checkoutRequestData.shippingPhone = $scope.cartData.customer_phone;
                    $scope.checkoutRequestData.shippingAddress = $scope.cartData.shipping_address;
                    $scope.checkoutRequestData.shippingPostCode = $scope.cartData.customer_postcode;
                    $scope.checkoutRequestData.shippingAddressLine1 = $scope.cartData.address_line1;
                    $scope.checkoutRequestData.shippingAddressLine2 = $scope.cartData.address_line2;
                    $scope.checkoutRequestData.shippingCity = $scope.cartData.city;

                    if($scope.cartData.total_payable==0){
                        $scope.paymentMethodType = 'DISCOUNT';
                    }else{
                        if( ($scope.paymentMethodType === undefined || $scope.paymentMethodType === null || $scope.paymentMethodType.length <= 0) ){
                            $scope.paymentMethodType = 'Paypal';
                        }else{
                            if($scope.paymentMethodType =='DISCOUNT'){
                                $scope.paymentMethodType = 'Paypal';
                            }
                        }
                    }
                }else{
                    $scope.checkoutRequestData.shippingName = '';
                    $scope.checkoutRequestData.shippingEmail = '';
                    $scope.checkoutRequestData.shippingPhone = '';
                    $scope.checkoutRequestData.shippingAddress = '';
                    $scope.checkoutRequestData.shippingPostCode = '';
                    $scope.checkoutRequestData.shippingAddressLine1 = '';
                    $scope.checkoutRequestData.shippingAddressLine2 = '';
                    $scope.checkoutRequestData.shippingCity = '';
                    $scope.checkoutRequestData.isUrgentOrder = 0;
                    $scope.promoCodeData.discountCode = '';
                    //jQuery('#basket_count').html(0);
                }
                //  //console.log($scope.cartData );
            }else{
                bbNotification.error(responseData.message);
            }
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status === 500){
                // $scope.getCartFun();
                //window.location.reload();
            }
            else if(response.status !==200){
                bbNotification.error(responseData.message);
            }
        }).finally(function() {
            $scope.sapPaymentRequest();
            if(isLoader) {
                $scope.hideLoaderFun('C');
            }
        });
    };
    // $scope.getCartFun();
    $scope.setCartFun = function(){
         $timeout(function () {
         if($scope.cartData){
            $scope.checkoutRequestData.isUrgentOrder = parseInt($scope.cartData.is_urgent_order);
            $scope.promoCodeData.discountCode = $scope.cartData.discount_code;
            /*if($scope.cartData.discountCode){
             $scope.isVisibleCoupon = true;
             }
             jQuery('#basket_count').html($scope.cartData.totalCartItems);*/
            $scope.checkoutRequestData.shippingName = $scope.cartData.customer_name;
            $scope.checkoutRequestData.shippingEmail = $scope.cartData.customer_email;
            $scope.checkoutRequestData.shippingPhone = $scope.cartData.customer_phone;
            $scope.checkoutRequestData.shippingAddress = $scope.cartData.shipping_address;
            $scope.checkoutRequestData.shippingPostCode = $scope.cartData.customer_postcode;
            $scope.checkoutRequestData.shippingAddressLine1 = $scope.cartData.address_line1;
            $scope.checkoutRequestData.shippingAddressLine2 = $scope.cartData.address_line2;
            $scope.checkoutRequestData.shippingCity = $scope.cartData.city;

            if($scope.cartData.total_payable==0){
                $scope.paymentMethodType = 'DISCOUNT';
            }else{
                if( ($scope.paymentMethodType === undefined || $scope.paymentMethodType === null || $scope.paymentMethodType.length <= 0) ){
                    $scope.paymentMethodType = 'Paypal';
                }else{
                    if($scope.paymentMethodType =='DISCOUNT'){
                        $scope.paymentMethodType = 'Paypal';
                    }
                }
            }
        }else{
            $scope.checkoutRequestData.shippingName = '';
            $scope.checkoutRequestData.shippingEmail = '';
            $scope.checkoutRequestData.shippingPhone = '';
            $scope.checkoutRequestData.shippingAddress = '';
            $scope.checkoutRequestData.shippingPostCode = '';
            $scope.checkoutRequestData.isUrgentOrder = 0;
            $scope.checkoutRequestData.shippingAddressLine1 = '';
            $scope.checkoutRequestData.shippingAddressLine2 = '';
            $scope.checkoutRequestData.shippingCity = '';
            $scope.promoCodeData.discountCode = '';
            //jQuery('#basket_count').html(0);
        }
         }, 200);
    };

    $scope.cartAddUpdateItemFun = function(product,operation,index){
        $scope.clickBusy = 'busyElement';
        var qty = parseInt(product.quantity);
        //console.log(product.quantity);
        if(operation==='A'){   //Add
            product.quantity = qty  + 1;
        }else if(operation==='M'){  //Minus
            qty  = qty  - 1;
            if(qty >= 0 ){
                //Update Cart
                product.quantity = qty  ;
            }else{
                product.quantity = 0;
                $scope.clickBusy = '';
                bbNotification.error($window.msgErrorProductQtyZero);
                return true;
            }
        }else{
            $scope.clickBusy = '';
            bbNotification.error($window.msgError);
            return true;
        }
        $scope.cartAddUpdateItemOperationFun(product,index); //Product
    };
    $scope.cartAddUpdateItemManualFun = function (product, event, index, qty) {
        $scope.clickBusy = 'busyElement';
        event = event || window.event;
        var keyCode = event.keyCode;
        //console.log("keyCode  " + keyCode);
        //console.log("WTY  " + product.quantity);
        //console.log("qty" + qty);

        if (((keyCode >= 96 && keyCode <= 105) || (keyCode >= 48 && keyCode <= 57) || (keyCode === 109 || keyCode === 107 || keyCode === 8))) {
        } else {
            $scope.clickBusy = '';
            return false;
        }
        var qty = event.target.value;
        if(isNaN(qty)){
            qty = 1;
        }
       // console.log("qty " + qty);
        product.quantity = qty;
        //$scope.clickBusy = '';
        if (qty != '') {
            $scope.cartAddUpdateItemOperationFun(product, index); //Product
        }
    };
    //Cart Operation Add, Minus and Manual enter
    $scope.cartAddUpdateItemOperationFun = function(product,index){
        //console.log(product);
        //return true;
        $http({
            method  : 'POST',
            url     : $window.urlUpdateItemQty,
            data    : {id : product.id , quantity: product.quantity}
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            $scope.cartData = responseData.data.cart;
            if(responseData.status){
                //$scope.products[index].quantity = responseData.data.quantity;
                // $scope.getCartFun();
            }else{
                //$scope.products[index].quantity = responseData.data.quantity;
                bbNotification.error(responseData.message);
                // $scope.getCartFun();
            }
            //$scope.getCartFun(false);
            $scope.setCartFun();
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status !==200){
                $scope.getCartFun();
                //bbNotification.error($window.msgError);
                bbNotification.error(responseData.message);
            }
        }).finally(function() {
            $scope.clickBusy = '';
        });
    };

    $scope.changePaymentMethodTypeFun = function(paymentMethodType){
        $scope.paymentMethodType = paymentMethodType;
        jQuery('#paymentResponse').removeClass('element-show').addClass('element-hide');
        $scope.stripeErrorMsg = '';
       // console.log($scope.paymentMethodType);
    };
    //Save Shipping Details
    $scope.saveShippingDetailsFun= function(){
        //console.log($scope.checkoutRequestData);
        //return true;
        //$scope.btnDisabled = true;
        $scope.clickBusy = 'busyElement';
        $http({
            method  : 'POST',
            url     : $window.urlSaveShippingDetails,
            data    : $scope.checkoutRequestData
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            $scope.cartData = responseData.data.cart;
            $scope.setCartFun();
            if(responseData.status){
                //bbNotification.success(responseData.message);
            }else{
                $scope.getCartFun(false);
                bbNotification.error(responseData.message);
            }
            //$scope.getCartFun(false);
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status !=200){
                if(angular.isObject(response.data.message)){
                    $scope.checkoutRequestDataError = response.data.message;
                }else{
                    bbNotification.error(response.data.message);
                }
                $scope.getCartFun();
            }
        }).finally(function() {
            $timeout(function () {
                $scope.clickBusy = '';
            }, 200);
            //$scope.submitBtnEnable();
        });
    };
    //Apply Discount Code
    $scope.applyDiscountCodeFun = function(){
        $http({
            method  : 'POST',
            url     : $window.urlApplyDiscountCode,
            data    : {discountCode: $scope.promoCodeData.discountCode}
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            $scope.cartData = responseData.data.cart;
            if(responseData.status){
                bbNotification.success(responseData.message);
            }else{
                bbNotification.error(responseData.message);
            }
           // $scope.getCartFun(false);
           $scope.setCartFun();
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status !=200){
                if(angular.isObject(response.data.message)){
                    $scope.checkoutRequestDataError = response.data.message;
                }else{
                    bbNotification.error(response.data.message);
                }
                $scope.getCartFun();
            }
        }).finally(function() {
        });
    };

    //reset Discount Code
    $scope.resetDiscountCodeFun = function(){
        $http({
            method  : 'POST',
            url     : $window.urlResetDiscountCode,
            data    : {discountCode: ''}
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            $scope.cartData = responseData.data.cart;
            if(responseData.status){
                $scope.promoCodeData.discountCode = $scope.cartData.discount_code;
               // bbNotification.success(responseData.message);
            }else{
                bbNotification.error(responseData.message);
            }
            //$scope.getCartFun(false);
            $scope.setCartFun();
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status !=200){
                if(angular.isObject(response.data.message)){
                    $scope.checkoutRequestDataError = response.data.message;
                }else{
                    bbNotification.error(response.data.message);
                }
                $scope.getCartFun();
            }
        }).finally(function() {
        });
    };

    //Select Advance Order
    $scope.selectAdvanceOrderFun = function() {
        //console.log('This is the state of my model ' + $scope.checkoutRequestData.isUrgentOrder);
        $http({
            method  : 'POST',
            url     : $window.urlUrgentOrderShipping,
            data    : {isUrgentOrder: $scope.checkoutRequestData.isUrgentOrder}
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            $scope.cartData = responseData.data.cart;
            if(responseData.status){
                //bbNotification.success(responseData.message);
            }else{
                bbNotification.error(responseData.message);
            }
            //$scope.getCartFun(false);
            $scope.setCartFun();
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            if(response.status !=200){
                if(angular.isObject(response.data.message)){
                    $scope.checkoutRequestDataError = response.data.message;
                }else{
                    bbNotification.error(response.data.message);
                }
                $scope.getCartFun();
            }
        }).finally(function() {

        });

    };

    //Stripe
    $scope.stripeErrorMsg = '';
    $scope.registerElements = function(elements, exampleName) {
        var formClass = '.' + exampleName;
        var example = document.querySelector(formClass);
        var form = example.querySelector('#frm_stripe_form');
        var resetButton = example.querySelector('a.reset');
        var error = form.querySelector('.error');
        //  console.log(error);
        var errorMessage = '';
        errorMessage = error.querySelector('.message');
        if(error){
            errorMessage = error.querySelector('.message');
        }else{
        }
        $scope.stripeErrorMsg= '';
        var savedErrors = {};
        elements.forEach(function (element, idx) {
            element.on('change', function (event) {
               // console.log("on change ");
               // console.log(event.error);

                if (event.error) {
                    //error.classList.add('visible');
                    //savedErrors[idx] = event.error.message;
                    //errorMessage.innerText = event.error.message;
                    //$scope.stripeErrorMsg= event.error.message;
                    $scope.stripeErrorFun(event.error);
                }else{
                    $timeout(function () {
                        $scope.stripeErrorMsg = '';
                    }, 200);
                }
                /*else {
                 error.classList.remove('visible');
                 $scope.stripeErrorMsg= '';
                 savedErrors[idx] = null;
                 // Loop over the saved errors and find the first one, if any.
                 var nextError = Object.keys(savedErrors)
                 .sort()
                 .reduce(function (maybeFoundError, key) {
                 return maybeFoundError || savedErrors[key];
                 }, null);
                 if (nextError) {
                 // Now that they've fixed the current error, show another one.
                 //errorMessage.innerText = nextError;
                 $scope.stripeErrorMsg= nextError;
                 } else {
                 // The user fixed the last error; no more errors.
                 error.classList.remove('visible');
                 $scope.stripeErrorMsg= '';
                 }
                 }*/
            });
        });
        // Listen for errors from each Element, and show error messages in the UI.
    };
    //Stripe
    $scope.setStripeFun = function(){
        /*$scope.stripe = Stripe($window.stripePublishableKey,{
            apiVersion: "2020-08-27",
        });*/
        $scope.elements = $scope.stripe.elements(
            {
                fonts: [
                    {
                        // cssSrc: 'https://fonts.googleapis.com/css?family=Montserrat:400,500',
                        cssSrc: 'https://use.typekit.net/xkr3sbv.css',
                    }],
                locale: window.__exampleLocale
            });
        $scope.style = {
            base: {
                iconColor: "#fff",
                color: "#fff",
                fontWeight: 400,
                fontFamily: "Helvetica Neue, Helvetica, Arial, sans-serif",
                fontSize: "16px",
                fontSmoothing: "antialiased",
                "::placeholder":
                {
                    color: "#ffffff"
                },
                ":-webkit-autofill":
                {
                    color: "#fce883"
                }
            },
            /*invalid: {
             iconColor: "#FFC7EE",
             color: "#FFC7EE"
             }*/
        };

        $scope.cardElement = $scope.elements.create('card', {
            hidePostalCode: true,
            style: $scope.style
        });

        $scope.cardElement.mount('#example5-card');

        $scope.resultContainer = document.getElementById('paymentResponse');
        $scope.error = document.getElementById('stripeError');
        // Validate input of the card elements
        $scope.cardElement.addEventListener('change', function (event) {
            //console.log('STRIPE error ');
            if (event.error) {
                jQuery('.message').removeClass('element-hide').addClass('element-show');
                jQuery('#paymentResponse').removeClass('element-hide').addClass('element-show');
                // $scope.stripeErrorMsg = event.error.message ;
                $scope.stripeErrorFun(event.error);
            } else {
                jQuery('.message').removeClass('element-show').addClass('element-hide');
                jQuery('#paymentResponse').removeClass('element-show').addClass('element-hide');
                $scope.stripeErrorMsg = '';
            }
            console.log($scope.stripeErrorMsg);
            $scope.registerElements([$scope.cardElement], "example5");
        });
        /*$scope.resultContainer = document.getElementById('paymentResponse');

         $scope.exp.addEventListener('change', function (event) {
         if (event.error) {
         jQuery('#paymentResponse').removeClass('element-hide').addClass('element-show');
         $scope.resultContainer.innerHTML = event.error.message ;
         } else {
         jQuery('#paymentResponse').removeClass('element-show').addClass('element-hide');
         $scope.resultContainer.innerHTML = '';
         }
         //console.log($scope.resultContainer);
         });
         $scope.cvc.addEventListener('change', function (event) {
         if (event.error) {
         jQuery('#paymentResponse').removeClass('element-hide').addClass('element-show');
         $scope.resultContainer.innerHTML = event.error.message ;
         } else {
         jQuery('#paymentResponse').removeClass('element-show').addClass('element-hide');
         $scope.resultContainer.innerHTML = '';
         }
         //console.log($scope.resultContainer);
         });*/

    };

    window.addEventListener('resize', function (event)
    {
        //updateStripeInputFields($scope);
    });

    window.addEventListener('load', function (event)
    {
        //updateStripeInputFields($scope);
    });

    $scope.doCheckout = function(){
        if($window.wsMode!= $window.checkMode){
            if($scope.cartData){
                gtag('event', 'conversion', {'send_to': 'AW-975230974/hhaECK7vg-wBEP6vg9ED', 'value': $scope.cartData.total_payable,'currency': 'GBP','transaction_id': ''});
            }
        }
        $scope.checkoutRequestData.paymentMethodType = $scope.paymentMethodType;
        if($scope.paymentMethodType === 'Stripe'){
            //console.log($scope.checkoutRequestData); return true;
            $scope.btnDisabled = true;
            $scope.btnSubmitText = 'Processing...';
            $scope.cardBillingDetails = {};
            if($scope.checkoutRequestData.shippingName ){
                $scope.cardBillingDetails.name= $scope.checkoutRequestData.shippingName;
            }
            if($scope.checkoutRequestData.shippingEmail){
                $scope.cardBillingDetails.email = $scope.checkoutRequestData.shippingEmail;
            }
            if($scope.checkoutRequestData.shippingPhone){
                $scope.cardBillingDetails.phone = $scope.checkoutRequestData.shippingPhone;
            }
            $scope.errorElement = document.getElementById('paymentResponse');
            //$scope.errorElement.textContent = '';
            $scope.stripe.createPaymentMethod({
                type: 'card',
                card: $scope.cardElement,
                billing_details: $scope.cardBillingDetails

            }).then(function(result) {
                // Handle result.error or result.paymentMethod
                //console.log(result);
               // console.log("========== Start  =========");
                //console.log(result);
                //console.log("========== ENd =========");
                if (result.error) {
                    jQuery('#paymentResponse').removeClass('element-hide').addClass('element-show');
                    // Inform the user if there was an error
                    //$scope.errorElement.textContent = result.error.message;
                    //$scope.stripeErrorMsg = result.error.message ;
                    $scope.stripeErrorFun(result.error);
                    $scope.submitBtnEnable();
                }
                else {
                    jQuery('#paymentResponse').removeClass('element-show').addClass('element-hide');
                    //   $scope.btnDisabled = true;
                    // $scope.errorElement.textContent = '';
                    $scope.stripeTextMsg = $window.msgStripeTransactionProcessing;
                    $scope.checkoutRequestData.stripeToken = result.paymentMethod.id;
                    $scope.placeOrder();
                }
            },function(result){
                //if(result.status !=200){
                //bbNotification.error(responseData.message);
                //}

            }).finally(function() {
                /* $timeout(function () {
                 $scope.btnDisabled = false;
                 }, 200);
                 $scope.btnDisabled = false;*/
            });

        }
        else if($scope.paymentMethodType === 'Paypal'){
            $scope.btnDisabled = true;
            $scope.btnSubmitText = 'Processing...';
            $scope.placeOrder();
        }
        else{ //Discount ORDER
            $scope.btnDisabled = true;
            $scope.btnSubmitText = 'Processing...';
            $scope.placeOrder();
        }
    };

    $scope.submitBtnEnable = function(){
        $timeout(function () {
            $scope.btnDisabled = false;
            $scope.btnSubmitText = 'Checkout';
            $scope.stripeTextMsg = '';
        }, 200);
    };
    $scope.stripeErrorFun = function($error){
        jQuery('#paymentResponse').removeClass('element-hide').addClass('element-show');
        switch ($error.type) {
            case 'api_connection_error':
                // Failure to connect to Stripe's API.
                //$scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
            case 'api_error':
                // API errors cover any other type of problem (e.g., a temporary problem with Stripe's servers), and are extremely uncommon.
                // $scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
            case 'authentication_error':
                // Failure to properly authenticate yourself in the request.
                // $scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
            case 'card_error':
                // Card errors are the most common type of error you should expect to handle. They result when the user enters a card that can't be charged for some reason.
                //$scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
            case 'idempotency_error':
                // Idempotency errors occur when an Idempotency-Key is re-used on a request that does not match the first request's API endpoint and parameters.
                // $scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
            case 'invalid_request_error':
                // Invalid request errors arise when your request has invalid parameters.
                //$scope.errorElement.textContent = $error.message;
                $scope.error = 'Invalid API Key provided' ;
                break;
            case 'rate_limit_error':
                // Too many requests hit the API too quickly.
                //$scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
            case 'validation_error':
                // Errors triggered by our client-side libraries when failing to validate fields (e.g., when a card number or expiration date is invalid or incomplete).
                // $scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;

                break;
            default:
                // Handle any other types of unexpected errors
                //$scope.errorElement.textContent = $error.message;
                $scope.error = $error.message ;
                break;
        }
        $timeout(function () {
            $scope.stripeErrorMsg = $scope.error;
        }, 200);
    };

    //Place Order with Payment
    $scope.placeOrder = function() {
        $scope.checkoutRequestDataError = [];
        $http({
            method  : 'POST',
            url     : $window.urlDoCheckout,
            data    : $scope.checkoutRequestData
        })
            .then(function(response) {
                var responseData = response.data;
                $scope.handleServerResponse(responseData);
            },function(response){
                $scope.submitBtnEnable();
                if(response.status == 401){
                    bbNotification.errorRedirect(response.data.message,'');
                }else if(response.status == 402){
                    bbNotification.error(response.data.message);
                }
                else if(response.status ==400){
                    if(angular.isObject(response.data.message)){
                        $scope.checkoutRequestDataError = response.data.message;
                    }else{
                        bbNotification.error(response.data.message);
                    }
                }
                else if(response.status !=200){
                    if(angular.isObject(response.data.message)){
                        $scope.checkoutRequestDataError = response.data.message;
                    }else{
                        bbNotification.error(response.data.message);
                    }
                }
            }).finally(function() {
            });
    };

    //Handle Payment response Stripe
    $scope.handleServerResponse = function(response){
        //console.log(response);
        if (response.error) {
            bbNotification.error(response.message);
            //jQuery('.checkoutSbmtBtn').removeClass('busyElement');
            $scope.submitBtnEnable();
        } else if (response.requires_action) {
            //document.getElementById("payment-errors").textContent = "Requires action";
            // Use Stripe.js to handle required card action
            $scope.handleAction(response);
        } else {
            $scope.submitBtnEnable();
            if(response.status ==false){
                bbNotification.error(response.message);
            }else{
                if(response.redirect_url!=''){
                    window.location.href = response.redirect_url;
                }else{
                    bbNotification.errorRedirect($window.msgError,'');
                }
            }
        }
    };
    //Handle 3d Payment Stripe
    $scope.handleAction = function(response){
        $scope.stripe.handleCardAction(
            response.payment_intent_client_secret
        ).then(function(result) {
                //console.log(" HandleAction ");
                if (result.error) {
                    bbNotification.error(result.error.message);
                    $scope.submitBtnEnable();
                    //document.getElementById("payment-errors").textContent = result.error.message;
                } else {
                    // The card action has been handled
                    // The PaymentIntent can be confirmed again on the server
                    $scope.checkoutRequestData.payment_intent_id = result.paymentIntent.id;
                    $http({
                        method  : 'POST',
                        url     : $window.urlConfirmPayment,
                        data    : $scope.checkoutRequestData
                        //data    : {payment_intent_id: result.paymentIntent.id}
                    })
                        .then(function(response) {
                            var responseData = response.data;
                            $scope.handleServerResponse(responseData);

                        },function(response){
                            $scope.submitBtnEnable();
                            if(response.status == 401){
                                //Redirect On Order Page
                                bbNotification.errorRedirect($window.msgError,'');
                                //window.location.reload();
                            }
                            else if(response.status ==400){
                                if(angular.isObject(response.data.message)){
                                    $scope.checkoutRequestDataError = response.data.message;
                                }else{
                                    bbNotification.error(response.data.message);
                                }
                            }
                            else if(response.status !=200){
                                if(angular.isObject(response.data.message)){
                                    $scope.checkoutRequestDataError = response.data.message;
                                }else{
                                    bbNotification.error(response.data.message);
                                }
                            }
                        }).finally(function() {
                        });

                }
            });
    };


    /*Stripe Apple Pay*/

    $scope.sapPaymentRequest = function(){
        if($scope.cartData){
            if($scope.cartData.total_payable<=0){
                return true;
            }
        }else{
                return true;
        }
        var totalAmount = parseFloat($scope.cartData.total_payable).toFixed(2);
        $scope.paymentRequest = $scope.stripeAP.paymentRequest({
            country: 'GB',
            currency: 'gbp',

            total:
            {
                amount: parseInt(totalAmount * 100),
                label: "Total"
            },
            //displayItems: displayItemsArr,
            requestShipping: false,
            requestPayerName: true,
            requestPayerEmail: true,
        });

        $scope.elementsAP = $scope.stripeAP.elements();

        $scope.paymentRequestElement = $scope.elementsAP.create("paymentRequestButton",
            {
                paymentRequest: $scope.paymentRequest,
                style:
                {
                    paymentRequestButton:
                    {
                        theme: "light"
                    }
                }
            });
        $scope.paymentRequest.canMakePayment().then(function (result)
        {
            //console.log("====== START AP ");
            // console.log(result);
           // console.log("====== END AP ");

            if (result)
            {
                if (result.applePay){
                document.querySelector(".example5 .card-only").style.display = "none";
                document.querySelector(
                    ".example5 .payment-request-available"
                ).style.display =
                    "block";
                $scope.paymentRequestElement.mount("#example5-paymentRequest");
                }
            }
        });
         $scope.paymentRequest.on('paymentmethod',  function (ev)
        {
            //console.log(ev);
            //callGATagApplePay();

             //alert(JSON.stringify(ev));
            // Confirm the PaymentIntent without handling potential next actions (yet).
            //alert(" in " +clientSecret);
            //alert(JSON.stringify(ev));
            //console.log(ev.paymentMethod);
            $scope.stripeTextMsg = $window.msgStripeTransactionProcessing;
            $scope.checkoutRequestData.stripeToken = ev.paymentMethod.id;
            $scope.placeOrderAP(ev);

        });
    }


        $scope.placeOrderAP = function(ev) {
            $scope.paymentMethodType = 'Stripe-Apple-Pay';
            $scope.checkoutRequestData.paymentMethodType = $scope.paymentMethodType;
        $scope.checkoutRequestDataError = [];
        $http({
            method  : 'POST',
            url     : $window.urlDoCheckout,
            data    : $scope.checkoutRequestData
        })
            .then(function(response) {
                var responseData = response.data;
                $scope.handleServerResponseApplePay(responseData, ev);
            },function(response){
                $scope.submitBtnEnable();
                ev.complete('fail');
                if(response.status == 401){
                    //Redirect On Order Page
                    bbNotification.errorRedirect(response.data.message,'');
                    //window.location.reload();
                    //$window.location.href = $window.urlOrder;
                }else if(response.status == 402){
                    bbNotification.error(response.data.message);
                }
                else if(response.status ==400){
                    if(angular.isObject(response.data.message)){
                        $scope.checkoutRequestDataError = response.data.message;
                    }else{
                        bbNotification.error(response.data.message);
                    }
                    //  $scope.btnDisabled = false;
                }
                else if(response.status !=200){
                    if(angular.isObject(response.data.message)){
                        $scope.checkoutRequestDataError = response.data.message;
                    }else{
                        bbNotification.error(response.data.message);
                    }
                    //  $scope.btnDisabled = false;
                }
            }).finally(function() {
            });
    };
    $scope.handleServerResponseApplePay = function(response, ev)
	{

		if (response.error)
		{
		    $scope.submitBtnEnable();
			//alert('HSR1 Error:'+ JSON.stringify(response));
            //alert('HSR2 Error:'+ response.error.message);
			//toastr.error(response.message, 'Error');
			bbNotification.error(response.error.message);
			//console.log('Error handleServerResponseApplePay:' + response.error.message);
			ev.complete('fail');
			//document.getElementById("payment-errors").textContent = response.error.message;

		}
		else if (response.requires_action)
		{
			$scope.submitBtnEnable();
			console.log(' handleServerResponseApplePay:' + "Requires action");
			//document.getElementById("payment-errors").textContent = "Requires action";
			// Use Stripe.js to handle required card action
			ev.complete('success');

			$scope.handleActionApplePay(response, ev);
		}
		else
		{
		    $scope.submitBtnEnable();
			//alert('HSR2 Success :');
			ev.complete('success');
			console.log('Success  handleServerResponseApplePay:');
			//document.getElementById("payment-errors").textContent = "Success!";
			//document.getElementById("payment-form").submit();

			if(response.status ==false){
				bbNotification.error(response.message);
			//	$(buyBtn).removeClass("in_process");
				//buyBtn.textContent = 'Place Order';
			}else{
				  if(response.redirect_url!=''){
                    window.location.href = response.redirect_url;
                }else{
                    bbNotification.errorRedirect($window.msgError,'');
                    //window.location.reload();
                }
			}
		}
	}

	 $scope.handleActionApplePay = function(response, ev)
	{
		$scope.stripeAP.handleCardAction(
			response.payment_intent_client_secret
		).then(function (result)
		{
			if (result.error)
			{
			    $scope.submitBtnEnable();
				bbNotification.error(result.error.message, );
				console.log('Error handleActionApplePay:' + response.error.message);
				ev.complete('fail');
				// document.getElementById("payment-errors").textContent = result.error.message;
			}
			else
			{
				console.log('Success  handleActionApplePay:');
				//console.log(response);
				// The card action has been handled
				// The PaymentIntent can be confirmed again on the server
				 $scope.checkoutRequestData.payment_intent_id = result.paymentIntent.id;
                    $http({
                        method  : 'POST',
                        url     : $window.urlConfirmPayment,
                        data    : $scope.checkoutRequestData
                        //data    : {payment_intent_id: result.paymentIntent.id}
                    }).then(function(response) {
                            var responseData = response.data;
                            $scope.handleServerResponseApplePay(responseData);

                    },function(response){
                            $scope.submitBtnEnable();
                            if(response.status == 401){
                                //Redirect On Order Page
                                bbNotification.errorRedirect($window.msgError,'');
                                //window.location.reload();
                            }
                            else if(response.status ==400){
                                if(angular.isObject(response.data.message)){
                                    $scope.checkoutRequestDataError = response.data.message;
                                }else{
                                    bbNotification.error(response.data.message);
                                }
                            }
                            else if(response.status !=200){
                                if(angular.isObject(response.data.message)){
                                    $scope.checkoutRequestDataError = response.data.message;
                                }else{
                                    bbNotification.error(response.data.message);
                                }
                            }
                    }).finally(function() {
                    });

			}
		});
	}


}]);


function updateStripeInputFields($scope) {
    /*if (window.innerWidth > 0 && window.innerWidth < 100)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '15px', fontSize: '13px'}}});
        $scope.exp.update({style: {base: {lineHeight: '15px', fontSize: '13px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '15px', fontSize: '13px'}}});
    }
    else if (window.innerWidth >= 100 && window.innerWidth < 200)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '20px', fontSize: '13px'}}});
        $scope.exp.update({style: {base: {lineHeight: '20px', fontSize: '13px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '20px', fontSize: '13px'}}});
    }
    else if (window.innerWidth >= 200 && window.innerWidth < 300)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '34px', fontSize: '22px'}}});
        $scope.exp.update({style: {base: {lineHeight: '34px', fontSize: '22px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '34px', fontSize: '22px'}}});
    }
    else if (window.innerWidth >= 300 && window.innerWidth < 400)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '41px', fontSize: '28px'}}});
        $scope.exp.update({style: {base: {lineHeight: '41px', fontSize: '28px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '41px', fontSize: '28px'}}});
    }
    else if (window.innerWidth >= 400 && window.innerWidth < 500)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '65px', fontSize: '40px'}}});
        $scope.exp.update({style: {base: {lineHeight: '65px', fontSize: '40px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '65px', fontSize: '40px'}}});
    }
    else if (window.innerWidth >= 500 && window.innerWidth < 600)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '75px', fontSize: '54px'}}});
        $scope.exp.update({style: {base: {lineHeight: '75px', fontSize: '54px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '75px', fontSize: '54px'}}});
    }
    else if (window.innerWidth >= 600 && window.innerWidth < 620)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '75px', fontSize: '54px'}}});
        $scope.exp.update({style: {base: {lineHeight: '75px', fontSize: '54px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '75px', fontSize: '54px'}}});
    }
    else if (window.innerWidth >= 620 && window.innerWidth < 750)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '26px', fontSize: '18px'}}});
        $scope.exp.update({style: {base: {lineHeight: '26px', fontSize: '18px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '26px', fontSize: '18px'}}});
    }
    else if (window.innerWidth >= 750 && window.innerWidth < 900)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '32px', fontSize: '18px'}}});
        $scope.exp.update({style: {base: {lineHeight: '32px', fontSize: '18px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '32px', fontSize: '18px'}}});
    }
    else if (window.innerWidth >= 900 && window.innerWidth < 1050)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '44px', fontSize: '20px'}}});
        $scope.exp.update({style: {base: {lineHeight: '44px', fontSize: '20px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '44px', fontSize: '20px'}}});
    }
    else if (window.innerWidth >= 1050 && window.innerWidth < 1200)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '48px', fontSize: '20px'}}});
        $scope.exp.update({style: {base: {lineHeight: '48px', fontSize: '20px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '48px', fontSize: '20px'}}});
    }
    else if (window.innerWidth >= 1200 && window.innerWidth < 1350)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '53px', fontSize: '22px'}}});
        $scope.exp.update({style: {base: {lineHeight: '53px', fontSize: '22px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '53px', fontSize: '22px'}}});
    }
    else if (window.innerWidth >= 1350 && window.innerWidth < 1500)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
        $scope.exp.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
    }
    else if (window.innerWidth >= 1500)
    {
        $scope.cardElement.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
        $scope.exp.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
    }
    else
    {
        $scope.cardElement.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
        $scope.exp.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
        $scope.cvc.update({style: {base: {lineHeight: '55px', fontSize: '24px'}}});
     }*/
}