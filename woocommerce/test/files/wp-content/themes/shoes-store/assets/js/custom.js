// menus 
function shoes_store_menu_open_nav() {
    window.shoes_store_responsiveMenu=true;
    jQuery(".sidenav").addClass('show');
}
function shoes_store_menu_close_nav() {
    window.shoes_store_responsiveMenu=false;
    jQuery(".sidenav").removeClass('show');
}
jQuery(function($){
    "use strict";
    jQuery('.main-menu > ul').superfish({
        delay: 500,
        animation: {opacity:'show',height:'show'},
        speed: 'fast'
    });
});

jQuery(document).ready(function () {
    window.shoes_store_currentfocus=null;
    shoes_store_checkfocusdElement();
    var shoes_store_body = document.querySelector('body');
    shoes_store_body.addEventListener('keyup', shoes_store_check_tab_press);
    var shoes_store_gotoHome = false;
    var shoes_store_gotoClose = false;
    window.shoes_store_responsiveMenu=false;
    function shoes_store_checkfocusdElement(){
        if(window.shoes_store_currentfocus=document.activeElement.className){
            window.shoes_store_currentfocus=document.activeElement.className;
        }
    }
    function shoes_store_check_tab_press(e) {
        "use strict";
        // pick passed event or global event object if passed one is empty
        e = e || event;
        var activeElement;

        if(window.innerWidth < 999){
        if (e.keyCode == 9) {
            if(window.shoes_store_responsiveMenu){
            if (!e.shiftKey) {
                if(shoes_store_gotoHome) {
                    jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
                }
            }
            if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
                shoes_store_gotoHome = true;
            } else {
                shoes_store_gotoHome = false;
            }

        }else{

            if(window.shoes_store_currentfocus=="responsivetoggle"){
                jQuery( "" ).focus();
            }}}
        }
        if (e.shiftKey && e.keyCode == 9) {
        if(window.innerWidth < 999){
            if(window.shoes_store_currentfocus=="header-search"){
                jQuery(".responsivetoggle").focus();
            }else{
                if(window.shoes_store_responsiveMenu){
                if(shoes_store_gotoClose){
                    jQuery("a.closebtn.mobile-menu").focus();
                }
                if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
                    shoes_store_gotoClose = true;
                } else {
                    shoes_store_gotoClose = false;
                }

            }else{

            if(window.shoes_store_responsiveMenu){
            }}}}
        }
        shoes_store_checkfocusdElement();
    }
});

jQuery('document').ready(function($){
	// preloader
  setTimeout(function () {
		jQuery("#preloader").fadeOut("slow");
  },1000);

  // Sticky Header
  $(window).scroll(function(){
		var sticky = $('.header-sticky'),
			scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('header-fixed');
		else sticky.removeClass('header-fixed');
	});
});

// Scroller
jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 100) {
      jQuery('.scrollup i').fadeIn();
    } else {
      jQuery('.scrollup i').fadeOut();
    }
	});
	jQuery('.scrollup i').click(function () {
    jQuery("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
	});
});

// search
jQuery(document).ready(function () {
    function shoes_store_search_loop_focus(container) {
        var focusableElements = container.find('select, input, textarea, button, a[href]').filter(':visible'); // Get all focusable elements
        var firstFocus = focusableElements[0]; // First focusable element
        var lastFocus = focusableElements[focusableElements.length - 1]; // Last focusable element
        var KEYCODE_TAB = 9;

        // Add keydown event to the container
        container.on('keydown', function (e) {
            var isTabPressed = e.key === 'Tab' || e.keyCode === KEYCODE_TAB;

            if (!isTabPressed) {
                return;
            }

            if (e.shiftKey) {
                // Shift + Tab: Move focus backward
                if (document.activeElement === firstFocus) {
                    e.preventDefault();
                    lastFocus.focus();
                }
            } else {
                // Tab: Move focus forward
                if (document.activeElement === lastFocus) {
                    e.preventDefault();
                    firstFocus.focus();
                }
            }
        });
    }

    // Open search box and apply focus loop
    jQuery('.search-box span a').click(function () {
        jQuery(".serach_outer").slideDown(1000, function () {
            jQuery(".serach_outer input").first().focus(); // Set focus to the first input field when opening
        });
        shoes_store_search_loop_focus(jQuery('.serach_outer')); // Apply focus loop
    });

    // Close search box
    jQuery('.closepop a').click(function () {
        jQuery(".serach_outer").slideUp(1000);
    });
});

// ================= To hide the order tracking div after getting details Started

document.addEventListener('DOMContentLoaded', function () {
    const orderDetailsSection = document.querySelector('.woocommerce-order-details');

    if (orderDetailsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {

                    setTimeout(() => {
                        window.location.href = homePage.url;
                    }, 5000); 
                }
            });
        }, { threshold: 0.1 }); 

        observer.observe(orderDetailsSection);
    }
});