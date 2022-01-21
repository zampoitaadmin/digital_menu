/*(function () {
    'use strict';
    class Menu {
        constructor(settings) {
            this.menuNode = settings.menuNode;
            this.state = false;
            this.menuStateTextNode = settings.menuStateTextNode || this.menuNode.querySelector('.menu__screen-reader');
            this.menuOpenedText = settings.menuOpenedText || 'Open menu';
            this.menuClosedText = settings.menuClosedText || 'Close menu';
        }
        changeState(state) {
            return this.state = !state;
        }
        changeStateText(state, node) {
            let text = (state !== true) ? this.menuOpenedText : this.menuClosedText;
            node.textContent = text;
            return text;
        }
        toggleMenuState(className) {
            let state;
            if (typeof className !== 'string' || className.length === 0) {
                return console.log('you did not give the class for the toggleState function');
            }
            state = this.changeState(this.state);
            this.changeStateText(state, this.menuStateTextNode);
            this.menuNode.classList.toggle(className);
            return state;
        }
    }
    const jsMenuNode = document.querySelector('.menu');
    const demoMenu = new Menu({
        menuNode: jsMenuNode
    });
    function callMenuToggle(event) {
        demoMenu.toggleMenuState('menu_activated');
    }
    jsMenuNode.querySelector('.menu__toggle').addEventListener('click', callMenuToggle);
})();*/
$('.menu__link').on("click", function () {
    $('.menu__toggle').click();
});
/*$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
})
$('.openProductModal').click(function (e) {
});*/
$(document).ready(function () {
    $('ul.nav-pills li a').click(function (e) {
        $('ul.nav-pills li.active').removeClass('active')
        $(this).parent('li').addClass('active')
    })
    $(document).on("scroll", onScroll);
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");
        $('a').each(function () {
            $(this).removeClass('active');
        })
        $(this).addClass('active');
        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top + 1
        }, 600, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
    var navOffset, scrollPos = 0;
    function stickyUtility() {
        if (!$("#search").hasClass("fixed")) {
            navOffset = $("#search").offset().top;
        }
    }
    stickyUtility();
    $(window).resize(function () {
        stickyUtility();
    });
    $(window).scroll(function () {
        scrollPos = $(window).scrollTop();
        if (scrollPos >= navOffset) {
            $("#search").addClass("fixed");
            $('.sticky-top ul').css('margin-top', "55px");
        } else if (scrollPos == 0) {
            var firstLi = $('.sticky-top ul li ').get(0);
            $(firstLi).addClass('active');
        } else {
            $("#search").removeClass("fixed");
            $('.sticky-top ul').css('margin-top', "0px");
        }
    });
});
function onScroll(event) {
    var scrollPos = $(document).scrollTop();
    $('.sticky-top a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('.sticky-top ul li ').removeClass("active");
            currLink.addClass("active");
        } else {
            currLink.removeClass("active");
        }
    });
}
/*$('.tool_tip').tooltip({
    trigger: 'manual'
}).tooltip('show');*/
bbApp.config(function ($locationProvider,$stateProvider, $urlRouterProvider) {
    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/');
    $stateProvider.state('menu', {
        url: '/menu/:slug',
        templateUrl: 'menu.html',
        controller: 'menuCtrl',
        /*resolve: {
            check: ($stateParams, $location) => {
              alert($stateParams.sso);
            }
        }*/
    });
});
