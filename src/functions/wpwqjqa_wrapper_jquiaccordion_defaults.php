<?php
/*
	grunt.concat_in_order.declare('wpwqjqa_wrapper_jquiaccordion_defaults');
	grunt.concat_in_order.require('init');
	grunt.concat_in_order.require('Wpwqjqa_defaults');
*/


/**
* Add related defaults to the global $wpwqjqa_defaults object
*/
function wpwqjqa_add_defaults_wrapper_jquiaccordion(){
	global $wpwqjqa_defaults;
		
	// define name
	$type_name = 'jquiaccordion';
		
	$wpwqjqa_defaults->add_default( array(
		'wrapper_' . $type_name . '_' . 'default_image' => ''
	));
}
add_action( 'admin_init', 'wpwqjqa_add_defaults_wrapper_jquiaccordion', 2 );
add_action( 'init', 'wpwqjqa_add_defaults_wrapper_jquiaccordion', 2 );



?>