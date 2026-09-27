<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_Wsc_Loader{

	protected static $_instance = null;

	public $isSideCartPage;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	
	public function __construct(){
		$this->set_constants();
		$this->includes();
		$this->hooks();
	}


	public function set_constants(){

		$this->define( "XOO_WSC_PATH", plugin_dir_path( XOO_WSC_PLUGIN_FILE ) ); // Plugin path
		$this->define( "XOO_WSC_PLUGIN_BASENAME", plugin_basename( XOO_WSC_PLUGIN_FILE ) );
		$this->define( "XOO_WSC_URL", untrailingslashit( plugins_url( '/', XOO_WSC_PLUGIN_FILE ) ) ); // plugin url
		$this->define( "XOO_WSC_VERSION", "2.8.2" ); //Plugin version
		$this->define( "XOO_WSC_LITE", true );
	}


	public function define( $constant_name, $constant_value ){
		if( !defined( $constant_name ) ){
			define( $constant_name, $constant_value );
		}
	}

	/**
	 * File Includes
	*/
	public function includes(){

		//xootix framework
		require_once XOO_WSC_PATH.'/includes/xoo-framework/xoo-framework.php';
		require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-helper.php';
		require_once XOO_WSC_PATH.'/includes/xoo-wsc-functions.php';
		require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-template-args.php';

		if( $this->is_request( 'frontend' ) ){
			require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-frontend.php';
		}
		
		if( $this->is_request( 'admin' ) ) {
			require_once XOO_WSC_PATH.'/admin/class-xoo-wsc-admin-settings.php';
		}

		require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-cart.php';

	}


	/**
	 * Hooks
	*/
	public function hooks(){
		$this->on_install();
	}


	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}


	/**
	* On install
	*/
	public function on_install(){

		$version_option = 'xoo-wsc-version';
		$db_version 	= get_option( $version_option );


		//2.0 and lower
		if( !$db_version && get_option( 'xoo-wsc-gl-options' ) !== false ){

			//Map old values to new option
			$oldValues = (array) include XOO_WSC_PATH.'/admin/views/oldtonew.php';

			foreach ( $oldValues as $keyData ) {

				$oldKeyValue = (array) get_option( $keyData['oldkey'] );

				$newKeyValue = (array) get_option( $keyData['newkey'] );

				if( $oldKeyValue === false ) continue;

				foreach ( $keyData['values'] as $oldsubkey => $newsubkey ) {
					if( !isset( $oldKeyValue[ $oldsubkey ] ) ) continue;
					$newKeyValue[ $newsubkey ] = $oldKeyValue[ $oldsubkey ];
				}

				//Clean values
				foreach ($newKeyValue as $key => $value) {
					if( $value == 'false' ){
						$value = 'no';
					}
					elseif ( $value == '1' ) {
						$value = 'yes';
					}
					$newKeyValue[ $key ] = $value;
				}

				update_option( $keyData['newkey'], $newKeyValue );
			}

			$style = (array) get_option( 'xoo-wsc-sy-options' );

			$style['scbp-delpos'] 		= 'image';
			$style['scbp-deltype'] 		= 'text';

			update_option( 'xoo-wsc-sy-options', $style );
		}

		
		if( $db_version && version_compare( $db_version, XOO_WSC_VERSION, '<' ) ){

			$newSyOptions = array(
				'scbp-bgcolor' 				=> 'transparent',
				'scbp-margin' 				=> '0',
				'scbp-bradius' 				=> '0',
				'scbp-shadow' 				=> '0 0',
				'scbp-var-format' 			=> 'sep_line',
				'scbp-card-backtxt-color' 	=> '#000',
				'scbp-card-imgh' 			=> '',
				'scb-playout' 				=> 'rows',
			);

			$newGlOptions = array(
				'sct-footer' 			=> '',
				'scf-chkbtntotal-en' 	=> 'no',
				'shbk-menu' 			=> 'none',
				'scb-prod-price' 		=> 'actual'
			);

			$newOptions = array(
				'xoo-wsc-gl-options' => $newGlOptions,
				'xoo-wsc-sy-options' => $newSyOptions
			);

			foreach ($newOptions as $optionName => $optionValues ) {

				$existing = (array) get_option( $optionName );

				foreach ( $optionValues as $key => $value ) {
					if( isset( $existing[ $key ] ) ) continue;
					$existing[ $key ] = $value;
				}

				update_option( $optionName, $existing );

			}
		}

		if( $db_version ){
			
			$glOptions 	= xoo_wsc_helper()->get_general_option();
			$syOptions 	= xoo_wsc_helper()->get_style_option();
			$avOptions 	= xoo_wsc_helper()->get_advanced_option();

			if( version_compare( $db_version, '2.5', '<')  ){
				$glOptions['scb-show'][] 		= 'product_qty';
				$glOptions['scbp-qpdisplay'] 	= xoo_wsc_helper()->get_style_option('scbp-qpdisplay');
			}

			if( version_compare( $db_version, '2.5.9', '<')  ){
				update_option( 'xoo-wsc-enqueue-cartfragment', 'no' );
			}


			if( version_compare( $db_version, '2.6.1', '<')  ){
				update_option('xoo-wsc-pattern-init', 'yes' );
			}

			if( version_compare( $db_version, '2.6.4', '<')  ){
				update_option('xoo_tracking_consent_side-cart-woocommerce', 'no' );
			}

			if( version_compare( $db_version, '2.7.1', '<')  ){
				$glOptions['shbk-hide'] 		= array();
				$syOptions['sch-new-layout'] 	= 'no';
				$syOptions['sch-layout']  		= array();
				$syOptions['sch-count-size']  	= 20;
				$syOptions['sch-basket-fsize']	= 30;
				$glOptions['shbk-hide'] 		= array();
				update_option( 'xoo-wsc-old-header-layout', 'yes' );
			}

			if( version_compare( $db_version, '2.7.2', '<')  ){
				$syOptions['sch-padding'] 			= '15px 15px';
				$syOptions['scb-icon-size'] 		= $syOptions['scb-fsize'];
				if( isset( $glOptions['shbk-menu'] ) && $glOptions['shbk-menu'] !== "none" ){
					$glOptions['shbk-menu'] = array( $glOptions['shbk-menu'] ); //converting to array
				}

			}

			if( version_compare( $db_version, '2.7.5', '<')  ){
				$syOptions['sck-count-size'] = 28;
			}
			

			if( version_compare( $db_version, '2.7.6', '<')  ){

				$syOptions['scf-btn-newlayout'] = 'no';
				$syOptions['scb-empty-img'] 	= '';
				$avOptions['m-fetch-cart'] 		= 'page_load';
				$glOptions['sct-info'] 			= '';
				$syOptions['scm-info-loc'] 		= 'footer_start';

				update_option( 'xoo-wsc-had-old-btn-layout', 'yes' );

			}


			if( version_compare( $db_version, '2.7.7', '<')  ){

			

				//Create theme from older button settings
				if( isset( $syOptions['scf-btn-main'] ) && !empty( $syOptions['scf-btn-main'] ) && ( !isset( $syOptions['scf-btn-newlayout'] ) || $syOptions['scf-btn-newlayout'] === "yes" ) ){

					$button_settings = xoo_wsc_helper()->get_button_values( $syOptions['scf-btn-main'] );

					$default_theme1 = array_merge(
						$button_settings,
						array(
							'theme_id' => 'theme_default1',
							'title'    => 'Default Theme #1',
						)
					);

					$default_theme2 = array_merge(
						$button_settings,
						array(
							'theme_id'  => 'theme_default2',
							'title'     => 'Default Theme #2',
							'size_type' => 'auto',
						)
					);

					$syOptions['scm-btnthemes'] = array(
						'theme_default1' => $default_theme1,
						'theme_default2' => $default_theme2,
					);

					$syOptions['scm-btntheme-cart'] = $syOptions['scm-btntheme-checkout'] = $syOptions['scm-btntheme-continue'] = 'theme_default1';
					
					$syOptions['scm-btntheme-empty'] = 'theme_default2';
					
				}

			}


			if( version_compare( $db_version, '2.8.0', '<')  ){

				$glOptions['scb-update-qty'] 	= 'no';
				$glOptions['sch-show'] 			= array_diff( $glOptions['sch-show'], array( 'notifications' ) );

				$syOptions['scbq-btnsize'] 		= 20;
				$syOptions['scbq-input-border'] = $syOptions['scbq-box-border'] = array(
					'size' 		=> 1,
					'color' 	=> '#c9c9c9',
					'style' 	=> 'solid',
					'radius' 	=> 0,
				);

				if ( false === get_option( 'xoo_tracking_consent_side-cart-woocommerce', false ) ) {
				    update_option( 'xoo_tracking_consent_side-cart-woocommerce', 'no' );
				}

			}

			
			update_option('xoo-wsc-av-options', $avOptions );
			update_option('xoo-wsc-gl-options', $glOptions );
			update_option('xoo-wsc-sy-options', $syOptions );

		}


		//Update to current version
		update_option( $version_option, XOO_WSC_VERSION);

		
	}


	public function isSideCartPage(){

		if( !trim(xoo_wsc_helper()->get_general_option('m-hide-cart')) ){
			$hidePages = array();
		}
		else{
			$hidePages = array_map( 'trim', explode( ',', xoo_wsc_helper()->get_general_option('m-hide-cart') ) );
		}

		if( !isset( $this->isSideCartPage ) ){
			
			$this->isSideCartPage = !( !empty( $hidePages ) && ( ( in_array( 'no-woocommerce', $hidePages )  && !is_woocommerce() && !is_cart() && !is_checkout() ) || is_page( $hidePages ) ) || ( is_product() && in_array( get_the_id() , $hidePages ) ) );

			foreach ( $hidePages as $page_id ) {
				if( is_single( $page_id ) ){
					$this->isSideCartPage = false;
					break;
				}
			}
		
		}


		return apply_filters( 'xoo_wsc_is_sidecart_page', $this->isSideCartPage, $hidePages );
	}

}

?>