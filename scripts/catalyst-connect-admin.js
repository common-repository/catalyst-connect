/****************************
 * Catalyst Connect Javascript
 *
 */
jQuery(document).ready(function($) {

	$('#disable_buddypress_connect_css').change(function() {
		var disable_buddypress_connect_css = $('#disable_buddypress_connect_css:checked').val();
		if( disable_buddypress_connect_css ) {
			$('#disable-buddypress-connect-css-code').animate({"height": "show"}, { duration: 0 });
		} else {
			$('#disable-buddypress-connect-css-code').animate({"height": "hide"}, { duration: 0 });
		}
	});
	
	$('#disable_buddypress_connect_css').change();

	$('#disable_bbpress_connect_css').change(function() {
		var disable_bbpress_connect_css = $('#disable_bbpress_connect_css:checked').val();
		if( disable_bbpress_connect_css ) {
			$('#disable-bbpress-connect-css-code').animate({"height": "show"}, { duration: 0 });
		} else {
			$('#disable-bbpress-connect-css-code').animate({"height": "hide"}, { duration: 0 });
		}
	});
	
	$('#disable_bbpress_connect_css').change();

	$('#disable_woocommerce_connect_css').change(function() {
		var disable_woocommerce_connect_css = $('#disable_woocommerce_connect_css:checked').val();
		if( disable_woocommerce_connect_css ) {
			$('#disable-woocommerce-connect-css-code').animate({"height": "show"}, { duration: 0 });
		} else {
			$('#disable-woocommerce-connect-css-code').animate({"height": "hide"}, { duration: 0 });
		}
	});
	
	$('#disable_woocommerce_connect_css').change();

	$('#buddypress-css-examples-show').click(function() {
		$('#buddypress-css-examples').animate({"height": "toggle"}, { duration: 0 });
	});

	$('#bbpress-css-examples-show').click(function() {
		$('#bbpress-css-examples').animate({"height": "toggle"}, { duration: 0 });
	});

	$('#woocommerce-css-examples-show').click(function() {
		$('#woocommerce-css-examples').animate({"height": "toggle"}, { duration: 0 });
	});

});