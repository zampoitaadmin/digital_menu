var loader = '<div class="Box">Loading...<span></span></div>';
var loader_inner = '<span class="loader-inner"></span></h3>';
var msgError = 'Something went wrong...!!!';
var msgErrorProductQtyZero = "you have reached the minimum quantity for a product.";
var msgErrorMinimumProductLimit = 'Please select minimum products';
var msgStripeTransactionProcessing = "Note: Please do not press 'Refresh' or 'Back' button";

var app = angular.module('app', ['ngSanitize','ngResource']);
//Option#1
/*app.config(['$provide', function($provide) {
    $provide.decorator('$log', ['$delegate', 'Logging', function($delegate, Logging) {
        Logging.enabled = true;
        var methods = {
            error: function() {
                if (Logging.enabled) {
                    $delegate.error.apply($delegate, arguments);
                    Logging.error.apply(null, arguments);
                }
            },
            log: function() {
                if (Logging.enabled) {
                    $delegate.log.apply($delegate, arguments);
                    Logging.log.apply(null, arguments);
                }
            },
            info: function() {
                if (Logging.enabled) {
                    $delegate.info.apply($delegate, arguments);
                    Logging.info.apply(null, arguments);
                }
            },
            warn: function() {
                if (Logging.enabled) {
                    $delegate.warn.apply($delegate, arguments);
                    Logging.warn.apply(null, arguments);
                }
            }
        };
        return methods;
    }]);
}]);

app.service('Logging', function($injector,$window) {
    var service = {
        error: function() {
            self.type = 'error';
            log.apply(self, arguments);
        },
        warn: function() {
            self.type = 'warn';
            log.apply(self, arguments);
        },
        info: function() {
            self.type = 'info';
            log.apply(self, arguments);
        },
        log: function() {
            self.type = 'log';
            log.apply(self, arguments);
        },
        enabled: false,
        logs: []
    };

    var log = function() {

        args = [];
        if (typeof arguments === 'object') {
            for(var i = 0; i < arguments.length; i++ ) {
                arg = arguments[i];
                var exception = {};
                exception.message = arg.message;
                exception.stack = arg.stack;
                args.push(JSON.stringify(exception));
            }
        }

        var eventLogDateTime = moment(new Date()).format('LLL');
        var logItem = {
            time: eventLogDateTime,
            message: args.join('\n'),
            type: type,
            //errorUrl: $window.location.href,
            //errorMessage: args.join('\n'),//errorMessage,
            //stackTrace: type,//stackTrace,
            //cause: ( cause || "" )
        };


        console.log('Custom logger [' + logItem.time + '] ' + logItem.message.toString());
        service.logs.push(logItem);
        //console.log(service.logs);
    };


    return service;

});*/

//Option#2
/*app.config(function($logProvider){
    $logProvider.debugEnabled(true);
});
app.provider('$exceptionHandler', {
    $get: function( errorLogService ) {
        return( errorLogService );
    }
});*/
/*
app.factory('errorLogService', ['$log', '$window', function($log, $window) {
    function log( exception ) {
        $log.error.apply( $log, arguments );
        try {
            var args = [];
            if (typeof arguments === 'object') {
                for(var i = 0; i < arguments.length; i++ ) {
                    arg = arguments[i];
                    var exceptionItem = {};
                    exceptionItem.message = arg.message;
                    exceptionItem.stack = arg.stack;
                    args.push(JSON.stringify(exception));
                }
            }
            // Phone home and log the error to the server.
            /!*$.ajax({
                type: "POST",
                url: "./javascript-errors",
                contentType: "application/json",
                data: angular.toJson({
                    errorUrl: $window.location.href,
                    errorMessage: errorMessage,
                    stackTrace: stackTrace,
                    cause: ( cause || "" )
                })
            });*!/
            $.ajax({
                type: "POST",
                url: "./javascript-errors",
                contentType: "application/json",
                data: angular.toJson({
                    errorUrl: $window.location.href,
                    errorMessage: args,//errorMessage,
                    stackTrace: 'Error',//stackTrace,
                })
            });
            console.log('from inside the log method ' + args.join('\n') );

        } catch ( loggingError ) {
            // For Developers - log the log-failure.
            $log.warn( "Error logging failed" );
            $log.log( loggingError );
        }
    }
    return( log );
}
]);
*/

