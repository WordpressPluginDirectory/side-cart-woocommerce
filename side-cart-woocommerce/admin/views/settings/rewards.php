<?php


$rewards = array(

	array(
		'callback' 		=> 'rewardfake',
		'title' 		=> 'Enable Rewards',
		'id' 			=> 'scbar-en',
		'section_id' 	=> 'general',
		'default' 		=> 'yes',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Divide Bar',
		'id' 			=> 'scbar-divide',
		'section_id' 	=> 'general',
		'args' 			=> array(
			'options' 	=> array(
				'equal'			=> 'Equally',
				'prop' 			=> 'Proportionately',
			),
		),
		'default' 	=> 'equal',
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Bar Height',
		'id' 			=> 'scbar-height',
		'section_id' 	=> 'general',
		'default' 		=> 8,
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Icon Size',
		'id' 			=> 'scbar-icon-size',
		'section_id' 	=> 'general',
		'default' 		=> '12',
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Icon Circle Size',
		'id' 			=> 'scbar-icon-circle-size',
		'section_id' 	=> 'general',
		'default' 		=> '30',
		'desc' 			=> 'Size in px'
	),



	array(
		'callback' 		=> 'select',
		'title' 		=> 'Checkpoint completed celebration',
		'id' 			=> 'scbar-one-celebrate',
		'section_id' 	=> 'general',
		'args' 			=> array(
			'options' 	=> array(
				'none'			=> 'None',
				'SchoolPride' 	=> 'School Pride',
				'BasicCannon' 	=> 'Basic Cannon',
				'RealisticLook'	=> 'Realistic Look',
				'Stars' 		=> 'Stars',
				'Fireworks' 	=> 'Fireworks',
			),
		),
		'default' 	=> 'RealisticLook',
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Progress bar completed Celebration',
		'id' 			=> 'scbar-all-celebrate',
		'section_id' 	=> 'general',
		'args' 			=> array(
			'options' 	=> array(
				'none'			=> 'None',
				'SchoolPride' 	=> 'School Pride',
				'BasicCannon' 	=> 'Basic Cannon',
				'RealisticLook'	=> 'Realistic Look',
				'Stars' 		=> 'Stars',
				'Fireworks' 	=> 'Fireworks',
			),
		),
		'default' 	=> 'SchoolPride',
	),

	array(
		'callback' 		=> 'bars_custom',
		'title' 		=> 'Bars',
		'id' 			=> 'bars',
		'section_id' 	=> 'general',
		'default' 		=> '',
	),

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Allow gift removal',
		'id' 			=> 'scbar-fg-en-delete',
		'section_id' 	=> 'rewards_gift',
		'default' 		=> 'no',
		'desc' 			=> "Allow customers to remove gift products from their cart"
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Show added gifts in side cart',
		'id' 			=> 'scbar-fg-show',
		'section_id' 	=> 'rewards_gift',
		'default' 		=> 'no',
		'desc' 			=> 'Show added gifts as normal cart item in side cart'
	),

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Exclude gift quantities from basket count',
		'id' 			=> 'scbar-fg-qtyexc',
		'section_id' 	=> 'rewards_gift',
		'default' 		=> 'no',
		'desc' 			=> 'Exclude gift quantities from the basket count shown in the shortcode and floating basket'
	),

	
);

return apply_filters( 'xoo_wsc_admin_settings', $rewards, 'rewards' );