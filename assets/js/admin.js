/**
 * Feature Name: JavaScripts
 * Descriptions: Adds the main javascript functions
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

( function( $ ) {
	var wpcd_admin = {
			
		// Pseudo-Constructor of this class
		init: function () {
			$( '.select2.search-products' ).select2( {
				placeholder: wpcd_admin_args.lang_search_for_product,
				minimumInputLength: 1,
				id: function( data ){ return data.product_id; },
				ajax: {
					url: ajaxurl + '?action=wcpd_get_products',
					dataType: 'json',
					quietMillis: 100,
					data: function ( term, page ) {
						return {
							q: term, // search term
						};
					},
					results: function ( data, page ) { // parse the results into the format expected by Select2.
						// since we are using custom formatting functions we do not need to alter the remote JSON data
						return { results: data };
					},
					cache: false,
				},
				initSelection: function( element, callback ) {
		        	var id = $( element ).val();
		        	if ( id.length != 0 ) {
			            $.ajax( ajaxurl + '?action=wcpd_get_product&product_id=' + id, {
			                dataType: "json"
			            } ).done( function( data ) { callback( data ); } );
		        	}
			    },
				formatResult: function( data ) {
					var markup = '<div class="row-fluid">' +
									'<div class="span10">' +
										data.product_title +
									'</div>' +
								 '</div>';
				 	return markup;
				},
    			formatSelection: function( data ) {
    				return data.product_title;
    			},
    			escapeMarkup: function (m) { return m; }
			} );
		},
	
	};
	
	$( document ).ready( wpcd_admin.init );
} )( jQuery );
