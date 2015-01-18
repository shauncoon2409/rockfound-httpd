;(function ( $ ) {
	'use strict';

	var $navbox = $('#rock-navbox'),
		$contentPane = $navbox.find(".expanded-nav"),
		$navLink = $navbox.find(".core-nav > li > a");


		// Open Panel Content
		$navLink.on("mouseenter", function () {		
			$navLink.removeClass("active");
			$(this).addClass("active");

			if (! $contentPane.hasClass( "open" ) )
			{
				$contentPane.find(".inner-content").html( $(this).siblings('.expanded-nav-content').html() );
				$contentPane.addClass("open").velocity("slideDown", { duration: 0 });
			}
			else
			{
				$contentPane.find(".inner-content")
					.hide()
					.html( $(this).siblings('.expanded-nav-content').html() )
					.velocity("fadeIn", { duration: 0, queue: false });
			}
		});


		// Close Panel Content
		function closeNavBox() {
			$('#rock-navbox').find( ".expanded-nav.open" ).velocity("slideUp", { duration: 0 }).removeClass("open");
			$navLink.removeClass("active");
		}
		$navbox.find(".core-nav").on("mouseleave", function () {
			closeNavBox();
		});
		$navbox.on("click", ".close-button", function () {
			closeNavBox();
		});


		// Change inner panel content.
		$navbox.on("mouseenter", ".subnav a", function () {
			var paneId	= $(this).data("content-pane"),
				$pane = $(paneId),
				carousel = $pane.find('.nav-featured-carousel');

			$(this).addClass("active").parent().siblings().find(".active").removeClass("active");

			if (! $pane.hasClass("active") )
			{
				$pane.siblings(".nav-tertiary-content").removeClass("active").hide();
				$pane.addClass("active").velocity("fadeIn", { 
					duration: 0, 
					display: "block", 
					queue: false,
					complete: function () {
						carousel.slick({
							dots: false,
							infinite: false,
							speed: 500,
							slidesToShow: 1,
							slidesToScroll: 1,
							cssEase: 'linear',
							arrows: true,
							appendArrows: carousel.closest(".nav-tertiary-content"),
							prevArrow: '<span class="icon icon-angle-left prev"></span>',
							nextArrow: '<span class="icon icon-angle-right next"></span>',
						});
					}
				});

			}
		});
})( jQuery );