(function ($) {
	'use strict';
  
	/*
	|--------------------------------------------------------------------------
	| Template Name: Bizmax
	| Author: Laralink
	| Version: 1.0.0
	|--------------------------------------------------------------------------
	|--------------------------------------------------------------------------
	| TABLE OF CONTENTS:
	|--------------------------------------------------------------------------
	|
	| 1. Preloader
	| 2. Mobile Menu
	| 3. Sticky Header
	| 4. Dynamic Background
	| 5. Slick Slider
	| 6. Parallax Slider Swiper
	| 7. Isotop Initialize
	| 8. Review
	| 9. Modal Video
	| 10. Tabs
	| 11. Accordian
	| 12. Counter Animation
	| 13. Ripple
	| 14. Progress Bar
	| 15. Dynamic contact form
	|
	*/
  
	/*--------------------------------------------------------------
	  Scripts initialization
	--------------------------------------------------------------*/
	$.exists = function (selector) {
	  return $(selector).length > 0;
	};
  
	$(window).on('load', function () {
	  $(window).trigger('scroll');
	  $(window).trigger('resize');
	  preloader();
	});
  
	$(function () {
	  $(window).trigger('resize');
	  mainNav();
	  stickyHeader();
	  dynamicBackground();
	  review();
	  modalVideo();
	  tabs();
	  counterInit();
	  rippleInit();
	  progressBar();
	  if ($.exists('.player')) {
		$('.player').YTPlayer();
	  }
	});
  
	$(window).on('scroll', function () {
	  counterInit();
	});
  
	/*--------------------------------------------------------------
	  1. Preloader
	--------------------------------------------------------------*/
	function preloader() {
	  $('.cs_preloader_in').fadeOut();
	  $('.cs_preloader').delay(150).fadeOut('slow');
	}
  
	/*--------------------------------------------------------------
	  2. Mobile Menu
	--------------------------------------------------------------*/
	function mainNav() {
	  $('.cs_nav').append('<span class="cs-munu_toggle"><span></span></span>');
	  $('.menu-item-has-children').append(
		'<span class="cs-munu_dropdown_toggle"></span>',
	  );
	  $('.cs-munu_toggle').on('click', function () {
		$(this).toggleClass('cs-toggle_active');
		$('.cs_nav_list').slideToggle();
	  });
	  $('.cs-munu_dropdown_toggle').on('click', function () {
		$(this).toggleClass('active').siblings('ul').slideToggle();
		$(this).parent().toggleClass('active');
	  });
	  // Search Toggle
	  $('.cs_header_search_btn').on('click', function () {
		$(this).parents('.cs_header_search_wrap').toggleClass('active');
	  });
	}
  
	/*--------------------------------------------------------------
	  3. Sticky Header
	--------------------------------------------------------------*/
	function stickyHeader() {
	  var $window = $(window);
	  var lastScrollTop = 0;
	  var $header = $('.cs_sticky_header');
	  var headerHeight = $header.outerHeight() + 30;
  
	  $window.scroll(function () {
		var windowTop = $window.scrollTop();
  
		if (windowTop >= headerHeight) {
		  $header.addClass('cs-gescout_sticky');
		} else {
		  $header.removeClass('cs-gescout_sticky');
		  $header.removeClass('cs-gescout_show');
		}
  
		if ($header.hasClass('cs-gescout_sticky')) {
		  if (windowTop < lastScrollTop) {
			$header.addClass('cs-gescout_show');
		  } else {
			$header.removeClass('cs-gescout_show');
		  }
		}
  
		lastScrollTop = windowTop;
	  });
	}
  
	/*--------------------------------------------------------------
	  4. Dynamic Background
	--------------------------------------------------------------*/
	function dynamicBackground() {
	  $('[data-src]').each(function () {
		var src = $(this).attr('data-src');
		$(this).css({
		  'background-image': 'url(' + src + ')',
		});
	  });
	}
  
	
   //26.isotope
   $('.grid').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.grid-item',
			percentPosition: true,
			masonry: {
				columnWidth: '.grid-item',
			},
			
		});
		// filter items on button click
		$('.masonary-menu').on('click', 'button', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ 
				filter: filterValue,
				animationOptions: {
					duration: 100,
					easing: "linear",
					queue: true
				}
			});
			
		});
		//for menu active class
		$('.masonary-menu button').on('click', function (event) {
			$(this).siblings('.active').removeClass('active');
			$(this).addClass('active');
			event.preventDefault();
		});

	});	

	
  
	/*--------------------------------------------------------------
	  8. Review
	--------------------------------------------------------------*/
	function review() {
	  $('.cs_rating').each(function () {
		var review = $(this).data('rating');
		var reviewVal = review * 20 + '%';
		$(this).find('.cs_rating_percentage').css('width', reviewVal);
	  });
	}
  
	/*--------------------------------------------------------------
	  9. Modal Video
	--------------------------------------------------------------*/
	function modalVideo() {
	  if ($.exists('.cs_video_open')) {
		$('body').append(`
		  <div class="cs_video_popup">
			<div class="cs_video_popup-overlay"></div>
			<div class="cs_video_popup-content">
			  <div class="cs_video_popup-layer"></div>
			  <div class="cs_video_popup-container">
				<div class="cs_video_popup-align">
				  <div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="about:blank"></iframe>
				  </div>
				</div>
				<div class="cs_video_popup-close"></div>
			  </div>
			</div>
		  </div>
		`);
		$(document).on('click', '.cs_video_open', function (e) {
		  e.preventDefault();
		  var video = $(this).attr('href');
  
		  $('.cs_video_popup-container iframe').attr('src', `${video}`);
  
		  $('.cs_video_popup').addClass('active');
		});
		$('.cs_video_popup-close, .cs_video_popup-layer').on(
		  'click',
		  function (e) {
			$('.cs_video_popup').removeClass('active');
			$('html').removeClass('overflow-hidden');
			$('.cs_video_popup-container iframe').attr('src', 'about:blank');
			e.preventDefault();
		  },
		);
	  }
	}
  
	/*--------------------------------------------------------------
	  10. Tabs
	--------------------------------------------------------------*/
	function tabs() {
	  $('.cs_tabs .cs_tab_links a').on('click', function (e) {
		var currentAttrValue = $(this).attr('href');
		$('.cs_tabs ' + currentAttrValue)
		  .fadeIn(400)
		  .siblings()
		  .hide();
		$(this).parents('li').addClass('active').siblings().removeClass('active');
		e.preventDefault();
	  });
	}

	/*--------------------------------------------------------------
	  12. Counter Animation
	--------------------------------------------------------------*/
	function counterInit() {
	  if ($.exists('.odometer')) {
		$(window).on('scroll', function () {
		  function winScrollPosition() {
			var scrollPos = $(window).scrollTop(),
			  winHeight = $(window).height();
			var scrollPosition = Math.round(scrollPos + winHeight / 1.2);
			return scrollPosition;
		  }
  
		  $('.odometer').each(function () {
			var elemOffset = $(this).offset().top;
			if (elemOffset < winScrollPosition()) {
			  $(this).html($(this).data('count-to'));
			}
		  });
		});
	  }
	}
  
	/*--------------------------------------------------------------
	  13. Ripple
	--------------------------------------------------------------*/
	function rippleInit() {
	  if ($.exists('.cs_ripple_version')) {
		$('.cs_ripple_version').each(function () {
		  $('.cs_ripple_version').ripples({
			resolution: 512,
			dropRadius: 20,
			perturbance: 0.04,
		  });
		});
	  }
	}
  
	/*--------------------------------------------------------------
	  14. Progress Bar
	--------------------------------------------------------------*/
	function progressBar() {
	  $('.cs_progress').each(function () {
		var progressPercentage = $(this).data('progress') + '%';
		$(this).find('.cs_progress_in').css('width', progressPercentage);
	  });
	}

  })(jQuery); // End of use strict


 
