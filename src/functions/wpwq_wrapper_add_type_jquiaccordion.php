<?php
/*
	grunt.concat_in_order.declare('wpwq_wrapper_add_type_jquiaccordion');
	grunt.concat_in_order.require('init');
*/

/**
* Add type name to the $wpwq_wrapper_types object
*/
function wpwq_wrapper_add_type_jquiaccordion(){
	global $wpwq_wrapper_types;
	$wpwq_wrapper_types->add_type( array(
		'jquiaccordion' => array(
			'desc' => __('Wrapps the queryresults in collapsible content panels for presenting information in a limited amount of space.<br>
				Its based on <a title="jQueryUI accordion" target="_blank" href="https://jqueryui.com/accordion/">jQuery user interface accordion</a>.','para_text'),
			'args' => array(
				'has_link' => array(
					'accepts' => 'bool', 
					'default' => 'false', 
					'desc' => __('Object should be linked?','para_text')
					),
				'header_tag' => array(
					'accepts' => 'html heading tag', 
					'default' => 'h2', 
					'desc' => __('h1 h2 h3 h4 ...?','para_text')
					),				
				/*
				'count_subs' => array(
					// ??? is in parent::	should be somehow here and ooked
					'accepts' => 'bool', 
					'default' => 'false', 
					'desc' => __('If terms are queried, display post count?','para_text')					
					),

				'subs_post_type' => array(
					// ??? is in parent::	should be somehow here and ooked
					'accepts' => 'string', 
					'default' => 'post', 
					'desc' => __('If terms are queried, and count_subs is true, what post_type should be used as name?','para_text')
					),
				'more' => array(
					'accepts' => 'string', 
					'default' => 'more', 
					'desc' => __('label for toogle button for closed panels','para_text')		
					),
				'close' => array(
					'accepts' => 'string', 
					'default' => 'close', 
					'desc' => __('label for toogle button for opened panels','para_text')			
					),
				*/
				'acc_options' => array(
					'accepts' => 'JSON', 
					'default' => '... there are some defaults ???',
					'desc' => __('This argument directly addresses the <a title="jQueryUI accordion options" target="_blank" href="http://api.jqueryui.com/accordion/#options">jQueryUI accordion options</a>.','para_text')
					),
				)
			)
		)
	);
}
add_action( 'admin_init', 'wpwq_wrapper_add_type_jquiaccordion' );

add_action( 'init', 'wpwq_wrapper_add_type_jquiaccordion' );


?>