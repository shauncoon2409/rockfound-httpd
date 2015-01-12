// http://gabrieleromanato.name/jquery-check-if-users-stop-scrolling/
// http://stackoverflow.com/questions/9144560/jquery-scroll-detect-when-user-stops-scrolling
;(function( $ ) {
	'use strict';

	$.fn.stopScroll = function( options ) {
		options = $.extend({
			delay: 250,
			callback: function() {}
		}, options);
		
		return this.each(function() {
			var $element = $( this ),
				element = this;
			$element.scroll(function() {
				clearTimeout( $.data( element, "scrollCheck" ) );
				$.data( element, "scrollCheck", setTimeout(function() {
					options.callback();
				}, options.delay ) );
			});
		});
	};

})( jQuery );


;(function ( $, window, document, undefined ) {
	'use strict';

	// Create the defaults once
	var pluginName = "timelineModule",
		defaults = {
			imageClass : '.image-block'
		};

	// The actual plugin constructor
	function Plugin ( element, options ) {
		this.element = element;
		this.settings = $.extend( {}, defaults, options );
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(Plugin.prototype, {
			init: function () {
				var _self = this;

				// Navigation variables.
				_self.$timeline = $(_self.element);
				_self.$tevents = _self.$timeline.find(".timeline-event");
				_self.$wrapper = _self.$timeline.closest(".module-timeline");

				// Navigation variables.
				_self.$nav = _self.$wrapper.find(".timeline-nav");
				_self.$activeMarker = _self.$wrapper.find(".active-marker");
				_self.$dateHeader = _self.$wrapper.find(".date-subhead");
				_self.markerH = _self.$nav.find(".marker a").outerHeight(true);
				_self.activeMarkerOffset = (_self.$wrapper.find('.timeline-nav-wrapper').position().top + (_self.$activeMarker.height() / 2));
				_self.navSpacer = (_self.markerH * 4);

				_self.setupNav();
				_self.addFilters();
				_self.scrollSetup();

				/*
				if ( window.location.hash )
				{
					_self.updateActive( $( (window.location.hash).replace('event-','') ) );
				}
				*/
			},

			addFilters: function () {
				var _self = this;

				_self.$wrapper.find(".filter").click(function () {
					var filterClass = $(this).data("filter"),
						$items = _self.$tevents,
						$markers = _self.$nav.find(".marker"),
						$active = _self.$timeline.find(".active");

					$(this).addClass("active").siblings().removeClass("active");

					$items.velocity("fadeOut", 0);
					$markers.velocity("fadeOut", 0);

					if (filterClass !== "all")
					{
						$items = _self.$timeline.find( filterClass );
						$markers = _self.$nav.find( filterClass );
					}

					$items.velocity("fadeIn", {
						complete: function () {
							if ( !$active.is(":visible") )
							{
								if ( $active.prev(":visible").length > 0 )
								{
									_self.updateActive( $active.prev(":visible") );
								}
								else if ( $active.next(":visible").length > 0 )
								{
									_self.updateActive( $active.next(":visible") );
								}
							}
						}
					});
					$markers.velocity("fadeIn");
				});

			},

			setupNav: function () {
				var _self = this,
					$active = _self.$timeline.find(".active");

				// Set initial data.
				_self.$activeMarker.velocity({top : Math.floor(_self.markerH / 2) }, 0).text( $active.data("day") );
				_self.$dateHeader.text( $active.data("yearmonth") );

				// Nuke dummy nav content
				_self.$nav.html('');

				// Populate list.
				_self.$tevents.each(function (i, marker) {
					_self.$nav.append( 
						$("<li>" ).addClass("marker " + $(this).data("type")).append( 
							$("<a>").attr( "href", "#" + $(this).attr("id") ).html("<span>" + $(this).data("day") + "</span>" )
						)
					);
				});

				// Add behavior
				_self.$nav.find(".marker a").click(function (e) {
					e.preventDefault();
					_self.updateActive( $( $(this).attr("href") ) );
				});
			},


			updateNav: function ($activeItem) {
				var _self = this,
					$parent = $activeItem.closest("li"),
					index = $parent.siblings(":visible").addBack().index($parent),
					itemOffset = $parent.position().top,
					navOffset = (itemOffset * -1) + _self.navSpacer;

				// if back at top.
				navOffset = (navOffset < 0) ? navOffset : Math.floor(_self.markerH / 2);

				$parent.addClass("active").siblings().removeClass("active");

				_self.$nav.velocity({
					top : navOffset
				},
				{
					easing: "linear",
					duration: 750,
					queue: false,
					complete : function () {
						var position = ($parent.offset().top - _self.activeMarkerOffset);

						position = (position > 0) ? position : 0;

						_self.$activeMarker
							.text( $activeItem.text() )
							.velocity({top: position }, {duration: 250, queue: false});
					}
				});
			},

			updateActive: function ($_event) {
				var _self = this,
					id = "#" + $_event.attr("id"),
					$_eventMarker = _self.$nav.find('a[href="' + id + '"]');

				_self.$dateHeader.text( $_event.data("yearmonth") );
				_self.updateNav($_eventMarker);

				$(id).velocity("scroll", {
						container: _self.$timeline,
						duration: 500,
						offset: -100,
						begin: function () {
						},
						complete: function () {
							$_event.siblings().removeClass("active");
							$_event.addClass("active");
							
							$_event.find( _self.settings.imageClass ).velocity({
								height: 320,
								width: 320,
								"margin-top": "-160px",
								easing: "linear"
							}, 500);
							$_event.siblings().find( _self.settings.imageClass ).velocity({
								height: 230,
								width: 230,
								"margin-top": "-115px",
								easing: "linear"
							}, 500);

							// window.location.hash = 'event-' + $_event.attr("id");

							_self.scollCount = 0;
						}
					}
				);
			},

			scrollSetup : function () {
				var _self = this;

				_self.scollCount = 0;

				_self.$timeline.stopScroll({
					callback: function (e) {
						if ( _self.scollCount === 0 )
						{
							_self.$tevents.each(function () {
								var $_event = $(this),
									position = $_event.offset().top;

								if ( $_event.is(":visible") && !$_event.hasClass("active") && position <= 250 && position >= 0)
								{
									_self.updateActive($_event);
									_self.scollCount++;
									return false;
								}
							});
						}
					}
				});
			}
	});

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[ pluginName ] = function ( options ) {
		this.each(function() {
			if ( !$.data( this, pluginName ) ) {
				$.data( this, pluginName, new Plugin( this, options ) );
			}
		});
		return this;
	};


	// Instatiate.
	$(document).ready(function () {
		$('.timeline-container').timelineModule();
	});

})( jQuery, window, document );