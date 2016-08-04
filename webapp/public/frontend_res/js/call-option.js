
/*! show contact */
$(function() {
	$(".drawer-item").drawer({
		slideSpeed: 200
	});
});

(function($) {
	$.fn.drawer = function(options) {
		var settings = $.extend({
            slideSpeed: 500
        }, options);
		return this.each(function() {
			$(".drawer-header-icon", this).html(settings.arrowIcon);
			$(".drawer-header", this).click(function(e) {
				e.preventDefault;
				$(this).parent().toggleClass("drawer-item-active")
				$(this).next(".drawer-content").slideToggle( settings.slideSpeed );
				$(".drawer-header-icon", this).toggleClass("drawer-header-icon-active");
			});
		});
	};
}(jQuery));



/*! Pop up video-youtube Tab */
$(document).ready(function(){
	$.wmBox();
});


(function($){
	$.wmBox = function(){
		$('body').prepend('<div class="wmBox_overlay"><div class="wmBox_centerWrap"><div class="wmBox_centerer">');
	};
	$('[data-popup]').click(function(e){
		e.preventDefault();
		$('.wmBox_overlay').fadeIn(300);
		var mySrc = $(this).attr('data-popup');
		$('.wmBox_overlay .wmBox_centerer').html('<div class="wmBox_contentWrap"><div class="wmBox_scaleWrap"><div class="wmBox_closeBtn"><p></p></div><iframe src="'+mySrc+'">');
		
		$('.wmBox_overlay iframe').click(function(e){
			e.stopPropagation();
		});
		$('.wmBox_overlay').click(function(e){
			e.preventDefault();
			$('.wmBox_overlay').fadeOut(300);
		});
	});
}(jQuery));

/*! Call Tab */
$(document).ready(function(){
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})

/*! Call WOW */
 wow = new WOW(
		{
		  animateClass: 'animated',
		  offset:       100,
		  mobile:       false
		}
	  );
	wow.init();

/*----- Page Scroll Features -----*/
    smoothScroll.init({
        speed: 1000,
        updateURL: true,
        offset: 50
    });



// tlav to scroll menu
    $(window).scroll(function () {
		var topMenuHeight = 58;
		var scrollItems=null;
        //Display or hide scroll to top button
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }

        if ($(this).scrollTop() > 120) {
            $('.bghead').addClass('navbar-tlav animated fadeInDown');
        } else {
            $('.bghead').removeClass('navbar-tlav animated fadeInDown');
        }

        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight + 10;

        // Get id of current scroll item
		/*var cur;
		if(scrollItems!=null){
			cur = scrollItems.map(function () {
				if ($(this).offset().top < fromTop)
					return this;
			});
		}


        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
            .parent().removeClass("active")
            .end().filter("[href=#" + id + "]").parent().addClass("active");
        }*/
    });

    /*
    Function for scroliing to top
    ************************************/
    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
	

/*! Call slide-videos */
jQuery(document).ready(function($) {

	'use strict';

		$(".slide-teacher").owlCarousel({
			slideSpeed : 200,
			items : 4,
			itemsCustom : false,
			itemsDesktop : [1199, 3],
			itemsDesktopSmall : [979, 2],
			itemsTablet : [768, 2],
			itemsTabletSmall : false,
			itemsMobile : [479, 1],
			autoPlay: true,
			stopOnHover: true,
			addClassActive: true, 
			responsive: true,
			pagination : false,
			navigation: true,
			navigationText: ["",""],
			
		});


});



/*! Call slide-videos */
jQuery(document).ready(function($) {

	'use strict';

		$(".slide-videos").owlCarousel({
			slideSpeed : 200,
			items : 4,
			itemsCustom : false,
			itemsDesktop : [1199, 4],
			itemsDesktopSmall : [979, 3],
			itemsTablet : [768, 2],
			itemsTabletSmall : false,
			itemsMobile : [479, 1],
			autoPlay: true,
			stopOnHover: true,
			addClassActive: true, 
			responsive: true,
			pagination : false,
			navigation: true,
			navigationText: ["",""],
			
		});


});


 
/*! Call slide-kh */

jQuery(document).ready(function($) {

	'use strict';

		$(".slide-kh").owlCarousel({
			slideSpeed : 200,
			items : 4,
			itemsCustom : false,
			itemsDesktop : [1199, 4],
			itemsDesktopSmall : [979, 3],
			itemsTablet : [768, 2],
			itemsTabletSmall : false,
			itemsMobile : [479, 1],
			autoPlay: true,
			stopOnHover: true,
			autoHeight: true,
			responsive: true,
			navigation: true,
			pagination : false,
			navigationText: ["",""], 
		});
 
});
  
 
/**  Tool tip **/
$(document).ready(function () {
  $('.tooltip-right').tooltip({
    placement: 'right',
    viewport: {selector: 'body', padding: 3}
  })
   $('.tooltip-left').tooltip({
    placement: 'left',
    viewport: {selector: 'body', padding: 3}
  })
  $('.tooltip-top').tooltip({
    placement: 'top',
    viewport: {selector: 'body', padding: 3}
  })
  $('.tooltip-bottom').tooltip({
    placement: 'bottom',
    viewport: {selector: 'body', padding: 3}
  })
 
})
		 