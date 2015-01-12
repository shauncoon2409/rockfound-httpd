;(function ( $ ) {
	'use strict';

	$(document).ready(function () {

		if ( $('.coupled-module').length > 0 )
		{
			var $parent =  $('.coupled-module'),
				$prev = $parent.find(".cm-prev"),
				$next = $parent.find(".cm-next"),
				$current = $parent.find(".coupled-module-pager .current"),
				$total = $parent.find(".coupled-module-pager .total");

			$('.coupled-module-content').slick({
				dots: false,
				infinite: false,
				speed: 700,
				slidesToShow: 1,
				slidesToScroll: 1,
				centerMode: false,
				prevArrow: $prev,
				nextArrow: $next,
				slide: '.cm-full-set',
				onInit: function (slick) {
					$total.text(slick.slideCount);
					$current.text("1");
				},
				onBeforeChange: function (slick) {
					$(".dig-deeper .module-grid").velocity("slideUp", 0);
				},
				onAfterChange: function (slick) {
					$current.text(slick.currentSlide + 1);
				}
			});


			// Pager "extra" text effect
			// ----------------------
			$(".cm-next .extra").velocity({width:0, opacity: 0}, 0);
			$(".cm-next").hover(
				function () {
					$(this).find(".extra").velocity({ width: '70px', opacity: 1}, 400);
				},
				function () {
					$(this).find(".extra").velocity("reverse");
				}
			);


			// Read more toggle
			// ----------------------
			$(".cm-response .content-wrap").each(function () {
				$(this).children().slice(1).hide();
			});

			$(".cm-response .read-more").click(function () {
				var $extraText = $(this).closest(".response-content").find(".content-wrap").children().slice(1);

				if (!$(this).hasClass("open"))
				{
					$extraText.velocity("fadeIn", { 
						duration: 350 
					});
					$(this).addClass("open").text("Show Less");
				}
				else {
					$extraText.hide();
					$(this).html("Read More &raquo;").removeClass('open');
				}
			});


			// Dig deeper module
			// ----------------------
			$(".dig-deeper .module-grid").velocity("slideUp", 0);
			$(".dig-deeper .more-block").click(function () {
				var $gridA = $(this).closest(".dig-deeper").find(".module-grid");

				$gridA.velocity("slideDown", 750);
			});
		}
	});

})( jQuery );