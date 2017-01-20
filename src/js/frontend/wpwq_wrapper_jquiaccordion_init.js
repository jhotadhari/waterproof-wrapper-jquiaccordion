/*
	grunt.concat_in_order.declare('wpwq_wrapper_bxslider_init');
	grunt.concat_in_order.require('init');
*/

// jQuery(document).ready(function($bx) {

// 		if ( $bx( '.wpwq-query-wrapper.bxslider' ).length ) {
// 		var bxOptions;
// 		var unique;
// 		var unique_options;
// 		var key;
// 		var val;
		
// 		$bx( '.wpwq-query-wrapper.bxslider' ).each( function( index ) {
				
// 			// set dafault options
// 			bxOptions = Wpwq_wrapper_bxslider.global.bx_options;

			
// 			// get options from Wpwq_wrapper_bxslider
// 			unique = $bx( this ).attr('class').match(/\S*-unique\b/)[0].replace( '-unique', '');
// 			unique_options =  Wpwq_wrapper_bxslider[unique];
			
// 			// replace default options with options from Wpwq_wrapper_bxslider
// 			for ( key in unique_options ){
// 				if (unique_options.hasOwnProperty(key)) {
// 					if ( isNaN( unique_options[key] ) ){
// 						val = unique_options[key];
// 					} else {
// 						val =  parseFloat(unique_options[key]);
// 					}
// 					bxOptions[key] = val;
// 				}
// 			}
			
// 			$bx( this ).children( 'ul.bxslider' ).bxSlider( bxOptions );
// 		});
// 	}
		
// });

jQuery(function ($acc) {

		

	if ( $acc( '.wpwq-query-wrapper.jquiaccordion' ).length ) {

		var accOptions;
		var unique;
		var unique_options;
		var key;
		var val;
		
		$acc( '.wpwq-query-wrapper.jquiaccordion' ).each( function( index ) {
			// get unique
			unique = $acc( this ).attr('class').match(/\S*-unique\b/)[0].replace( '-unique', '');
			
			// set some options
			accOptions = {
				beforeActivate: function( event, ui ) {
					$acc('.ui-accordion-content.hasthumb').css('min-height','0px');
				},
				activate: function( event, ui ) {
					// $acc(this).children('.ui-accordion-header').find('.toggle').html('<span>' + unique_options.more + '</span>');
					// $acc(this).children('.ui-accordion-header-active').find('.toggle').html('<span>' + unique_options.close + '</span>');
					$acc('.ui-accordion-content-active.hasthumb').css('min-height','170px');
				}
			};
			
			// get global options
			for ( key in Wpwq_wrapper_jquiaccordion.global.acc_options ){
				if (Wpwq_wrapper_jquiaccordion.global.acc_options.hasOwnProperty(key)) {
					
					if ( isNaN( Wpwq_wrapper_jquiaccordion.global.acc_options[key] ) ){
						val = Wpwq_wrapper_jquiaccordion.global.acc_options[key];

					} else {
						val =  parseFloat(Wpwq_wrapper_jquiaccordion.global.acc_options[key]);
					}
					
					accOptions[key] = val;
				}
			}

			// get unique options
			unique_options =  Wpwq_wrapper_jquiaccordion[unique];

			for ( key in unique_options.acc_options ){
				if (unique_options.acc_options.hasOwnProperty(key)) {
					
					if ( isNaN( unique_options.acc_options[key] ) ){
						val = unique_options.acc_options[key];

					} else {
						val =  parseFloat(unique_options.acc_options[key]);
					}
					
					accOptions[key] = val;
				}
			}
			
			// init acc
			$acc( this ).accordion( accOptions );
			
			// $acc(this).children('.ui-accordion-header').append('<span class="toggle"><span>' + unique_options.more + '</span></span>');
			// $acc(this).children('.ui-accordion-header-active').find('.toggle').html('<span>' + unique_options.close + '</span>');
			
		});
	}
	
});