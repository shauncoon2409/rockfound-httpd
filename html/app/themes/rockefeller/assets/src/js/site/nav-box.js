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
			setActive();
		}
		$navbox.find(".core-nav").on("mouseleave", function () {
			closeNavBox();
		});
		$navbox.on("click", ".close-button", function () {
			closeNavBox();
		});


		// Change inner panel content.
		$navbox.on("mouseenter", ".sub-items a", function () {
			var paneId	= $(this).data("content-pane");

			$(this).addClass("active").parent().siblings().find(".active").removeClass("active");

			if (! $(paneId).hasClass("active") )
			{
				$(paneId).siblings(".nav-sub-pane").removeClass("active").hide();
				$(paneId).addClass("active").velocity("fadeIn", { duration: 0, display: "table-cell", queue: false });
			}
		});


		setActive();

		// Temporarily set Active Item.
		function setActive()
		{
			if ( (document.URL).indexOf("our-work") > -1 )
			{
				$navbox.find(".our-work-item").addClass("active");
			}
		}
})( jQuery );