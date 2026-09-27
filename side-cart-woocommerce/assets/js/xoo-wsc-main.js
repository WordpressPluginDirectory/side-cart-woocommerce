jQuery(document).ready(function($){

	var isCartPage 		= xoo_wsc_params.isCart == '1',
		isCheckoutPage 	= xoo_wsc_params.isCheckout == '1';

	var get_wcurl = function( endpoint ) {
		return xoo_wsc_params.wc_ajax_url.toString().replace(
			'%%endpoint%%',
			endpoint
		);
	};


	var markupTimeout = null;

	var Notice = {

		timeout: null,

		markupTimeout: null,

		$cartNoticeCont: function(){
			return $('.xoo-wsc-markup').find('.xoo-wsc-notice-container');
		},

		$markupNoticeCont: function(){
			return $('.xoo-wsc-markup-notices')
		},

		add: function( notice, type = 'success', clearPrevious = true ){

			if( clearPrevious ){
				Notice.$cartNoticeCont().html('');
			}

			var noticeHTML = type === 'success' ? xoo_wsc_params.html.successNotice.toString().replace( '%s%', notice ) : xoo_wsc_params.html.errorNotice.toString().replace( '%s%', notice );

			Notice.$cartNoticeCont().html( noticeHTML );

		},


		setHTML: function(noticeHTML){
			Notice.$cartNoticeCont().add( Notice.$markupNoticeCont() ).html(noticeHTML);
		},

		showNotification: function(){

			if( !cart.isOpen() ){
				Notice.showMarkupNotice();
				return;
			}

			Notice.$cartNoticeCont().slideDown();
			
			clearTimeout(Notice.timeout);

			Notice.timeout = setTimeout(function(){
				Notice.$cartNoticeCont().slideUp('slow');
			}, xoo_wsc_params.notificationTime );

		},


		hideNotification: function(){
			Notice.$cartNoticeCont().hide();
		},

		hideMarkupNotice: function(){
			Notice.$markupNoticeCont().removeClass('xoo-wsc-active');
		},


		showMarkupNotice: function(){

			var $markupNotice = Notice.$markupNoticeCont();

			var $noticeCont = $markupNotice.find('.xoo-wsc-notice-container .xoo-wsc-notices');

			if( !$noticeCont.length || $noticeCont.children().length === 0 ) return;

			setTimeout(function(){$markupNotice.addClass('xoo-wsc-active')},10);
			
			clearTimeout(Notice.markupTimeout);

			Notice.markupTimeout = setTimeout(function(){
				$markupNotice.removeClass('xoo-wsc-active');
			},xoo_wsc_params.notificationTime )
		}
	}

	class Container{

		constructor( $modal, container ){
			this.$modal 	= $modal;
			this.container 	= container || 'cart';
		}

		isOpen(){
			return this.$modal.hasClass('xoo-wsc-'+this.container+'-active');
		}

		eventHandlers(){
			$(document.body).on( 'wc_fragments_loaded updated_checkout', this.onCartUpdate.bind(this) );
		}

		onCartUpdate(){
			this.unblock();
			Notice.showNotification();
		}

		setAjaxData( data, noticeSection ){

			var ajaxData = {
				container: this.container,
				noticeSection: noticeSection || this.noticeSection || this.container,
				isCheckout: isCheckoutPage,
				isCart: isCartPage
			}


			if( typeof data === 'object' ){

				$.extend( ajaxData, data );

			}
			else{

				var serializedData = data;

				$.each( ajaxData, function( key, value ){
					serializedData += ( '&'+key+'='+value );
				} )
		
				ajaxData = serializedData;

			}

			return ajaxData;
		}


		toggle( type ){

			var $activeEls 	= this.$modal.add( 'body' ).add('html'),
				activeClass = 'xoo-wsc-'+ this.container +'-active';

			if( type === 'show' ){
				$activeEls.addClass(activeClass);
			}
			else if( type === 'hide' ){
				$activeEls.removeClass(activeClass);
			}
			else{
				$activeEls.toggleClass(activeClass);
			}

			$(document.body).trigger( 'xoo_wsc_' + this.container + '_toggled', [ type ] );

			Notice.hideNotification();

		}


		block(){
			this.$modal.addClass('xoo-wsc-loading');
		}

		unblock(){
			this.$modal.removeClass('xoo-wsc-loading');
		}


		refreshMyFragments(){

			if( xoo_wsc_params.refreshCart === "yes" && typeof wc_cart_fragments_params !== 'undefined' ){
				$( document.body ).trigger( 'wc_fragment_refresh' );
				return;
			}

			this.block();

			$.ajax({
				url: get_wcurl( 'xoo_wsc_refresh_fragments' ),
				type: 'POST',
				context: this,
				data: {},
				success: function( response ){
					this.updateFragments(response);
				},
				complete: function(){
					this.unblock();
				}
			})

		}


		updateCartCheckoutPage(){

			//Refresh checkout page
			if( isCheckoutPage ){
				if( $( 'form.checkout' ).length === 0 ){
					location.reload();
					return;
				}
				$(document.body).trigger("update_checkout");
			}

			//Refresh Cart page
			if( isCartPage ){
				$(document.body).trigger("wc_update_cart");
			}

		}

		updateFragments( response ){

			if( response.fragments ){

				$( document.body ).trigger( 'xoo_wsc_before_loading_fragments', [ response ] );

				this.block();

				//Set fragments
		   		$.each( response.fragments, function( key, value ) {
					$( key ).replaceWith( value );
				});

		   		if( typeof wc_cart_fragments_params !== 'undefined' && ( 'sessionStorage' in window && window.sessionStorage !== null ) ){

		   			sessionStorage.setItem( wc_cart_fragments_params.fragment_name, JSON.stringify( response.fragments ) );
					localStorage.setItem( wc_cart_fragments_params.cart_hash_key, response.cart_hash );
					sessionStorage.setItem( wc_cart_fragments_params.cart_hash_key, response.cart_hash );

					if ( response.cart_hash ) {
						sessionStorage.setItem( 'wc_cart_created', ( new Date() ).getTime() );
					}

				}

				$( document.body ).trigger( 'wc_fragments_loaded' );

				this.unblock();

			}

			if( xoo_wsc_params.refreshCart === "yes" && typeof wc_cart_fragments_params !== 'undefined' ){
				this.block();
				$( document.body ).trigger( 'wc_fragment_refresh' );
				return;
			}

		}

	}


	class Cart extends Container{

		static isWCAjaxAddToCart = false;

		constructor( $modal ){

			super( $modal, 'cart' );

			this.cartLoaded 			= false;
			this.blockAddedToCartCalled = false;
			this.baseQty 				= 1;
			this.qtyUpdateDelay 		= null;

			this.refreshFragmentsOnPageLoad();
			this.eventHandlers();

		}


		refreshFragmentsOnPageLoad(){
			if( xoo_wsc_params.fetchCart === 'page_load' ){
				setTimeout(function(){
					this.refreshMyFragments();
				}.bind(this), xoo_wsc_params.fetchDelay )
			}
		}

		eventHandlers(){

			super.eventHandlers();

			this.$modal.on( 'click', '.xoo-wsc-chng', this.toggleQty.bind(this) );
			this.$modal.on( 'change', '.xoo-wsc-qty', this.changeInputQty.bind(this) );
			this.$modal.on( 'click', '.xoo-wsc-smr-del', this.deleteIconClick.bind(this) );
			this.$modal.on( 'click', '.xoo-wsch-close, .xoo-wsc-opac, .xoo-wsc-cart-close', this.closeCartOnClick.bind(this) );
			this.$modal.on( 'click', '.xoo-wsc-basket', this.toggleCart.bind(this) );

			$(document.body).on( 'xoo_wsc_cart_updated', this.updateCartCheckoutPage.bind(this) );
			$(document.body).on( 'click', 'a.added_to_cart, .xoo-wsc-cart-trigger', this.openCart.bind(this) );
			$(document.body).on( 'added_to_cart', this.addedToCart.bind(this) );

			$(document.body).on( 'wc-blocks_added_to_cart', this.blockAddedToCart.bind(this) );

			$(document.body).on( 'adding_to_cart', this.checkIfWCAjaxAddToCart.bind(this) );

			if( xoo_wsc_params.autoOpenCart === 'yes' && xoo_wsc_params.addedToCart === 'yes'){
				this.openCart();
			}

			if( xoo_wsc_params.ajaxAddToCart === 'yes' ){
				$(document.body).on( 'submit', 'form.cart', this.addToCartFormSubmit.bind(this) );
			}

			if( typeof wc_cart_fragments_params === 'undefined' ){
				$( window ).on( 'pageshow' , this.onPageShow.bind(this) );
			}

			if( xoo_wsc_params.triggerClass ){
				$(document.body).on( 'click', '.'+xoo_wsc_params.triggerClass, this.openCart.bind(this) );
			}


			if( isCheckoutPage || isCartPage ){
				$(document.body).on( 'updated_shipping_method', this.refreshMyFragments.bind(this) );
			}

			this.initMasonryLayout();

		}

		toggleQty(e){

			var $toggler 	= $(e.currentTarget),
				$input 		= $toggler.siblings('.xoo-wsc-qty');

			if( !$input.length ) return;

			var baseQty = this.baseQty = parseFloat( $input.val() ),
				step 	= parseFloat( $input.attr('step') ),
				action 	= $toggler.hasClass( 'xoo-wsc-plus' ) ? 'add' : 'less',
				newQty 	= action === 'add' ? baseQty + step : baseQty - step;

			
			$input.val(newQty).trigger('change');

		}

		changeInputQty(e){

			Notice.hideNotification();

			var $_this	= this,
 				$input 	= $(e.currentTarget),
				newQty 	= parseFloat( $input.val() ),
				step 	= parseFloat( $input.attr('step') ),
				min 	= parseFloat( $input.attr('min') ),
				max 	= parseFloat( $input.attr('max') ),
				invalid = false,
				message = false;

			//Validation
			
			if( isNaN( newQty )  || newQty < 0 || newQty < min  ){
				invalid = true;
			}
			else if( newQty > max ){
				invalid = true;
				message = xoo_wsc_params.strings.maxQtyError.replace( '%s%', max );
			}
			else if( !Number.isInteger(newQty/step ) ){
				invalid = true;
				message = xoo_wsc_params.strings.stepQtyError.replace( '%s%', step );
			}
			
			//Set back to default quantity
			if( invalid ){
				$input.val( this.baseQty );
				if( message ){
					Notice.add( message, 'error' );
					Notice.showNotification();
				}
				return;
			}

			//Update
			$input.val( newQty );

			clearTimeout( this.qtyUpdateDelay );

			this.qtyUpdateDelay = setTimeout(function(){
				$_this.updateItemQty( $input.parents('.xoo-wsc-product').data('key'), newQty )
			}, xoo_wsc_params.qtyUpdateDelay );
			
			
		}

		updateItemQty( cart_key, qty ){

			if( !cart_key || qty === undefined ) return;

			this.block();
			
			this.saveScrollPosition();

			var formData = {
				cart_key: cart_key,
				qty: qty
			}

			$.ajax({
				url: get_wcurl( 'xoo_wsc_update_item_quantity' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData),
				success: function(response){
					this.updateFragments( response );
					$(document.body).trigger( 'xoo_wsc_quantity_updated', [response] );
					$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );
					this.setScrollPosition();
					this.unblock();
				}

			})
		}

		checkIfWCAjaxAddToCart(e, $button, data){

			Cart.isWCAjaxAddToCart = true;

			if( ( !(data instanceof FormData) || !data.has('action') || !data.get('action') === 'xoo_wsc_add_to_cart' ) && ( $button.length && $button.hasClass('ajax_add_to_cart') ) ){
				this.isWCAjaxAddToCart = true;
			}
		}

		toggleCart(e){
			if( this.isOpen() ){
				this.closeCartOnClick(e);
			}
			else{
				this.openCart(e);
			}
			
		}

		openCart(e){
			if( e ){
				e.preventDefault();
				e.stopImmediatePropagation();
			}

			if( !this.cartLoaded && xoo_wsc_params.fetchCart === 'cart_open' ){
				this.refreshMyFragments();
				this.cartLoaded = true;
			}

			this.toggle('show');
			Notice.hideMarkupNotice();
		}

		addToCartFormSubmit(e){

			var $form = $(e.currentTarget);

			if( $form.closest('.product').hasClass('product-type-external') || $form.siblings('.xoo-wsc-disable-atc').length ) return;

			var $button  		= e.originalEvent && e.originalEvent.submitter ? $(e.originalEvent.submitter) : $form.find( 'button[type="submit"]'),
				formData 		= new FormData($form.get(0)),
				productData  	= $form.serializeArray(),
				hasProductId 	= false;

			//Check for woocommerce custom quantity code 
			//https://docs.woocommerce.com/document/override-loop-template-and-show-quantities-next-to-add-to-cart-buttons/
			$.each( productData, function( key, form_item ){
				if( form_item.name === 'productID' || form_item.name === 'add-to-cart' ){
					if( form_item.value ){
						hasProductId = true;
						return false;
					}
				}
			})

			//If no product id found , look for the form action URL
			if( !hasProductId && $form.attr('action') ){
				var is_url = $form.attr('action').match(/add-to-cart=([0-9]+)/),
					productID = is_url ? is_url[1] : false; 
			}

			// Add submitted button value
	        if( $button.attr('name') && $button.attr('value') ){
	            formData.append( $button.attr('name'), $button.attr('value') );
	        }

	        if( productID ){
	        	formData.append( 'add-to-cart', productID );
	        }

	        formData.append( 'action', 'xoo_wsc_add_to_cart' );

	        var doAjaxAddToCart = true;

	        
        	$.each( xoo_wsc_params.skipAjaxForData, function( key, value ){
        		if( formData.has(key) && ( !value || formData.get(key) == value ) ){
        			doAjaxAddToCart = false;
        			return false;
        		}
        	} )
	        

	        if( doAjaxAddToCart ){
	        	e.preventDefault();
	        	this.addToCartAjax( $button, formData );//Ajax add to cart
	        }
			
		}


		addToCartAjax( $button, formData ){

			this.block();

			$button.addClass('loading');

			// Trigger event.
			$( document.body ).trigger( 'adding_to_cart', [ $button, formData ] );

			$.ajax({
				url: get_wcurl( 'xoo_wsc_add_to_cart' ),
				type: 'POST',
				context: this,
				cache: false,
			    contentType: false,
			    processData: false,
				data: formData,
			    success: function(response){

					if(response.fragments){
						// Trigger event so themes can refresh other areas.
						$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $button ] );
					}else if(response.error){
						Notice.setHTML(response.notice);
						Notice.showNotification();
					}
					else{
						window.location.reload();
					}

			    },
			    complete: function(){
			    	this.unblock();
			    	$button
			    		.removeClass('loading')
			    		.addClass('added');
			    }
			})
		}

		addedToCart( e, response, hash, $button ){

			var _this = this;

			this.updateFragments( { fragments: response } );

			if( xoo_wsc_params.autoOpenCart === "yes" ){
				_this.openCart();
			}

			this.onCartUpdate();
			
		}

		blockAddedToCart(){

			if( !Cart.isWCAjaxAddToCart && !this.blockAddedToCartCalled ){

				this.refreshMyFragments();
				
				var _this = this;

				if( xoo_wsc_params.autoOpenCart === "yes" ){
					setTimeout(function(){
						_this.openCart();	
					},20 )
				}

				this.blockAddedToCartCalled = true;

				setTimeout( function(){
					_this.blockAddedToCartCalled = false;
				}, 200 );

				Cart.isWCAjaxAddToCart = false;

			}


						
		}

		
		closeCartOnClick(e){
			e.preventDefault();
			this.toggle( 'hide' );
		}


		onPageShow(e){
			if ( e.originalEvent.persisted ) {
				this.refreshMyFragments();
				$( document.body ).trigger( 'wc_fragment_refresh' );
			}
		}

		deleteIconClick(e){
			this.updateItemQty( $( e.currentTarget ).parents('.xoo-wsc-product').data('key'), 0 );
		}

		updateItemQty( cart_key, qty ){

			if( !cart_key || qty === undefined ) return;

			this.block();

			var formData = {
				cart_key: cart_key,
				qty: qty
			}

			$.ajax({
				url: get_wcurl( 'xoo_wsc_update_item_quantity' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData),
				success: function(response){
					this.updateFragments( response );
					$(document.body).trigger( 'xoo_wsc_quantity_updated', [response] );
					$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );
					this.unblock();
				}

			})
		}

		onCartUpdate(){
			super.onCartUpdate();
			this.cartLoaded = true;
			this.toggleBasket();
			this.initMasonryLayout();
		}


		initMasonryLayout(){
			if( xoo_wsc_params.productLayout !== 'cards' ) return;
			$('.xoo-wsc-products.xoo-wsc-pattern-card').masonry({
				// options
				itemSelector: '.xoo-wsc-product-cont',
				columnWidth: '.xoo-wsc-product-cont', /* Each column takes 50% */
				percentPosition: true
			});
		}

		
		toggleBasket(){

			var $basket 	= $('.xoo-wsc-basket'),
				show 		= xoo_wsc_params.showBasket,
				hasProducts = this.$modal.find('.xoo-wsc-product').length;

			if( show === "always_show" ){
				$basket.show();	
			}
			else if( show === "hide_empty" ){
				if( hasProducts){
					$basket.show();
				}
				else{
					$basket.hide();
				}
			}
			else{
				$basket.hide();
			}

			var $shortcode = $('.xoo-wsc-sc-cont');

			if( $shortcode.length && xoo_wsc_params.menuCartHideOnEmpty.length ){

				var shortcodeEls = xoo_wsc_params.shortcodeEls;

				$.each( xoo_wsc_params.menuCartHideOnEmpty, function( index, val ){

					if( shortcodeEls[val] ){
						if( hasProducts ){
							$(shortcodeEls[val]).show();
						}
						else{
							$(shortcodeEls[val]).hide();
						}
					}

				})

			}
		}

	

	}




	var cart 	= new Cart( $('.xoo-wsc-modal') );


	var AnimateCard = {

		type: xoo_wsc_params.cardAnimate.type,
		duration: xoo_wsc_params.cardAnimate.duration,

		init: function(){

			var onEvent = xoo_wsc_params.cardAnimate.event === 'back_hover' ? 'mouseenter' : 'click';
		
			$('body').on( onEvent, '.xoo-wsc-has-back', this.animate );
			$('body').on( 'mouseleave', '.xoo-wsc-has-back', this.reverseAnimate );

		},
		animate: function(e){

			if( e.target.classList.contains('xoo-wsc-smr-del') ) return;

			var $img = $(this).find('.xoo-wsc-img-col');

			if( !$img.hasClass('xoo-wsc-caniming') ){
				e.preventDefault();
			}
			else{
				return;
			}

			$img.attr('data-exclasses', $img.attr('class') );

			$img.removeClass()
			$img.addClass($img.attr('data-exclasses'));

			$img.addClass( 'xoo-wsc-caniming' + ' ' + AnimateCard.type );

		},
		reverseAnimate: function(){

			var $img = $(this).find('.xoo-wsc-img-col');

			if( !$img.hasClass( 'xoo-wsc-caniming' ) ) return;

			$img.addClass(AnimateCard.type+'Return');

			AnimateCard.clear = setTimeout(function(){
				$img.removeClass().addClass( $img.attr('data-exclasses') );
			}, AnimateCard.duration * 1000);

		}
	}

	if( xoo_wsc_params.cardAnimate.enable === "yes" ){
		AnimateCard.init();
	}


})