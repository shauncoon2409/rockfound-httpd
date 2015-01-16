(function($) {
	'use strict';
  /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */

  $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top + 85,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);


;(function ( $ ) {
	'use strict';

	// Fade-in as scroll.
	var gridBlocks = $(".fadein-block");

	gridBlocks.each(function(i, el) {
		var $el = $(el);
		if ( !$el.visible(true) ) {
			$el.velocity({ opacity: 0, translateY: 150 }, 0);
			$el.attr("data-offset", (100 * $el.index()) );
		} 
	});

	$(window).scroll(function(event) {
		gridBlocks.each(function(i, el) {
			var $el = $(el);
			
			if ($el.visible(true) && !$el.hasClass("animating") ) {
				var offset = (typeof $el.data("offset") !== "undefined") ? $el.data("offset") : 0;

				$el.velocity(
					{ opacity: 1, translateY: 0 },
					{ 
						easing: "linear",
						duration: 500, 
						delay: 50 + offset,
						begin: function(element) { 
							 $(element).addClass("animating");
						},
						complete: function(element) { 
							 $(element).removeClass("animating");
						}
					}
				);
			}
		});
	});


	// More-block animation
	$(".more-block .extra-text").velocity("fadeOut", { duration: 0});
	$(".more-block").hover(
		function () {
			$(this).find(".extra-text").velocity("fadeIn", { duration: 350 });
			$(this).find(".icon-angle-down").velocity({ top: 20 }, 350);
		},
		function () {
			$(this).find(".extra-text").velocity("reverse");
			$(this).find(".icon-angle-down").velocity("reverse");
		}
	);

	// Image Hover animation
	$(".module-grid a, .quarter-image, .half-image, .hover-image").hover(
		function () {
			$(this).find(".sub-image").velocity({ scale: "+=15%", opacity: 0.7 }, 250);
		},
		function () {
			$(this).find(".sub-image").velocity("reverse");
		}
	);


	// Topic blocks
	$(".grid-6-3 .tb-info").velocity({height: 15 }, 0);
	$(".grid-6-3 .tb-info span").velocity({opacity : 0}, 0);
	$(".grid-6-3 .tb-content").velocity({ bottom: '4em'}, 0);

	$(".grid-6-3 .topic-block").hover(
		function () {
			$(this).find(".tb-content").velocity({ bottom: '2.5em'}, 500);
			$(this).find(".tb-info").velocity({ height: 70 }, 500);
			$(this).find(".tb-info span").velocity({ opacity : 1 }, 700);
		},
		function () {
			$(this).find(".tb-content").velocity({ bottom: '4em'}, 500);
			$(this).find(".tb-info").velocity({ height: 15 }, 500);
			$(this).find(".tb-info span").velocity({ opacity : 0 }, 700);
		}
	);

})( jQuery );