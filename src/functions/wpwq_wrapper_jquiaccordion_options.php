<?php
/*
	grunt.concat_in_order.declare('wpwq_wrapper_jquiaccordion_options');
	grunt.concat_in_order.require('init');
*/

// Add related defaults to the global $tarp_defaults object
function wpwqjqa_add_defaults(){
	global $wpwqjqa_defaults;
	
	$wpwqjqa_defaults->add_default( array(
		'acc_options' => '
{
	"collapsible": "true",
	"active": "0",
	"heightStyle": "content"
}
		',
	));
}
add_action( 'admin_init', 'wpwqjqa_add_defaults', 2 );
add_action( 'init', 'wpwqjqa_add_defaults', 2 );

function wpwqjqa_options_cb( $cmb ) {
	global $wpwqjqa_defaults;
	global $wpwq_wrapper_types;
	
	
	// define name
	$type_name = 'jquiaccordion';
	// get type_desc 
	$type_desc = $wpwq_wrapper_types->get_types( null, $type_name)[$type_name];
	
	$classes = 'wpwq-wrapper wrapper-jquiaccordion';

	$cmb->add_field( array(
		'name' => __('Jquiaccordion Wrapper', 'wpwq-jquiacc'),
		'id' => $type_name . '_' . 'title',
		'desc' => '<span class="font-initial">' . __( $type_desc['desc'] , 'wpwq-jquiacc') . '</span>',
		'type'    => 'title',
		'classes' => $classes,
	) );

	$cmb->add_field( array(
		'name' => '[default] ' . __('Accordion Options', 'wpwq-jquiacc'),
		'desc' => __('A JSON formatted array that addresses the <a title="jQueryUI accordion options" target="_blank" href="http://api.jqueryui.com/accordion/#options">jQueryUI accordion options</a>.<br>
			Just leave it blank to get the default values ... and save them!','wpwq-jquiacc'),
		'id' => $type_name . '_' . 'acc_options',
		'default' => $wpwqjqa_defaults->get_default( 'acc_options' ),
		'type' => 'textarea',
		'classes' => $classes,
	) );

	$cmb->add_field( array(
		'name'    => 'Enqueue Frontend styles and scripts',
		'desc'    => __('Uncheck these if you want to load them your own way.','wpwq-jquiacc') . '<br>'
			. '<span class="font-initial">' . __('If your Theme or Childtheme has a folder "wpwq" with file "wpwqjqa_style.css" it will be enqued at last.','wpwq-jquiacc') . '</span>'
		,
		'id'      => $type_name . '_' . 'enqueue_jscss',
		'type'    => 'multicheck',
		'default' => array(
			'jquery_ui_accordion_js',
			'jquery_ui_css',
			'wpwqjqa_style'
		),
		'options' => array(
			'jquery_ui_accordion_js' => 'Plugin script jquery-ui-accordion (the wp included)',
			'jquery_ui_css' => 'Plugin style jquery ui',
			'wpwqjqa_style' => 'Plugin style wpwqjqa_style'
		),
		'classes' => $classes,
	) );	
	
	
}
add_action('wpwq_options', 'wpwqjqa_options_cb', 10, 1 );
?>