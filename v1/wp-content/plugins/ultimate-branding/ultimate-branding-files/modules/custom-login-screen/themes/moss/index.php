<?php
$url = plugins_url( '', __FILE__ );

return array(
	'background' => array(
		'image' => array(
			array(
				'meta' => array(
					$url.'/background.jpg',
					2400,
					1596,
					false,
				),
			),
		),
	),
	'form' => array(
		'form_bg_color' => '#eeffee',
		'form_bg_transparency' => 75,
		'form_button_color' => '#119911',
		'rounded_nb' => 20,
	),
	'form_labels' => array(),
	'form_errors' => array(),
	'below_form' => array(
		'show_back_to' => 'off',
	),
	'form_canvas' => array(),
	'redirect' => array(),
);
