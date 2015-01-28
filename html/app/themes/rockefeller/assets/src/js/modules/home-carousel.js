;(function ( $ ) {
	'use strict';

	$(document).ready(function () {

		if ( $('.topic-controller-carousel').length > 0 )
		{

			var $parent =  $('.topic-controller-carousel'),
				$prev = $parent.find(".carousel-prev .topic-content"),
				$next = $parent.find(".carousel-next .topic-content"),
				$pagers = $parent.find(".home-carousel-pager"),
				openTab = {
					width: $pagers.width(),
					borderWidth: 0
				},
				closeTab = {
					width: 0,
					borderWidth: 5
				};

			$pagers.each(function () {
				$(this).velocity(closeTab, 0);

				$(this).find(".arrow-prev").velocity({
					right: "-=5px"
				}, 0);
				$(this).find(".arrow-next").velocity({
					left: "-=5px"
				}, 0);
			});


			$parent.find(".topic-arrow").click(function (e) {
				e.preventDefault();

				var $pager = $(this).closest(".home-carousel-pager");

				if ( !$pager.hasClass("open") )
				{
					$pager.velocity(openTab, { 
					    complete: function(elements) {
					    	$(elements).addClass("open");
					    }
					}, 500);

					$pager.find(".arrow-prev").velocity({
						right: "+=5px"
					}, 500);
					$pager.find(".arrow-next").velocity({
						left: "+=5px"
					}, 500);
				}

				$parent.find(".home-carousel-pager.open").each(function () {
					$(this).removeClass("open").velocity(closeTab, 250);

					$(this).find(".arrow-prev").velocity({
						right: "-=5px"
					}, 250);
					$(this).find(".arrow-next").velocity({
						left: "-=5px"
					}, 250);
				});

			});

			$('.topic-controller-carousel').slick({
				dots: false,
				infinite: false,
				speed: 700,
				slidesToShow: 1,
				slidesToScroll: 1,
				centerMode: false,
				prevArrow: $prev,
				nextArrow: $next,
				draggable: false,
				asNavFor: '.topic-content-carousel'
			});


			$('.topic-content-carousel').slick({
				dots: false,
				infinite: false,
				speed: 700,
				slidesToShow: 1,
				slidesToScroll: 1,
				draggable: false,
				centerMode: false,
				onBeforeChange: function (slick, currentSlide, targetSlide) {

					$(".topic-content-wrapper").find(".fadein-block").each(function(i, el) {
						var $el = $(el);
						if ( !$el.visible(true) ) {
							$el.velocity({ opacity: 0, translateY: 150 }, 0);
							$el.attr("data-offset", (100 * $el.index()) );
						} 
					});
				}
			});

		}
	});

})( jQuery );