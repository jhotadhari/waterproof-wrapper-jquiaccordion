<?php
/*
	grunt.concat_in_order.declare('Wpwqjqa_defaults');
	grunt.concat_in_order.require('init');
*/


class Wpwqjqa_defaults {


	protected $defaults = array();

	public function add_default( $arr ){
		$defaults = $this->defaults;
		$this->defaults = array_merge( $defaults , $arr);
	}
	
	public function get_default( $key ){
		if ( array_key_exists($key, $this->defaults) ){
			return $this->defaults[$key];

		}
			return null;
	}


}



function wpwqjqa_init_defaults(){
	global $wpwqjqa_defaults;
	
	$wpwqjqa_defaults = new Wpwqjqa_defaults();
	
}
add_action( 'admin_init', 'wpwqjqa_init_defaults', 1 );
add_action( 'init', 'wpwqjqa_init_defaults', 1 );



?>