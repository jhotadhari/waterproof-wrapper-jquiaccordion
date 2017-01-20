<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_jquiaccordion_single');
	grunt.concat_in_order.require('init');
*/

class Wpwq_wrapper_jquiaccordion_single extends Wpwq_wrapper_single {
	
	function __construct( $name = null, $query_single_obj = null , $args = null, $args_single = null, $single_count = null ) {
		parent::__construct( $name, $query_single_obj , $args, $args_single, $single_count);
		$this->set_inner( $query_single_obj );
	}
		
	protected function set_inner( $query_single_obj ) {
		
		$is_linked = ( array_key_exists('has_link', $this->args ) && $this->args['has_link'] == 'true' && strlen($query_single_obj['str_link']) > 0 ? true : false );

		$return = '';

		$return .= '<div class="ui-accordion-header">';
			$return .= '<div class="title">' . $query_single_obj['str_title'] . '</div>';
		$return .= '</div>';
		
		if ( strlen($query_single_obj['image_url']) > 0 ){
			$class = ' hasthumb';
		} else {
			$class = '';
		}
		
		$return .= '<div class="' . $class . '">';
		if ( strlen($query_single_obj['image_url']) > 0 ) {
			
			if ( $is_linked ) {
				$return .= '<a href="' . $query_single_obj['link'] . '">';
			}

			$return .= '<div class="accimage">';
				$return .= $query_single_obj['image'];
			$return .= '</div>';
			
			if ( $is_linked ) {
				$return .= '</a>';

			}
		}
			
		$return .= $query_single_obj['str_inner'];
		
		if (
			// strlen($query_single_obj['str_count_subs'] > 0 ||
			$is_linked
		) {
						
			$return .= '<div  class="accmoreinfo">';
				
				// if ( strlen($query_single_obj['str_count_subs']) > 0 ){
				// 	$return .= '<span class="font-content">';
				// 		$return .= $query_single_obj['str_count_subs'];
				// 	$return .= '</span>';					
				// }
		
				$return .= '<a title="' . $query_single_obj['str_title'] . '" href="' . $query_single_obj['link'] . '">'
;
					$return .= '<h3>';
						$return .= $query_single_obj['str_link'];
					$return .= '</h3>';

				$return .='</a>';
					
			$return .= '</div>';
		}
	
		$return .= '</div>';
		
		$this->inner = $return;
		
	}
	
}

?>