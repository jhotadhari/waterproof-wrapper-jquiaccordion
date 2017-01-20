<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_jquiaccordion');
	grunt.concat_in_order.require('init');

	grunt.concat_in_order.declare('Wpwq_wrapper_jquiaccordion_single');
	grunt.concat_in_order.require('wpwq_wrapper_add_type_jquiaccordion');
	grunt.concat_in_order.require('wpwqjqa_wrapper_jquiaccordion_defaults');
	grunt.concat_in_order.require('wpwq_wrapper_jquiaccordion_options');
	grunt.concat_in_order.require('Wpwqjqa_localize');
*/

/*
	requires
		???
		jquery.jquiaccordion.js

		jquery.jquiaccordion.less

		
		wpwq_wrapper_jquiaccordion.js
		wpwq_wrapper_jquiaccordion.less
		
*/


class Wpwq_wrapper_jquiaccordion extends Wpwq_wrapper {
	
	function __construct( $query_obj = null, $objs = null, $args = null ) {
		parent::__construct( $query_obj, $objs, $args );

		$this->set_name( 'jquiaccordion' );
		
		$this->parse_data();
		
		add_action( 'wp_footer', array( $this, 'styles_scripts_frontend' ), 1 );
		add_action( 'wp_footer', array( $this, 'scripts_frontend_print' ) );

		$this->set_wrapper_open();
		$this->set_wrapper_close();
		$this->set_wrapper_inner();
	}

	protected function set_wrapper_open() {
		
		$unique = ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) > 0 ? ' ' . wpwq_slugify($this->args['unique']) . '-unique' : '' );
		$this->wrapper_open = '<div class="wpwq-query-wrapper clearfix jquiaccordion' . $unique . '">';

	}
	protected function set_wrapper_close() {
		$this->wrapper_close = '</div>';
	}
	
	protected function parse_data() {
		global $wpwqjqa_localize;
		global $wpwqjqa_defaults;

		$acc_options = wpwq_get_option( $this->type_name . '_' . 'acc_options', $wpwqjqa_defaults->get_default( 'acc_options' ));
		$jsonStr = strip_tags(str_replace( ' ', '', $acc_options));
		$acc_options = ( null !== json_decode( $jsonStr, true ) ? json_decode( $jsonStr, true ) : array() );
		
		$options = array(
			'global' => array(
				'acc_options' => $acc_options
			)
		);
		
		if ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) ) {
			$unique = wpwq_slugify($this->args['unique']);
			
			$options[$unique]['acc_options'] = ( array_key_exists('acc_options', $this->args) ? $this->args['acc_options'] : array() );
		}
		

		$wpwqjqa_localize->add_datas( $options );

		
	}
	
	public function styles_scripts_frontend() {
		
		$enqueue_jscss = wpwq_get_option( $this->type_name . '_' . 'enqueue_jscss', array(
			'jquery_ui_accordion_js',
			'jquery_ui_css',
			'wpwqjqa_style'
		));
		
		if ( in_array( 'jquery_ui_css', $enqueue_jscss )){	
			wp_enqueue_style( 'jquery_ui_css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css' );
		}
		if ( in_array( 'wpwqjqa_style', $enqueue_jscss )){	
			wp_enqueue_style( 'wpwqjqa_style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
		}
		
		if ( get_template_directory_uri() != get_stylesheet_directory_uri() ){
			// childtheme exists
			if ( file_exists( get_template_directory() . '/wpwq/wpwqjqa_style.css' ) ){
				wp_enqueue_style( 'wpwqjqa_style_theme', get_template_directory_uri() . '/wpwq/wpwqjqa_style.css' );

			}
			if ( file_exists( get_stylesheet_directory() . '/wpwq/wpwqjqa_style.css' ) ){
				wp_enqueue_style( 'wpwqjqa_style_childtheme', get_stylesheet_directory_uri() . '/wpwq/wpwqjqa_style.css' );

			}
		} else {
			// childtheme doesn't exists
			if ( file_exists( get_template_directory() . '/wpwq/wpwqjqa_style.css' ) ){
				wp_enqueue_style( 'wpwqjqa_style_theme', get_template_directory_uri() . '/wpwq/wpwqjqa_style.css' );

			}
		}
	
		if ( in_array( 'jquery_ui_accordion_js', $enqueue_jscss )){	
			wp_enqueue_script('jquery-ui-accordion');
		}
		
		wp_register_script( 'wpwqjqa_script', plugin_dir_url( __FILE__ ) . 'js/script.min.js', array('jquery','jquery-ui-accordion') , false , true);
	}	
	public function scripts_frontend_print() {
		global $wpwqjqa_localize;
		
		$parse_data = $wpwqjqa_localize->get_datas();
		wp_localize_script( 'wpwqjqa_script', 'Wpwq_wrapper_' . $this->type_name, $parse_data );
		wp_print_scripts('wpwqjqa_script');
	}	
	
	
	protected function set_wrapper_inner() {
		$return = '';
		
		$i = 1;
		foreach ( $this->query_prepared as $query_single_obj ){
			$wpwq_wrapper_jquiaccordion_single = new Wpwq_wrapper_jquiaccordion_single( $this->get_name(), $query_single_obj, $this->args, $this->get_args_single(), $i );
			$return .= $wpwq_wrapper_jquiaccordion_single->get_inner();
			$i++;
		}
		
		$this->wrapper_inner = $return;
	}
}
	





?>