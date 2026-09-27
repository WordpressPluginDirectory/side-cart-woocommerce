<?php

$tabs = array(


	'general' => array(
		'title'			=> 'General',
		'id' 			=> 'general',
		'option_key' 	=> 'xoo-wsc-gl-options',
		'icon' 			=> 'xoo-icon-setting',
		
	),


	'style' => array(
		'title'			=> 'Style',
		'id' 			=> 'style',
		'option_key' 	=> 'xoo-wsc-sy-options',
		'icon' 			=> 'xoo-icon-brush',
		
	),


	'advanced' => array(
		'title'			=> 'Advanced',
		'id' 			=> 'advanced',
		'option_key' 	=> 'xoo-wsc-av-options',
		'icon' 			=> 'xoo-icon-tune',
		
	),

	'rewards' => array(
		'title'			=> 'Rewards',
		'id' 			=> 'rewards',
		'option_key' 	=> 'xoo-wsc-rewards-options',
		'icon' 			=> 'xoo-icon-gift',
		'pro' 			=> 'yes',
		
	),

	'pro' => array(
		'title'			=> 'Pro',
		'id' 			=> 'pro',
		'option_key' 	=> 'xoo-wsc-dummy-pro',
		'icon' 			=> 'xoo-icon-crown',
	),
);

return apply_filters( 'xoo_wsc_admin_settings_tabs', $tabs );