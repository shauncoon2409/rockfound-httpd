;(function ( $ ) {
	'use strict';

	$(document).ready(function () {

		$('.grant-select-menu').chosen({
			disable_search_threshold: 30,
			width: "100%",
			inherit_select_classes: true
		}).change(function () {
			var $selected = $( $(this).val() );

			$selected.siblings(".grant-info-block").velocity("fadeOut", 0);
			$selected.velocity("fadeIn");
		});

	});

})( jQuery );