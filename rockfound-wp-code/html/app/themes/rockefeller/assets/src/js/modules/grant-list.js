;(function ( $ ) {
	'use strict';

	$(document).ready(function () {

		$("[data-sort='date:desc']").hide();

		$(".sort").click(function () {
			$(this).hide();
			$(this).siblings(".sort").velocity("fadeIn", { duration: 350 });
		});

		$('#grant-list-block').mixItUp({
			load: {
				sort: 'date:desc'
			}
		});
	});

})( jQuery );