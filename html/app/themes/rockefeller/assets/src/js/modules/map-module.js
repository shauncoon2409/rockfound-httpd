;(function ( $, window, document, undefined ) {
	'use strict';

	// Create the defaults once
	var pluginName = "mapModule",
		defaults = {
			infoSelector : '.region-map-data',
			baseColor : '#b2b2aa',
			hoverColor : '#4d4f53',
			activeColor : '#eeeee3',
			regions : {
				northernAfrica : "Northern Africa",
				westernAfrica : "Western Africa",
				easternAfrica : "Eastern Africa",
				middleAfrica : "Middle Africa",
				southernAfrica : "Southern Africa",

				centralAsia : "Central Asia",
				southEasternAsia : "South-Eastern Asia",
				easternAsia : "Eastern Asia",
				southernAsia : "Southern Asia",
				westernAsia : "Western Asia",

				carribean : "Carribean",

				centralAmerica : "Central America",
				northAmerica : "North America",
				southAmerica : "South America",


				southernEurope : "Southern Europe",
				northernEurope : "Northern Europe",
				easternEurope : "Eastern Europe",
				westernEurope : "Western Europe",

				oceana : "Oceana",
			}
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
				this.buildMap();
				this.buildSelector();
				
				var $infoBlocks = $( this.settings.infoSelector ).find(".region-info").hide();

				$infoBlocks.each( function ( ) {
					var dataUrl = $(this).data("info-url"),
						$block = $(this);

					$.get( dataUrl, function( data ) {
						$block.html( data );
						$block.find('.timeline-container').timelineModule();
					});
				});
			},

			buildMap: function () {
				var _self = this;
				
				_self.mapArea = new Snap("#regionsMap").attr({
					"width": "100%",
					"height": "100%",
					"viewBox": "0 0 1200 694"
				});

				Snap.load($(this.element).data('map-path'), function (map) {

					var regions = map.selectAll("g"),
						areas = map.selectAll("g *");
						_self.baseStyle = {
							fill: _self.settings.baseColor,
							strokeWidth: 1,
							stroke: '#000'
						};
						_self.activeStyle = {
							fill: _self.settings.activeColor
						};
						_self.hoverStyle = {
							fill: _self.settings.hoverColor
						};


					areas.forEach(function (area, i) {
						area
							.addClass("area")
							.attr(_self.baseStyle);
					});


					regions.forEach(function (region, i) {

						region.addClass("region");

						region.click(function (e) {							
							_self.setActiveRegion( this.attr("id") );
						});

						region.hover(
							function () {
								region.selectAll('.area').attr(_self.hoverStyle);
							},
							function () {
								region.selectAll('.area').attr(_self.baseStyle);
								region.selectAll('.active .area').attr(_self.activeStyle);
							}
						);
					});

					_self.map = map;
					_self.mapArea.append( map );

				});
			},

			buildSelector: function () {
				var _self = this;

				$("#region-selector").append("<select>");
				_self.selector = $("#region-selector").find("select");

				$.each(this.settings.regions, function(key, name){
					_self.selector.append( $("<option>").val(key).text(name) );
				});

				_self.selector.chosen({
					disable_search_threshold: 10,
					width: "auto"
				});

				_self.selector.change(function (){
					_self.setActiveRegion( $(this).val() );
				});
			},

			setActiveRegion: function (regionName) {
				var _self = this,
					areas = _self.mapArea.selectAll(".area"),
					regions = _self.mapArea.selectAll(".region"),
					regionId = "#" + regionName,
					active = _self.mapArea.select( regionId );

					_self.selector.val( regionName );
					_self.selector.trigger("chosen:updated");

					areas.attr(_self.baseStyle);
					
					regions.forEach(function (region, i) {
						region.removeClass("active");
					});

					if (active !== null)
					{
						active.addClass('active');
						active.selectAll('*').attr(_self.activeStyle);
					}

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
		$( '.module-regions-map' ).mapModule();
	});

})( jQuery, window, document );