
/*
var app = angular.module('app', ['ngSanitize']);
app.filter('setDash', function()
{
    return function(input,defaultText)
    {
        if(input == null){ return "-"; }
        if(defaultText == null){ return input; }else{ return input+defaultText; }
    };
}).filter('pInt',function(){
    return function(input)
    {
        if(input == null){ return 0; }
        return parseInt(input);
    };
});
app.allowOnlyNumbers = function () {
    return {
        require: 'ngModel',
        restrict: 'A',
        link: function (scope, element, attr, ctrl) {
            function inputValue(val) {
                if (val) {
                    var digits = val.replace(/[^0-9]/g, '');
                    if (digits !== val) {
                        ctrl.$setViewValue(digits);
                        ctrl.$render();
                    }
                    return parseInt(digits, 10);
                }
                return undefined;
            }
            ctrl.$parsers.push(inputValue);
        }
    };
};
*/
//TODO
// Default Load Cart and Preselected options and step
app.controller('cartCtrl',['$scope','$http','$filter', '$window', '$location', '$anchorScroll','bbNotification', function($scope, $http, $filter, $window, $location, $anchorScroll,bbNotification) {
    $scope.apiURL = '';
    $scope.currentStep = 'step-size';//'GENERAL'; //ng-show="current_step=='product_info'" ng-cloak
    $scope.btnLoading = false;
    $scope.sizeList = [];
    $scope.styleWallList = [];
    $scope.styleEdgeList = [];
    $scope.designFontList = [];
    $scope.colorList = [];
    $scope.fixingTypeList = [];

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
        //$scope.packageType = initData;
        //Swal.fire('Success', 'tete', 'success', false, 1500);
        //bbNotification.error('asdasda');
        $scope.setRequestData();
        $scope.getProductFun();
    };

    //Clear Cart
    $scope.setRequestData = function(){
        $scope.sizeList = [];
        $scope.styleWallList = [];
        $scope.styleEdgeList = [];
        $scope.designFontList = [];
        $scope.colorList = [];
        $scope.fixingTypeList = [];
        $scope.requestFormData = {
            cartPreview : {}, //'lin1':'','line2':'','line3':''
            cartSize : [],
            cartStyleWall: [],
            cartStyleEdge: [],
            //cartDesign: [],
            cartDesignFont: [],
            cartColor: [],
            cartFixing: [],
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

    $scope.changeStepFun=  function(stepId){
        goToUpFun();
        $scope.type= 0;
        if(stepId === 'step-size'){
            $scope.step = 0;
            $scope.currentStep = 'step-size';
        }else if(stepId === 'step-style-wall') {
            $scope.currentStep = 'step-style-wall';
            $scope.previewFun();
        }else if(stepId === 'step-style-edge') {
            $scope.currentStep = 'step-style-edge';
            $scope.previewFun();
        }else if(stepId === 'step-design') {
            $scope.currentStep = 'step-design';
            $scope.previewFun();
        }else if(stepId === 'step-color') {
            $scope.currentStep = 'step-color';
            $scope.previewFun();
        }else if(stepId === 'step-confirm') {
            $scope.currentStep = 'step-confirm';
            $scope.previewFun();
        }
        else if(stepId === 'DELIVERY') {
        }
        else{
        }
    };

    //Get Products
    $scope.getProductFun =  function(){
        $scope.showLoaderFun('P');
        $scope.sizeList = [];
        $scope.styleWallList = [];
        $scope.styleEdgeList = [];
        $http({
            method  : 'GET',
            url     : $window.urlGetProductList,
            data    : {}
        })
        .then(function(response) {
                var responseData = response.data;
                if(responseData.status){
                    $scope.sizeList = responseData.data.sizeList;
                    $scope.styleWallList = responseData.data.styleWallList;
                    $scope.styleEdgeList = responseData.data.styleEdgeList;
                    $scope.designFontList = responseData.data.designFontList;
                    $scope.colorList = responseData.data.colorList;
                    $scope.fixingTypeList = responseData.data.fixingTypeList;

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
    //Select Size
    $scope.selectSizeFun =  function(row){
        $scope.requestFormData.cartSize = row;
        if($scope.styleWallList){
            $scope.requestFormData.cartStyleWall = $scope.styleWallList['wall21'];
        }
        if($scope.requestFormData.cartStyleEdge){ //TODO check when emtpy and has value
            $scope.requestFormData.cartStyleEdge = $scope.styleEdgeList['CLASSIC'];
            //$scope.requestFormData.cartPreview.style = $scope.requestFormData.cartStyleEdge ;
        }

        if($scope.requestFormData.cartDesignFont){ //TODO check when emtpy and has value
            $scope.requestFormData.cartDesignFont = $scope.designFontList['Albertus-Medium'];
        }

        if($scope.requestFormData.cartColor){ //TODO check when emtpy and has value
            $scope.requestFormData.cartColor = $scope.colorList['White'];
        }
        if($scope.requestFormData.cartFixing){ //TODO check when emtpy and has value
            $scope.requestFormData.cartFixing = $scope.fixingTypeList['fixing_type_secret'];
        }
        $scope.requestFormData.cartPreview.line1 = '';
        $scope.requestFormData.cartPreview.line2 = '';
        $scope.requestFormData.cartPreview.line3 = '';
        if($scope.screensize < 621) {
            $scope.requestFormData.cartPreview.marginTop1 = $scope.requestFormData.cartSize.cssData.lt_621.mt;
            $scope.requestFormData.cartPreview.marginTop2 = $scope.requestFormData.cartSize.cssData.lt_621.mt;
            $scope.requestFormData.cartPreview.marginTop3 = $scope.requestFormData.cartSize.cssData.lt_621.mt;
            $scope.requestFormData.cartPreview.fontSize = $scope.requestFormData.cartSize.cssData.lt_621.fs;
        } else if($scope.screensize > 1000) {
            $scope.requestFormData.cartPreview.marginTop1 = $scope.requestFormData.cartSize.cssData.gt_1000.mt;
            $scope.requestFormData.cartPreview.marginTop2 = $scope.requestFormData.cartSize.cssData.gt_1000.mt;
            $scope.requestFormData.cartPreview.marginTop3 = $scope.requestFormData.cartSize.cssData.gt_1000.mt;
            $scope.requestFormData.cartPreview.fontSize = $scope.requestFormData.cartSize.cssData.gt_1000.fs;
        } else {
            $scope.requestFormData.cartPreview.marginTop1 = $scope.requestFormData.cartSize.cssData.other.mt;
            $scope.requestFormData.cartPreview.marginTop2 = $scope.requestFormData.cartSize.cssData.other.mt;
            $scope.requestFormData.cartPreview.marginTop3 = $scope.requestFormData.cartSize.cssData.other.mt;
            $scope.requestFormData.cartPreview.fontSize = $scope.requestFormData.cartSize.cssData.other.fs;
        }
        $scope.setFontPositionFun();
        //$scope.previewFun();
        $scope.changeStepFun('step-style-wall');
    };
    $scope.selectStyleWallFun =  function(row){
        $scope.requestFormData.cartStyleWall = row;
        $scope.previewFun();
    };
    $scope.selectStyleEdgeFun =  function(row){
        $scope.requestFormData.cartStyleEdge = row;
        $scope.previewFun();
    };
    $scope.selectDesignFontFun =  function(row){
        $scope.requestFormData.cartDesignFont = row;
        $scope.previewFun();
    };

    //$("#t_line2").on("keypress keydown keyup change", function() {
    $scope.setFontPositionFun =  function(){
        var mtLine1 = 0;
        var mtLine2 = 0;
        var mtLine3 = 0;
        if($scope.screensize < 621) {
            if ($scope.requestFormData.cartPreview.styleId === "style3") {
                mtLine1 = '5.20161290322581vw';
                mtLine2 = '9.53629032258065vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '7.80241935483871vw';
                }
            } else if ($scope.requestFormData.cartPreview.styleId === "style6") {
                mtLine1 = '6.93548387096774vw';
                mtLine2 = '13.8709677419355vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '11.2701612903226vw';
                }

            }   else if ($scope.requestFormData.cartPreview.styleId === "style7") {
                mtLine1 = '9.53629032258065vw';
                mtLine2 = '15.6048387096774vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '12.1370967741935vw';
                }
                if( ($scope.requestFormData.cartPreview.line3 !== undefined && $scope.requestFormData.cartPreview.line3 !== null &&  $scope.requestFormData.cartPreview.line3.length > 0 )){
                    mtLine1 = '6.06854838709677vw';
                    mtLine2 = '11.2701612903226vw';
                    mtLine3 = '16.4717741935484vw';
                }
            }else if ($scope.requestFormData.cartPreview.styleId === "style8") {
                mtLine1 = '7.80241935483871vw';
                mtLine2 = '13.8709677419355vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '11.2701612903226vw';
                }

            }else if ($scope.requestFormData.cartPreview.styleId === "style9") {
                mtLine1 = '8';
                mtLine2 = '15';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '75px';
                }
            } else if ($scope.requestFormData.cartPreview.styleId === "style10") {
                mtLine1 = '17.3387096774194vw';
                mtLine2 = '24.2741935483871vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '21.6733870967742vw';
                }
                if( ($scope.requestFormData.cartPreview.line3 !== undefined && $scope.requestFormData.cartPreview.line3 !== null &&  $scope.requestFormData.cartPreview.line3.length > 0 )){
                    mtLine1 = '10.4032258064516vw';
                    mtLine2 = '17.3387096774194vw';
                    mtLine3 = '24.2741935483871vw';
                }
            }else{
                mtLine1 = $scope.requestFormData.cartSize.cssData.gt_1000.mt;
            }
        }
        else if($scope.screensize > 1000) {
            if ($scope.requestFormData.cartPreview.styleId === "style3") {
                mtLine1 = '30px';
                mtLine2 = '55px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '45px';
                }
            } if ($scope.requestFormData.cartPreview.styleId === "style4") {
                mtLine1 = '35px';
                mtLine2 = '60px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '35px';
                }
            }if ($scope.requestFormData.cartPreview.styleId === "style5") {
                mtLine1 = '35px';
                mtLine2 = '60px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '35px';
                }
            }
            else if ($scope.requestFormData.cartPreview.styleId === "style6") {
                mtLine1 = '40px';
                mtLine2 = '80px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '65px';
                }

            }   else if ($scope.requestFormData.cartPreview.styleId === "style7") {
                mtLine1 = '55px';
                mtLine2 = '90px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '70px';
                }
                if( ($scope.requestFormData.cartPreview.line3 !== undefined && $scope.requestFormData.cartPreview.line3 !== null &&  $scope.requestFormData.cartPreview.line3.length > 0 )){
                    mtLine1 = '35px';
                    mtLine2 = '65px';
                    mtLine3 = '95px';
                }
            }else if ($scope.requestFormData.cartPreview.styleId === "style8") {
                mtLine1 = '45px';
                mtLine2 = '80px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '65px';
                }

            }else if ($scope.requestFormData.cartPreview.styleId === "style9") {
                mtLine1 = '50px';
                mtLine2 = '90px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '75px';
                }
            } else if ($scope.requestFormData.cartPreview.styleId === "style10") {
                mtLine1 = '100px';
                mtLine2 = '140px';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '125px';
                }
                if( ($scope.requestFormData.cartPreview.line3 !== undefined && $scope.requestFormData.cartPreview.line3 !== null &&  $scope.requestFormData.cartPreview.line3.length > 0 )){
                    mtLine1 = '60px';
                    mtLine2 = '100px';
                    mtLine3 = '140px';
                }
            }else{
                mtLine1 = $scope.requestFormData.cartSize.cssData.gt_1000.mt;
            }

        }
        else {
            if ($scope.requestFormData.cartPreview.styleId === "style3") {
                mtLine1 = '3vw';
                mtLine2 = '5.5vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '4.5vw';
                }
            } else if ($scope.requestFormData.cartPreview.styleId === "style6") {
                mtLine1 = '4vw';
                mtLine2 = '8vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '6.5vw';
                }

            }   else if ($scope.requestFormData.cartPreview.styleId === "style7") {
                mtLine1 = '5.5vw';
                mtLine2 = '9vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '7vw';
                }
                if( ($scope.requestFormData.cartPreview.line3 !== undefined && $scope.requestFormData.cartPreview.line3 !== null &&  $scope.requestFormData.cartPreview.line3.length > 0 )){
                    mtLine1 = '3.5vw';
                    mtLine2 = '6.5vw';
                    mtLine3 = '9.5vw';
                }
            }else if ($scope.requestFormData.cartPreview.styleId === "style8") {
                mtLine1 = '4.5vw';
                mtLine2 = '8vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '6.5vw';
                }

            }else if ($scope.requestFormData.cartPreview.styleId === "style9") {
                mtLine1 = '5vw';
                mtLine2 = '9vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '7.5vw';
                }
            } else if ($scope.requestFormData.cartPreview.styleId === "style10") {
                mtLine1 = '10vw';
                mtLine2 = '14vw';
                if( ($scope.requestFormData.cartPreview.line2 === undefined || $scope.requestFormData.cartPreview.line2 === null || $scope.requestFormData.cartPreview.line2.length <= 0) ){
                    mtLine1 = '12.5vw';
                }
                if( ($scope.requestFormData.cartPreview.line3 !== undefined && $scope.requestFormData.cartPreview.line3 !== null &&  $scope.requestFormData.cartPreview.line3.length > 0 )){
                    mtLine1 = '6vw';
                    mtLine2 = '10vw';
                    mtLine3 = '14vw';
                }
            }else{
                mtLine1 = $scope.requestFormData.cartSize.cssData.gt_1000.mt;
            }
        }

        $scope.requestFormData.cartPreview.marginTop1 = mtLine1;
        $scope.requestFormData.cartPreview.marginTop2 = mtLine2;
        $scope.requestFormData.cartPreview.marginTop3 = mtLine3;

        //FONT SIZE
        var d_width = $scope.requestFormData.cartSize.dWidth;

        /*if ($('#hid_line1').width() >= d_width) {
            var curSize = parseInt(jQuery('#line1').css('font-size')) - 2;
            if (curSize >= 20) {
                $scope.requestFormData.cartPreview.fontSize = curSize+'px';
            }
        }*/

       /* var curSize = parseInt(jQuery('#line1').css('font-size'));
        if (jQuery('#hid_line1').width() >= d_width || jQuery('#hid_line2').width() >= d_width || jQuery('#hid_line3').width() >= d_width) {
            curSize = parseInt(jQuery('#line1').css('font-size')) - 2;
            $scope.requestFormData.cartPreview.fontSize = curSize+'px';

        } else {
            $scope.requestFormData.cartPreview.fontSize = curSize+'px';

        }*/

        do {

           var  curSize = parseInt(jQuery('#line1').css('font-size'));
            if (jQuery('#hid_line1').width() > d_width || jQuery('#hid_line2').width() > d_width || jQuery(
                '#hid_line3').width() > d_width) {
                curSize = parseInt(jQuery('#line1').css('font-size')) - 2;
                jQuery('#line1,#line2,#line3').css('font-size', curSize);
                jQuery('#hid_line1,#hid_line2,#hid_line3').css('font-size', curSize);
                jQuery("#sign_font_size").val(curSize);
            } else {
                jQuery('#line1,#line2,#line3').css('font-size', curSize);
                jQuery('#hid_line1,#hid_line2,#hid_line3').css('font-size', curSize);
                jQuery("#sign_font_size").val(curSize);
                break;
            }
        }
        while (jQuery('#hid_line1').width() >= d_width || jQuery('#hid_line2').width() >= d_width ||
        jQuery('#hid_line3').width() >= d_width);


        $scope.previewFun();
    };
    $scope.increaseFontPositionFun =  function(){
        var curPos1 = parseInt(jQuery('#line1').css('margin-top')) - 2;
        var curPos2 = parseInt(jQuery('#line2').css('margin-top')) - 2;
        var curPos3 = parseInt(jQuery('#line3').css('margin-top')) - 2;
        var s_curPos1 = 26;
        var s_curPos2 = 26;
        var s_curPos3 = 26;
        var s_curSize = 0;
        var mtLine1 = $scope.requestFormData.cartPreview.marginTop1 ;
        var mtLine2 = $scope.requestFormData.cartPreview.marginTop2 ;
        var mtLine3 = $scope.requestFormData.cartPreview.marginTop3  ;
        if ($scope.requestFormData.cartPreview.styleId === "style1") {
            s_curSize = 26;
        } else if ($scope.requestFormData.cartPreview.styleId === "style2" || $scope.requestFormData.cartPreview.styleId === "style3") {
            s_curSize = 26;
        } else if ($scope.requestFormData.cartPreview.styleId === "style4") {
            s_curSize = 26;
        } else if ($scope.requestFormData.cartPreview.styleId === "style5" || $scope.requestFormData.cartPreview.styleId === "style9") {
            s_curSize = 26;
        } else if ($scope.requestFormData.cartPreview.styleId === "style6" || $scope.requestFormData.cartPreview.styleId === "style7") {
            s_curSize = 26;
        } else if ($scope.requestFormData.cartPreview.styleId === "style8") {
            s_curSize = 26;
        } else if ($scope.requestFormData.cartPreview.styleId === "style10") {
            s_curSize = 26;
        }
        if (curPos1 >= s_curSize) {
            mtLine1 = curPos1+'px';
            mtLine2 = curPos2+'px';
            mtLine3 = curPos3+'px';
        }
        $scope.requestFormData.cartPreview.marginTop1 = mtLine1;
        $scope.requestFormData.cartPreview.marginTop2 = mtLine2;
        $scope.requestFormData.cartPreview.marginTop3 = mtLine3;

        $scope.previewFun();

    };
    $scope.decreaseFontPositionFun =  function(){
        var curPos1 = parseInt(jQuery('#line1').css('margin-top')) + 2;
        var curPos2 = parseInt(jQuery('#line2').css('margin-top')) + 2;
        var curPos3 = parseInt(jQuery('#line3').css('margin-top')) + 2;
        //var s_curPos2 = 26;
        //var s_curPos3 = 26;
        //var s_curSize = 0;
        var mtLine1 = $scope.requestFormData.cartPreview.marginTop1 ;
        var mtLine2 = $scope.requestFormData.cartPreview.marginTop2 ;
        var mtLine3 = $scope.requestFormData.cartPreview.marginTop3  ;

        var s_curPos = 50;
        if ($scope.requestFormData.cartPreview.styleId === "style1") {
            s_curPos = 100;
        } else if ($scope.requestFormData.cartPreview.styleId === "style2") {
            s_curPos = 70;
        } else if ($scope.requestFormData.cartPreview.styleId === "style3") {
            if( ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0) ){
                s_curPos = 34;
            }else{
                s_curPos = 70;
            }

        } else if ($scope.requestFormData.cartPreview.styleId === "style4" || $scope.requestFormData.cartPreview.styleId === "style5") {
            s_curPos = 65;
        } else if ($scope.requestFormData.cartPreview.styleId === "style9") {
            if( ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0) ){
                s_curPos = 75;
            }else{
                s_curPos = 137;
            }
        } else if ($scope.requestFormData.cartPreview.styleId === "style6") {
            if( ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0) ){
                s_curPos = 65;
            }else{
                s_curPos = 115;
            }
        } else if ($scope.requestFormData.cartPreview.styleId === "style7") {
            if( ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0) && ($scope.requestFormData.cartPreview.line3 !== undefined || $scope.requestFormData.cartPreview.line3 !== null || $scope.requestFormData.cartPreview.line3.length > 0)  ){
                s_curPos = 45;
            }else if( ($scope.requestFormData.cartPreview.line1 !== undefined || $scope.requestFormData.cartPreview.line1 !== null || $scope.requestFormData.cartPreview.line1.length > 0) && ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0)  ){
                s_curPos = 77;
            }else if( ($scope.requestFormData.cartPreview.line1 !== undefined || $scope.requestFormData.cartPreview.line1 !== null || $scope.requestFormData.cartPreview.line1.length > 0) && ($scope.requestFormData.cartPreview.line3 !== undefined || $scope.requestFormData.cartPreview.line3 !== null || $scope.requestFormData.cartPreview.line3.length > 0)  ){
                s_curPos = 125;
            }else{
                s_curPos = 135;
            }
        } else if ($scope.requestFormData.cartPreview.styleId === "style8") {
            if( ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0)){
                s_curPos = 55;
            }else{
                s_curPos = 110;
            }
        } else if ($scope.requestFormData.cartPreview.styleId === "style10") {
            if( ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0) && ($scope.requestFormData.cartPreview.line3 !== undefined || $scope.requestFormData.cartPreview.line3 !== null || $scope.requestFormData.cartPreview.line3.length > 0)  ){
                s_curPos = 85;
            }else if( ($scope.requestFormData.cartPreview.line1 !== undefined || $scope.requestFormData.cartPreview.line1 !== null || $scope.requestFormData.cartPreview.line1.length > 0) && ($scope.requestFormData.cartPreview.line2 !== undefined || $scope.requestFormData.cartPreview.line2 !== null || $scope.requestFormData.cartPreview.line2.length > 0)  ){
                s_curPos = 140;
            }else if( ($scope.requestFormData.cartPreview.line1 !== undefined || $scope.requestFormData.cartPreview.line1 !== null || $scope.requestFormData.cartPreview.line1.length > 0) && ($scope.requestFormData.cartPreview.line3 !== undefined || $scope.requestFormData.cartPreview.line3 !== null || $scope.requestFormData.cartPreview.line3.length > 0)  ){
                s_curPos = 125;
            }else{
                s_curPos = 227;
            }
        }
        if (curPos1 <= s_curPos) {
            mtLine1 = curPos1+'px';
            mtLine2 = curPos2+'px';
            mtLine3 = curPos3+'px';
        }
        $scope.requestFormData.cartPreview.marginTop1 = mtLine1;
        $scope.requestFormData.cartPreview.marginTop2 = mtLine2;
        $scope.requestFormData.cartPreview.marginTop3 = mtLine3;
        $scope.previewFun();

    };

    $scope.increaseFontSizeFun =  function(row){
        var d_width = $scope.requestFormData.cartSize.dWidth;
        var fontSizeMax = $scope.requestFormData.cartSize.fontSizeMax;
        if (jQuery('#hid_line1').width() >= d_width || jQuery('#hid_line2').width() >= d_width || jQuery('#hid_line3').width() >= d_width){
            return false;
        }
        var curSize = parseInt(jQuery('#line1').css('font-size')) + 2;
        if (curSize <= fontSizeMax) {
            $scope.requestFormData.cartPreview.fontSize = curSize+'px';
        }

        /*if ($('#hid_line1').width() >= d_width) {
            curSize = parseInt($('#line1').css('font-size')) - 2;
            if (curSize >= 20) {
                $('#line1,#line2,#line3').css('font-size', curSize);
                $('#hid_line1,#hid_line2,#hid_line3').css('font-size', curSize);
                $("#sign_font_size").val(curSize);
            }
        }*/
        $scope.previewFun();
    };
    $scope.decreaseFontSizeFun =  function(row){
        var d_width = $scope.requestFormData.cartSize.dWidth;
        var fontSizeMin = $scope.requestFormData.cartSize.fontSizeMin;
        //$scope.requestFormData.cartDesignFont = row;
        /*if (jQuery('#hid_line1').width() >= d_width || jQuery('#hid_line2').width() >= d_width || jQuery('#hid_line3').width() >= d_width){
            return false;
        }*/
        var curSize = parseInt(jQuery('#line1').css('font-size')) - 2;
        if (curSize >= fontSizeMin) {
            $scope.requestFormData.cartPreview.fontSize = curSize+'px';
        }
        $scope.previewFun();
    };


    $scope.selectColorFun =  function(row){
        $scope.requestFormData.cartColor = row;
        $scope.previewFun();
    };

    $scope.selectFixingFun =  function(row){
        $scope.requestFormData.cartFixing = row;
        $scope.previewFun();
    };

    $scope.previewFun =  function(){
        $scope.requestFormData.cartPreview.imageW = $scope.requestFormData.cartSize.imageW;
        $scope.requestFormData.cartPreview.imageH = $scope.requestFormData.cartSize.imageH;
        $scope.requestFormData.cartPreview.styleId = $scope.requestFormData.cartSize.id;
        $scope.requestFormData.cartPreview.maxLength = $scope.requestFormData.cartSize.maxLength;
        $scope.requestFormData.cartPreview.isSingleFixing = $scope.requestFormData.cartSize.isSingleFixing;

        $scope.requestFormData.cartPreview.imgBgUrl = $scope.requestFormData.cartStyleWall.imgBgUrl;
        $scope.requestFormData.cartPreview.imgName = $scope.requestFormData.cartSize.size + $scope.requestFormData.cartStyleEdge.name + '.png';
        $scope.requestFormData.cartPreview.fontName = $scope.requestFormData.cartDesignFont.name;
        $scope.requestFormData.cartPreview.font = $scope.requestFormData.cartDesignFont.font;

        $scope.requestFormData.cartPreview.colorName = $scope.requestFormData.cartColor.name;
        $scope.requestFormData.cartPreview.colorCode = $scope.requestFormData.cartColor.colorCode;
        $scope.requestFormData.cartPreview.fixingType = $scope.requestFormData.cartFixing.code ;
        $scope.requestFormData.cartPreview.screensize = $scope.screensize ;
        $scope.requestFormData.cartPreview.edgeType = $scope.requestFormData.cartStyleEdge.name;

        if($scope.requestFormData.cartStyleEdge.name ==='BORDERED'){
            var color = $scope.requestFormData.cartColor.colorCode;
            if (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())) {
                if($scope.screensize < 621) {
                    $('#slate_preview').css('outline-offset', '-2.08064516129032vw');
                    $('#slate_preview').css('outline', '0.346774193548387vw solid '+color);
                } else if($scope.screensize > 1000) {
                    $('#slate_preview').css('outline-offset', '-12px');
                    $('#slate_preview').css('outline', '2px solid '+color);
                } else {
                    $('#slate_preview').css('outline-offset', '-1.2vw');
                    $('#slate_preview').css('outline', '0.2vw solid '+color);
                }
            }
            else {
                if($scope.screensize < 621) {
                    $('#slate_preview').css('outline', '0.346774193548387vw solid '+color);
                    $('#slate_preview').css('outline-offset', '-2.08064516129032vw');

                } else if($scope.screensize > 1000) {
                    $('#slate_preview').css('outline', '2px solid '+color);
                    $('#slate_preview').css('outline-offset', '-12px');

                } else {
                    $('#slate_preview').css('outline', '0.2vw solid '+color);
                    $('#slate_preview').css('outline-offset', '-1.2vw');

                }
            }
        }
        else{
            if (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())) {
                jQuery('#slate_preview').css('outline-offset', '');
                jQuery('#slate_preview').css('outline', '');
            }
            else {
                jQuery('#slate_preview').css('outline', '');
                jQuery('#slate_preview').css('outline-offset', '');
            }
        }
        console.log($scope.requestFormData.cartPreview.font);
        if ($scope.requestFormData.cartPreview.font == "Incimar1") {
            $scope.requestFormData.cartPreview.textTransform = 'uppercase';
            //jQuery('#line1,#line2,#line3').css('text-transform', 'uppercase');
            //jQuery('#hid_line1,#hid_line2,#hid_line3').css('text-transform', 'uppercase');
        } else {
            $scope.requestFormData.cartPreview.textTransform = '';
            //jQuery('#line1,#line2,#line3').css('text-transform', '');
            //jQuery('#hid_line1,#hid_line2,#hid_line3').css('text-transform', '');
        }

    };
 /* #TODO if sign change then default value set to all step */
    $scope.setTextFun = function(lineId,event){
        /*if(lineId===1){
            event = event || window.event;
            var keyCode = event.keyCode;
            //if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || (keyCode == 38 || keyCode == 40)) {} else {
            if (((keyCode >= 96 && keyCode <= 105) || (keyCode >= 48 && keyCode <= 57) || (keyCode == 109 || keyCode == 107))) {} else {
                return false;
            }
            //$scope.requestFormData.cartDesign.line1 = $('#t_line1').val();
            /!*if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                $scope.requestFormData.cartDesign.line1 = $('#t_line1').val();
                return;
            }*!/
        }*/

    };

    //Add to cart Item
    $scope.addToCartFun =  function(){
        $http({
            method  : 'POST',
            url     : $window.urlCartAddProduct,
            data    : $scope.requestFormData
        }).then(function(response) { //handle Success scenario
            var responseData = response.data;
            if(responseData.status){
                //TODO
                window.location.href = $window.urlReview;
                //bbNotification.successRedirect(responseData.message,$window.urlReview);
            }else{
                bbNotification.error(responseData.message);
            }
        },function(response){ //Only Handle Error Scenario
            var responseData = response.data;
            /*if(response.status ==500){
                $scope.applyCouponCodeFun();
            }else*/
            if(response.status !=200){
                bbNotification.error(responseData.message);
            }
        }).finally(function() {
        });
    };

    $scope.getkeys = function (event) {

        $scope.keyval = event.keyCode;
        if(1) {
            event = event || window.event;
            var keyCode = event.keyCode;
            if ($scope.requestFormData.cartPreview.styleId === "style1") {
                jQuery("#t_line1").attr('maxlength', $scope.requestFormData.cartPreview.maxLength.line1);


                //if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || (keyCode == 38 || keyCode == 40)) {} else {
                if (((keyCode > 97 && keyCode > 126) || (keyCode >= 48 && keyCode <= 57) || (keyCode.shiftKey))) {
                    if(window.which === 86 && event.ctrlKey){
                        //alert("COPY paset not allowe");
                    }
                } else {
                    event.preventDefault();
                }
            }
            else if ($scope.requestFormData.cartPreview.styleId === "style2") {
                jQuery("#t_line1").attr('maxlength', $scope.requestFormData.cartPreview.maxLength.line1);
              //  event = event || window.event;
              //  var keyCode = event.keyCode;
                //if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || (keyCode == 38 || keyCode == 40)) {} else {
                if (((keyCode > 97 && keyCode > 126) || (keyCode >= 48 && keyCode <= 57) || (keyCode.shiftKey))) {
                } else {
                    event.preventDefault();
                }
            }
            else {
                jQuery("#t_line1").attr('maxlength', $scope.requestFormData.cartPreview.maxLength.line1);
            }
        }

    };
}]);
