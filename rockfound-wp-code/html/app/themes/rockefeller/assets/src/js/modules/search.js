;(function ( $ ) {
	'use strict';

	$('.module-search .chosen-box').chosen({
		disable_search_threshold: 30,
		width: "auto"
	});

	$('.search-filter .sub-filter-panel').velocity("slideUp");

	$('.search-filter > a').click(function () {
		var $parent = $(this).closest('.search-filter');

		$parent.siblings(".open").removeClass("open").find('.sub-filter-panel').velocity("slideUp");

		if (!$parent.hasClass("open"))
		{
			$parent.addClass("open").find('.sub-filter-panel').velocity("slideDown");
		}
		else
		{
			$parent.removeClass("open").find('.sub-filter-panel').velocity("slideUp");
		}
	});

	$('.search-filter .sub-list a').click(function (){
		$(this).closest('.search-wrapper-content').find('.active').removeClass('active');
		$(this).closest('li').addClass('active');
	});

})( jQuery );