//= require ../_lib/baraja/js/jquery.baraja.js

;(function ( $ ) {
	'use strict';

	// ----------------------------
	// Add on to re-stack function
	// ----------------------------
	var _updateStack = $.Baraja.prototype._updateStack;
	$.Baraja.prototype._updateStack = function( $el, dir ) {

		_updateStack.apply(this,arguments);


		var cardNumber = ( $el.index() + 1),
			goToCard = (dir === 'next') ? cardNumber + 1 : cardNumber;

		if (goToCard > this.itemsCount) {
			goToCard = 1;
		}

		$( this.options.currentCard ).text( goToCard );
	};


	// ----------------------------
	// Override Navigate
	// ----------------------------
	$.Baraja.prototype._navigate = function( dir ) {

		this.closed = false;

		var self = this, 
			extra = 15,
			cond = dir === 'next' ? self.itemZIndexMin + self.itemsCount - 1 : self.itemZIndexMin,
			$item = this.$items.filter( function() {
				
				return Number( $( this ).css( 'z-index' ) ) === cond;

			} ),
			translation = dir !== 'next' ? $item.outerWidth( true ) + extra : $item.outerWidth( true ) * -1 - extra,
			cardStopPos = (dir === 'next') ? 0 : self.fanSettings.translation;


		if (typeof self.stackPositions === "undefined" || self.stackPositions.length < self.itemsCount)
		{
			var stackPositions = [];
			self.$items.each(function (i, card) {
				var stackIndex = Number( $( card ).css( 'z-index' ) ) - self.itemZIndexMin + 1;
				stackPositions[stackIndex] = $(card).css("transform");
			});

			self.stackPositions = stackPositions;
		}

		


		this._setTransition( $item, 'transform', this.options.speed, this.options.easing );

		this._applyTransition( $item, { transform : 'translate(' + translation + 'px)' }, function() {

			$item.off( self.transEndEventName );
			self._updateStack( $item, dir );

			// Restack siblings.
			$item.siblings().each(function (i, card) {
				var stackIndex = Number( $( card ).css( 'z-index' ) ) - self.itemZIndexMin + 1;
				$(card).css("transform", self.stackPositions[stackIndex]);
				self.isAnimating = true;
			});

			// Re-position top card.
			self._applyTransition( $item, { transform : 'translate(' + cardStopPos + 'px)' }, function() {
				$item.off( self.transEndEventName );
				self.isAnimating = false;
			} );

		} );
	};

	$( document ).ready(function() {
		if ( $( '.module-card-slider' ).length > 0 )
		{
			$( '.module-card-slider' ).each(function () {

				var $cardSlideshow = $(this).find('.card-slideshow'),
					$parent = $cardSlideshow.closest(".module-card-slider"),
					baraja = new $.Baraja({
						nextEl : $parent.find('.card-prev').get(0),
						prevEl : $parent.find('.card-next').get(0),
						currentCard : $parent.find('.card-current').get(0) // additional paramter used by override
					}, $cardSlideshow),
					settings = {
						speed : 500,
						easing : 'ease-out',
						range : 0,
						direction : 'right',
						origin : { x : 0, y : 0 },
						center : true,
						translation : ( baraja.itemsCount * -25 )
					};

				$parent.find(".card-slider-pager").show();

				baraja.fanSettings = settings;
				baraja.$el.off( 'click.baraja', 'li'); // unbind click event
			
				$parent.find(".card-current").text("1");
				$parent.find(".card-total").text( baraja.itemsCount );

				baraja.fan();
			});
		}
	});
})( jQuery );