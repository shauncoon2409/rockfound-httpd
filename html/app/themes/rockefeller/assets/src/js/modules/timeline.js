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
				_self.$navBox = _self.$wrapper.find(".timeline-nav");
				_self.$nav = _self.$wrapper.find(".timeline-nav > ul");
				_self.$activeMarker = _self.$wrapper.find(".active-marker");
				_self.$dateHeader = _self.$wrapper.find(".date-subhead");
				_self.markerH = _self.$nav.find(".marker a").outerHeight(true);
				_self.activeMarkerOffset = (_self.$activeMarker.height() / 2);
				_self.navSpacer = (_self.markerH * 4);
				_self.navBaseOffset = _self.$wrapper.find('.timeline-nav-wrapper').offset().top;
				_self.autoScrolling = false;

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
				_self.$activeMarker.velocity({top : (_self.activeMarkerOffset * -1) }, 0).text( $active.data("day") );
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
					_self.scrollToEvent( $(this).attr("href") );
				});
			},


			updateNav: function ($activeItem) {
				var _self = this,
					$parent = $activeItem.closest("li"),
					itemOffset = $parent.position().top,
					navOffset = (itemOffset * -1) + _self.navSpacer;

				navOffset = (navOffset > 0) ? 0 : navOffset;

				$parent.addClass("active").siblings().removeClass("active");

				_self.$activeMarker
					.text( $activeItem.text() )
					.velocity("stop")
					.velocity({
						top: ( itemOffset - _self.activeMarkerOffset)
					}, {
						duration: 250
					});

				_self.$navBox
					.velocity({
						top : navOffset
					},
					{
						easing: "linear",
						duration: 750,
						queue: false
					});
			},

			updateActive: function ($_event) {
				var _self = this,
					id = "#" + $_event.attr("id"),
					$_eventMarker = _self.$nav.find('a[href="' + id + '"]');

				_self.$dateHeader.text( $_event.data("yearmonth") );
				_self.updateNav($_eventMarker);

				$_event.siblings().removeClass("active");
				$_event.addClass("active");
				
				$_event.find( _self.settings.imageClass )
					.velocity("stop")
					.velocity({
						height: 320,
						width: 320,
						"margin-top": "-160px",
						easing: "linear"
					}, 500);
				$_event.siblings().find( _self.settings.imageClass )
					.velocity("stop")
					.velocity({
						height: 230,
						width: 230,
						"margin-top": "-115px",
						easing: "linear"
					}, 250);
			},


			scrollToEvent: function (id) {
				var _self = this;

				$(id).velocity("scroll", {
					container: _self.$timeline,
					duration: 500,
					offset: -100,
					begin: function () {
						_self.autoScrolling = true;
					},
					complete: function () {
						_self.autoScrolling = false;
					}
				});
			},

			scrollSetup : function () {
				var _self = this;

				_self.$timeline.scroll(function() {
					if (!_self.autoScrolling)
					{
						_self.$tevents.each(function () {
							var $_event = $(this),
								position = ($_event.offset().top - _self.navBaseOffset);

							if ( $_event.is(":visible") && !$_event.hasClass("active") && position <= 250 && position >= 0)
							{
								_self.updateActive($_event);
								return false;
							}
						});
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
		var timelines =  $('.timeline-container');

		timelines.each(function () {
			$(this).timelineModule();
		});
	});

})( jQuery, window, document );