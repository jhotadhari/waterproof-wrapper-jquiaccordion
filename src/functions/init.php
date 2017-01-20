<?php
/*
	grunt.concat_in_order.declare('init');
*/


// load_plugin_textdomain
function wpwqjqa_load_textdomain(){
	
	load_plugin_textdomain(
		'wpwq-jquiacc',
		false,
		dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
	);
}
add_action( 'plugins_loaded', 'wpwqjqa_load_textdomain' );


?>