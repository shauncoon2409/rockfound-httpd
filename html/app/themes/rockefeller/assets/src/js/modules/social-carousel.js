;(function ( $ ) {
	'use strict';

	$(document).ready(function () {

		var socialCarousels =  $('.social-carousel-container');

		if ( socialCarousels.length > 0 )
		{
			socialCarousels.each(function () {

				var $parent =  $(this).closest(".module-social-carousel");

				$(this).slick({
					dots: false,
					infinite: false,
					speed: 700,
					slidesToShow: 1,
					slidesToScroll: 3,
					centerMode: false,
					variableWidth: true,
					cssEase: 'linear',
					arrows: true,
					appendArrows: $parent.find(".social-carousel-pager"),
					prevArrow: '<span class="icon icon-angle-left prev"></span>',
					nextArrow: '<span class="icon icon-angle-right next"></span>',
					responsive: [
						{
							breakpoint: 900,
							settings: {
								slidesToScroll: 2,
								speed: 500
							}
						},
						{
							breakpoint: 600,
							settings: {
								slidesToScroll: 1,
								speed: 300
							}
						}
					]
				});

			});
		}
	});

})( jQuery );