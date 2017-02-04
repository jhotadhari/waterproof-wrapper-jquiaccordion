<?php
/*
Plugin Name: Waterproof Wrapper jQuery UI Accordion
Plugin URI: http://waterproof-webdesign.info/waterproof-wrapper-jquiaccordion
Description: Wrapper to extend the 'Waterproof Wrap Query' Plugin. Based on jQuery user interface accordion (https://jqueryui.com/accordion/).
Version: 0.0.2
Author: jhotadhari
Author URI: http://waterproof-webdesign.info/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpwq-jquiacc
Domain Path: /languages
Tags: shortcode,wrapper,lists,listing,accordion,jQuery,jQueryUI
*/

/*
	grunt.concat_in_order.declare('_plugin_info');
*/

?>
<?php
/*
	grunt.concat_in_order.declare('init');
	grunt.concat_in_order.require('_plugin_info');
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wpwqjqa_get_required_php_ver() {
	return '5.6';
}

function wpwqjqa_plugin_activate(){
    if ( ! is_plugin_active( 'waterproof-wrap-query/waterproof-wrap-query.php' )
    	|| version_compare( PHP_VERSION, wpwqjqa_get_required_php_ver(), '<')
    ) {
        wp_die( wpwqjqa_get_admin_notice() . '<br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}
register_activation_hook( __FILE__, 'wpwqjqa_plugin_activate' );

function wpwqjqa_load_functions(){
	if (
		class_exists( 'Wpwq_wrapper' )
		&& ! version_compare( PHP_VERSION, wpwqjqa_get_required_php_ver(), '<')
	){
		include_once(plugin_dir_path( __FILE__ ) . 'functions.php');
	} else {
		add_action( 'admin_notices', 'wpwqjqa_print_admin_notice' );
	}
}
add_action( 'plugins_loaded', 'wpwqjqa_load_functions' );

function wpwqjqa_print_admin_notice() {
	echo '<strong><span style="color:#f00;">' . wpwqjqa_get_admin_notice() . '</span></strong>';
};

function wpwqjqa_get_admin_notice() {
	$plugin_title = 'Waterproof Wrapper jQuery UI Accordion';
	$parent_plugin_title = 'Waterproof Wrap Query';
	return sprintf(esc_html__( '"%s" plugin requires "%s" plugin to be installed and activated and PHP version greater %s!', 'wpwq' ), $plugin_title, $parent_plugin_title, wpwqjqa_get_required_php_ver());
}
?>