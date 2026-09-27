<?php

$sections = array(

	/* General TAB Sections */
	array(
		'title' => 'Side Cart Header',
		'id' 	=> 'sc_head',
		'tab' 	=> 'general',
		'icon' 	=> 'xoo-icon-header'
	),

	array(
		'title' => 'Side Cart Body',
		'id' 	=> 'sc_body',
		'tab' 	=> 'general',
		'icon' 	=> 'xoo-icon-page'
	),


	array(
		'title' => 'Side Cart Footer',
		'id' 	=> 'sc_footer',
		'tab' 	=> 'general',
		'icon' 	=> 'xoo-icon-footer'
	),

	array(
		'title' => 'Main',
		'id' 	=> 'main',
		'tab' 	=> 'general',
		'icon' 	=> 'xoo-icon-header'
	),

	array(
		'title' => 'Cart Menu/ Shortcode',
		'id' 	=> 'sh_bk',
		'tab' 	=> 'general',
		'desc' 	=> 'You can also use shortcode [xoo_wsc_cart] to generate basket icon anywhere.',
		'icon' 	=> 'xoo-icon-code'
	),


	array(
		'title' => 'Texts',
		'id' 	=> 'texts',
		'tab' 	=> 'general',
		'desc' 	=> 'Leave text empty to remove element',
		'icon' 	=> 'xoo-icon-page'
	),

	array(
		'title' => 'URLs',
		'id' 	=> 'urls',
		'tab' 	=> 'general',
		'icon' 	=> 'xoo-icon-link'
	),



	array(
		'title' => 'Suggested Products',
		'id' 	=> 'suggested_products',
		'tab' 	=> 'general',
		'pro' 	=> 'yes',
		'icon' 	=> 'xoo-icon-header'
	),

	array(
		'title' => 'Save For Later',
		'id' 	=> 'save_for_later',
		'tab' 	=> 'general',
		'desc' 	=> 'Allow users to save items in their cart for later purchase.',
		'pro' 	=> 'yes',
		'icon' 	=> 'xoo-icon-header'
	),


	/* Style TAB Sections */

	array(
		'title' => 'Button Themes',
		'id' 	=> 'sc_button_theme_creator',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-tune',
		'desc' 	=> 'Create and manage reusable button styles for side cart.'
	),


	array(
		'title' => 'Main',
		'id' 	=> 'sc_main',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-home'
	),

	
	array(
		'title' => 'Side Cart Basket',
		'id' 	=> 'sc_basket',
		'tab' 	=> 'style',
		'desc' 	=> 'You can also add basket to your menu bar using shortcode [xoo_wsc_cart]. Please see info tab for more.',
		'icon' 	=> 'xoo-icon-cart'
	),

	array(
		'title' => 'Side Cart Header',
		'id' 	=> 'sc_head',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-header'
	),

	array(
		'title' => 'Side Cart Body',
		'id' 	=> 'sc_body',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-page'
	),

	array(
		'title' => 'Product - Row layout',
		'id' 	=> 'scb_product',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-header'
	),


	array(
		'title' => 'Quantity Box',
		'id' 	=> 'scb_qty',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-header'
	),


	array(
		'title' => '🏷️ Product - Card layout 🏷️ ',
		'id' 	=> 'scb_productcard',
		'tab' 	=> 'style',
		'desc' 	=> 'Show your product items as cards',
		'icon' 	=> 'xoo-icon-header'
	),

	array(
		'title' => 'Side Cart Footer',
		'id' 	=> 'sc_footer',
		'tab' 	=> 'style',
		'icon' 	=> 'xoo-icon-footer'
	),



	array(
		'title' => 'Suggested Products',
		'id' 	=> 'sc_sug_products',
		'tab' 	=> 'style',
		'pro' 	=> 'yes',
		'icon' 	=> 'xoo-icon-store'
	),


	array(
		'title' => 'Saved for Later',
		'id' 	=> 'saved_for_later',
		'tab' 	=> 'style',
		'pro' 	=> 'yes',
		'icon' 	=> 'xoo-icon-heartplus'
	),



	array(
		'title' => 'Cart Menu / Shortcode',
		'id' 	=> 'sh_bk',
		'tab' 	=> 'style',
		'desc' 	=> 'Use shortcode [xoo_wsc_cart] to generate basket icon anywhere.',
		'icon' 	=> 'xoo-icon-code'
	),

	/* Rewards TAB Sections */
	array(
		'title' => 'Bar Settings',
		'id' 	=> 'general',
		'tab' 	=> 'rewards',
		'icon' 	=> 'xoo-icon-setting',
	),

	array(
		'title' => 'Gift Settings',
		'id' 	=> 'rewards_gift',
		'tab' 	=> 'rewards',
		'icon' 	=> 'xoo-icon-gift',
	),

	/* Custom CSS TAB Sections */
	array(
		'title' => 'Main',
		'id' 	=> 'av_main',
		'tab' 	=> 'advanced',
		'icon' 	=> 'xoo-icon-home'
	),
);

return apply_filters( 'xoo_wsc_admin_settings_sections', $sections );