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
		
		$is_linked = ( array_key_exists('has_link', $this->args ) 
			&& $this->args['has_link'] == 'true' 
			&& strlen($query_single_obj['str_link']) > 0 
			&& strlen($query_single_obj['link']) > 0 
			? true 
			: false );

		$return = '';

		$header_tag = ( array_key_exists('header_tag', $this->args ) && strlen($this->args['header_tag']) > 0 ? $this->args['header_tag'] : 'h2' );
		$return .= '<div class="ui-accordion-header">';
			$return .= '<' . $header_tag . ' class="title">' . $query_single_obj['str_title'] . '</' . $header_tag . '>';
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