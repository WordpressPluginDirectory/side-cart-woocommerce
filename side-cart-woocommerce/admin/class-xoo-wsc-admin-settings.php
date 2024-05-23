<?php

class Xoo_Wsc_Admin_Settings{

	protected static $_instance = null;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){
		$this->hooks();
	}


	public function hooks(){
		if( current_user_can( 'manage_options' ) ){
			add_action( 'init', array( $this, 'generate_settings' ), 0 );
			add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
		}
		add_action( 'xoo_as_enqueue_scripts', array( $this, 'enqueue_custom_scripts' ) );
		add_action( 'xoo_tab_page_end', array( $this, 'tab_html' ), 10, 2 );
		add_filter( 'plugin_action_links_' . XOO_WSC_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );

		add_action( 'admin_footer', array( $this, 'sidecart_preview' ) );

		add_action( 'xoo_tab_page_start', array( $this, 'preview_info' ), 5 );

		add_action( 'xoo_admin_setting_field_callback_html', array( $this, 'checkpoints_bar_setting_html' ), 10, 4 );
	}

	public function preview_info($tab_id){
		if( !xoo_wsc_helper()->admin->is_settings_page() || $tab_id === 'pro' || $tab_id === 'info' ) return;
		?>
		<div class="xoo-as-preview-info"><span class="dashicons dashicons-laptop"></span> Updates live in customizer</div>
		<?php
	}

	public function sidecart_preview(){
		if( !xoo_wsc_helper()->admin->is_settings_page() ) return;
		xoo_wsc_helper()->get_template( 'xoo-wsc-preview.php', array(), XOO_WSC_PATH.'/admin/templates/preview/' );
	}



	/**
	 * Show action links on the plugin screen.
	 *
	 * @param	mixed $links Plugin Action links
	 * @return	array
	 */
	public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' 	=> '<a href="' . admin_url( 'admin.php?page=side-cart-woocommerce-settings' ) . '">Settings</a>',
			'support' 	=> '<a href="https://xootix.com/contact" target="__blank">Support</a>',
			'upgrade' 	=> '<a href="https://xootix.com/plugins/side-cart-for-woocommerce" target="__blank">Upgrade</a>',
		);

		return array_merge( $action_links, $links );
	}



	public function enqueue_custom_scripts( $slug ){
		if( $slug !== 'side-cart-woocommerce' ) return;
		wp_enqueue_style( 'xoo-wsc-admin-fonts', XOO_WSC_URL . '/assets/css/xoo-wsc-fonts.css', array(), XOO_WSC_VERSION );
		wp_enqueue_style( 'xoo-wsc-admin-style', XOO_WSC_URL . '/admin/assets/xoo-wsc-admin-style.css', array(), XOO_WSC_VERSION );
		wp_enqueue_script( 'xoo-wsc-admin-js', XOO_WSC_URL . '/admin/assets/xoo-wsc-admin-js.js', array( 'jquery' ), XOO_WSC_VERSION, true );
	}


	public function generate_settings(){
		xoo_wsc_helper()->admin->auto_generate_settings();
	}



	public function add_menu_pages(){

		$args = array(
			'menu_title' 	=> 'Side Cart',
			'icon' 			=> 'dashicons-cart',
		);

		xoo_wsc_helper()->admin->register_menu_page( $args );

	}


	public function tab_html( $tab_id, $tab_data ){

		if( !xoo_wsc_helper()->admin->is_settings_page() ) return;
		
		if( $tab_id === 'pro' ){
			xoo_wsc_helper()->get_template( 'xoo-wsc-tab-pro.php', array(), XOO_WSC_PATH.'/admin/templates/' );
		}

		if( $tab_id === 'info' ){
			xoo_wsc_helper()->get_template( 'xoo-wsc-tab-info.php', array(), XOO_WSC_PATH.'/admin/templates/' );
		}
		
	}



	public function checkpoints_bar_setting_html( $field, $field_id, $value, $args ){

		if( $field_id !== 'xoo-wsc-gl-options[scbar-data]' ) return $field;

		$default = array(
			array(
				'enable' 		=> 'yes',
				'amount' 		=> 100,
				'remaining'		=> "You're [amount] away from free gift",
				'title' 		=> "Free Gift",
				'type'			=> 'gift',
				'gift_ids' 		=> '',
				'gift_qty' 		=> 1,
			)
		);

		$value = !is_array( $value ) ? $default : $value;

		$chkpointID = $field_id.'[%$]';

		ob_start();

		?>

		<button class="button button-primary xoo-scbchk-add" type="button">Add Checkpoint</button>
		<button class="button button-primary xoo-scbchk-add xoo-scbhk-add-ship" type="button">Add Free Shipping Checkpoint</button>

		<div class="xoo-bar-points-cont" data-idholder="<?php echo $chkpointID; ?>">

			<?php foreach ( $value as $index => $chkpoint ): ?>

				<div class="xoo-scbhk-chkcont <?php echo $chkpoint['type'] === 'freeshipping' ? 'xoo-scbhk-shipcont' : '' ?>">

					
					<div class="xoo-scbhk-ship-el xoo-scbhk-ship-title">
						<span>Free Shipping</span>
						<i>The amount is fetched from Free shipping method ( woocommerce shipping settings ).<br> Please make sure you have a free shipping method available for customers' location.<br><a href="https://docs.xootix.com/side-cart-for-woocommerce/#shippingbar" target="__blank">Read more</a></i><br>
					</div>
					

					<div class="xoo-scbar-chkpoint">
					
						<div class="xoo-scbhk-field xoo-scb-enable">
							<label>Enable</label>
							<input type="hidden" name="<?php echo $chkpointID ?>[enable]" value="no">
							<input type="checkbox" value="yes" name="<?php echo $chkpointID ?>[enable]" <?php if( $chkpoint['enable'] === 'yes' ) echo 'checked'; ?> >
						</div>

						<div class="xoo-scbhk-field xoo-scb-comp">
							<label>Title</label>
							<input type="text" name="<?php echo $chkpointID ?>[title]" value="<?php esc_attr_e( $chkpoint['title'] ) ?>">
						</div>

						<div class="xoo-scbhk-field xoo-scb-amount">
							<label>Amount</label>
							<input type="number" name="<?php echo $chkpointID ?>[amount]" value="<?php esc_attr_e( $chkpoint['amount'] ) ?>">
						</div>

						<div class="xoo-scbhk-field xoo-scb-rem">
							<label>Remaining Text</label>
							<input type="text" name="<?php echo $chkpointID ?>[remaining]" value="<?php esc_attr_e( $chkpoint['remaining'] ) ?>">
							<span class="xoo-scbhk-desc">[amount] is the remaining amount to unlock this checkpoint</span>
						</div>


						<div class="xoo-scbhk-field xoo-scb-type">
							<label>Type</label>
							<select name="<?php echo $chkpointID ?>[type]">
								<option value="display" <?php selected( $chkpoint['type'], 'display' ) ?> >Only for display</option>
								<option value="gift" <?php selected( $chkpoint['type'], 'gift' ) ?>>Free Gift</option>
								<option value="freeshipping" <?php selected( $chkpoint['type'], 'freeshipping' ) ?> style="display: none;">Free Shipping</option>
							</select>
						</div>

						<div class="xoo-scbhk-field xoo-scbhk-giftid xoo-scbhk-gift">
							<label>Free Gift Product ID(s)</label>
							<input type="text" name="<?php echo $chkpointID ?>[gift_ids]" value="<?php esc_attr_e( $chkpoint['gift_ids'] ) ?>">
							<span class="xoo-scbhk-desc">Add product ID(s) to be given as free gift. (Separated by commas)</span>
						</div>

						<div class="xoo-scbhk-field xoo-scbhk-giftqty xoo-scbhk-gift">
							<label>Gift Quantity</label>
							<input type="number" name="<?php echo $chkpointID ?>[gift_qty]" value="<?php esc_attr_e( $chkpoint['gift_qty'] ) ?>">
						</div>

					</div>

					<span class="dashicons dashicons-no-alt xoo-scbh-del"></span>

				</div>

			<?php endforeach; ?>

		</div>

		<?php

		return ob_get_clean();

	}

}

function xoo_wsc_admin_settings(){
	return Xoo_Wsc_Admin_Settings::get_instance();
}
xoo_wsc_admin_settings();