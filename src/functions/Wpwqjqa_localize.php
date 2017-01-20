<?php
/*
	grunt.concat_in_order.declare('Wpwqjqa_localize');
	grunt.concat_in_order.require('init');
*/

class Wpwqjqa_localize {

	protected $datas = array();

	public function add_datas( $arr ){
		$datas = $this->datas;
		$this->datas = array_merge( $datas , $arr);
	}
	
	public function get_datas( $key = null ){
		
		if ( $key === null ){
			return $this->datas;
		} elseif ( array_key_exists( $key, $this->datas) ) {
			return $this->datas[$key];

		} else {
			return false;
		}
	
	}
}

function wpwqjqa_init_localize(){
	global $wpwqjqa_localize;
	$wpwqjqa_localize = new Wpwqjqa_localize();
}
add_action( 'admin_init', 'wpwqjqa_init_localize' , 3);
add_action( 'init', 'wpwqjqa_init_localize' , 3);


?>