app.value('isLoader', false);
app.value('isLoaderCart', false);
app.value('loaderView', '');
app.filter('setDash', function()
{
    return function(input,defaultText)
    {
        //if(input === null){ return "-"; }
        //if(defaultText === null || angular.isUndefined(defaultText)){ return input; }else{ return input+defaultText; }
        if( (input === undefined || input === null || input.length <= 0) ){ return "-"; }
        if( (defaultText === undefined || defaultText === null || defaultText.length <= 0) ){ return input; }else{ return input+defaultText; }
    };
}).filter('pInt',function(){
    return function(input)
    {
        if(input === null){ return 0; }
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


app.directive('number', function () {
        return {
            require: 'ngModel',
            restrict: 'A',
            link: function (scope, element, attrs, ctrl) {
                ctrl.$parsers.push(function (input) {
                    if (input == undefined) return ''
                    var inputNumber = input.toString().replace(/[^0-9]/g, '');
                    if (inputNumber != input) {
                        ctrl.$setViewValue(inputNumber);
                        ctrl.$render();
                    }
                    return inputNumber;
                });
            }
        };
    });

app.directive('stopccp', function(){
    return {
        scope: {},
        link:function(scope,element){
            element.on('cut copy paste', function (event) {
                /*event = event || window.event;
                var keyCode = event.keyCode;
                if (keyCode === 67 && evtobj.ctrlKey) {
                }
                if (keyCode === 86 && evtobj.ctrlKey) {
                }*/
                event.preventDefault();
            });
        }
    };
});

app.directive('switch', function(){
        return {
            restrict: 'AE',
            replace: true,
            transclude: true,
            template: function(element, attrs) {
                var html = '';
                html += '<span';
                html +=   ' class="switch' + (attrs.class ? ' ' + attrs.class : '') + '"';
                html +=   attrs.ngModel ? ' ng-click="' + attrs.disabled + ' ? ' + attrs.ngModel + ' : ' + attrs.ngModel + '=!' + attrs.ngModel + (attrs.ngChange ? '; ' + attrs.ngChange + '()"' : '"') : '';
                html +=   ' ng-class="{ checked:' + attrs.ngModel + ', disabled:' + attrs.disabled + ' }"';
                html +=   '>';
                html +=   '<small></small>';
                html +=   '<input type="checkbox"';
                html +=     attrs.id ? ' id="' + attrs.id + '"' : '';
                html +=     attrs.name ? ' name="' + attrs.name + '"' : '';
                html +=     attrs.ngModel ? ' ng-model="' + attrs.ngModel + '"' : '';
                html +=     ' style="display:none" />';
                html +=     '<span class="switch-text">'; /*adding new container for switch text*/
                html +=     attrs.on ? '<span class="on">'+attrs.on+'</span>' : ''; /*switch text on value set by user in directive html markup*/
                html +=     attrs.off ? '<span class="off">'+attrs.off + '</span>' : ' ';  /*switch text off value set by user in directive html markup*/
                html += '</span>';
                return html;
            }
        };
    });



app.factory('bbNotification', ['$window', function(msg) {
    var notification = {};
    var timer = 2500;
    notification.success = function(msg) {
        Swal.fire({
            type: 'success',
            //position: 'top-end',
            //text: "You won't be able to revert this!",
            title: msg,
            showConfirmButton: false,
            timer: timer
        });
    };
    notification.successRedirect = function(msg,url) {
        Swal.fire({
            type: 'success',
            //position: 'top-end',
            //text: "You won't be able to revert this!",
            title: msg,
            showConfirmButton: false,
            timer: timer
        }).then(function() {
            window.location = url;
        });
    };
    notification.error = function(msg) {
        Swal.fire({
            type: 'error',
            /*position: 'top-end',*/
            /*text: "You won't be able to revert this!",*/
            title: msg,
            showConfirmButton: false,
            timer: timer
        });
    };
    notification.errorRedirect = function(msg,url) {
        Swal.fire({
            type: 'error',
            //position: 'top-end',
            //text: "You won't be able to revert this!",
            title: msg,
            showConfirmButton: false,
            timer: timer
        }).then(function() {
            if(url!=''){
                window.location = url;
            }else{
                window.location.reload();
            }

        });
    };
    notification.warningWithHtml = function(msg) {
        Swal.fire({
            type: 'warning',
            html:msg,
            /*position: 'top-end',*/
            /*text: "You won't be able to revert this!",*/
            //title: msg,
            showConfirmButton: true,
            //timer: 5000
        });
    };
    return notification;
    /*return function(msg) {

        //win.alert(msgs.join('\n'));
        Swal.fire({
            type: 'success',
            /!*position: 'top-end',*!/
            text: "You won't be able to revert this!",
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        });

    };*/
}]);

app.factory('bbLoader', ['$window', function($window,msg) {
    var loaderData = {};

    var timer = 2500;
    loaderData.show = function(type) {
        if(type==='C'){
            isLoaderCart =true;
            loaderView = $window.loader;
        }else{
            isLoader = true;
            loaderView = $window.loader;
        }

    };
    return loaderData;
}]);
function goToUpFun() {
    jQuery(window).scrollTop(0);
}
