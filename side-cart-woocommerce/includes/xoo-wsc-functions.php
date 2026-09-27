<?php


function xoo_wsc_notice_html( $message, $notice_type = 'success' ){
	
	$classes = $notice_type === 'error' ? 'xoo-wsc-notice-error' : 'xoo-wsc-notice-success';

	$icon = $notice_type === 'error' ? 'xoo-wsc-icon-cross' : 'xoo-wsc-icon-check_circle';
	
	$html = '<li class="'.$classes.'"><span class="'.$icon.'"></span>'.$message.'</li>';
	
	return apply_filters( 'xoo_wsc_notice_html', $html, $message, $notice_type );
}


//Divi builder fix
function xoo_wsc_fix_for_divi_builder(){

	if ( isset( $_GET['et_fb'] ) && function_exists('xoo_wsc_frontend') ){
		remove_action( 'wp_footer', array( xoo_wsc_frontend(), 'cart_markup' ) );
		add_action( 'wp_head', array( xoo_wsc_frontend(), 'cart_markup' ), 15 );
	}

}
add_action( 'wp_head', 'xoo_wsc_fix_for_divi_builder'  );


/* Block theme fix */
add_action( 'wp_enqueue_scripts', function(){
	if( !function_exists('wp_is_block_theme') || !wp_is_block_theme() ) return;
	wp_enqueue_script( 'wc-cart-fragments' );
}, PHP_INT_MAX );


function xoo_wsc_add_ajax_atc_disable_form(){
	global $product;

	if( !xoo_wsc_enable_ajax_atc_for_product( $product ) ){
		echo '<span class="xoo-wsc-disable-atc" style="display: none!important"></span>';
	}
}

add_action( 'woocommerce_before_add_to_cart_form', 'xoo_wsc_add_ajax_atc_disable_form' );


function xoo_wsc_enable_ajax_atc_for_product( $product ){

	if( is_int( $product ) ){
		$product = wc_get_product( $product );
	}

	$ajaxAtc = xoo_wsc_helper()->get_general_option('m-ajax-atc');

	$enable = true;

	if( $ajaxAtc === 'yes' ){
		$enable = true;
	}
	else if ( $ajaxAtc === 'no' ) {
		$enable = false;
	}
	else{

		$catIds = xoo_wsc_helper()->get_general_option('m-ajax-atc-catid');

		$catIds = $catIds ? explode(',', $catIds ) : array();
		
		//Enable on all except
		if( $ajaxAtc === 'cat_no' ){
			$enable = !( !empty( $catIds ) && array_intersect( $catIds , $product->get_category_ids() ) );	
		}

		//Enable for these category
		if( $ajaxAtc === 'cat_yes' ){
			$enable = array_intersect( $catIds , $product->get_category_ids() );
		}

	}

	return apply_filters( 'xoo_wsc_enable_ajax_atc', $enable, $product );

}


function xoo_wsc_elementor_disable_cart( $ispage ){
	if(  defined( 'ELEMENTOR_VERSION' ) && ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()  ) ){
		$ispage = false;
	}
	return $ispage;
}

add_filter( 'xoo_wsc_is_sidecart_page', 'xoo_wsc_elementor_disable_cart' );


//Single product block add to cart fix
function xoo_wsc_single_product_atc_fix(){
	if( isset( $_POST['is-descendent-of-single-product-block'] ) && isset( $_POST['action'] ) && $_POST['action'] === 'xoo_wsc_add_to_cart' ){
		$_POST['is-descendent-of-single-product-block'] = false;
	}
}
add_action( 'init', 'xoo_wsc_single_product_atc_fix' );


function xoo_wsc_display_infobox(){
	echo '<div class="xoo-wsc-info-cont">';
	echo xoo_wsc_helper()->get_general_option('sct-info');
	echo '</div>';
}



/* Information box location */
function xoo_wsc_add_infobox_hook(){

	$location 	= xoo_wsc_helper()->get_style_option('scm-info-loc');

	if( $location === 'body_end' || $location === 'body_end_stick' || ( $location === 'mobile_body' && wp_is_mobile() ) ){
		$hook = 'xoo_wsc_body_end';
	}
	elseif( $location === 'body_start' ){
		$hook = 'xoo_wsc_body_start';
	}
	elseif( $location === 'footer_end' ){
		$hook = 'xoo_wsc_footer_end';
	}
	elseif( $location === 'footer_start' || $location === 'mobile_body' ){
		$hook = 'xoo_wsc_footer_start';
	}
	else{
		return;
	}

	add_action( $hook, 'xoo_wsc_display_infobox' );

}
add_action( 'xoo_wsc_header_start', 'xoo_wsc_add_infobox_hook' );

function xoo_wsc_quantity_input( $args = array(), $product = null, $echo = true ) {

	if ( is_null( $product ) ) {
		return;
	}

	$defaults = array(
		'input_value'  	=> '1',
		'max_value'    	=> apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
		'min_value'    	=> apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
		'step'         	=> apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
		'pattern'      	=> apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
		'inputmode'    	=> apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
		'placeholder'  	=> apply_filters( 'woocommerce_quantity_input_placeholder', '', $product ),
		'wsc_classes'  	=> apply_filters( 'xoo_wsc_quantity_input_classes', array( 'xoo-wsc-qty' ), $product ),
		'qtyDesign' 	=> xoo_wsc_helper()->get_style_option('scbq-style')
	);

	$args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );

	// Apply sanity to min/max args - min cannot be lower than 0.
	$args['min_value'] = max( $args['min_value'], 0 );
	$args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

	// Max cannot be lower than min if defined.
	if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
		$args['max_value'] = $args['min_value'];
	}

	ob_start();

	xoo_wsc_helper()->get_template( 'global/body/qty-input.php', $args );

	if ( $echo ) {
		echo ob_get_clean(); // WPCS: XSS ok.
	} else {
		return ob_get_clean();
	}
}


?>