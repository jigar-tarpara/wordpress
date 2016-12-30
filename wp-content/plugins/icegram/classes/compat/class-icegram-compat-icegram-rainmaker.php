<?php
if ( !defined( 'ABSPATH' ) ) exit;
/**
* Icegram Campaign Admin class
*/
if ( !class_exists( 'Icegram_Compat_icegram_rainmaker' ) ) {
	class Icegram_Compat_icegram_rainmaker extends Icegram_Compat_Base {

		function __construct() {
			global $icegram; 
			parent::__construct();
		}

		function render_js() {
			?>
			<script type="text/javascript">
			jQuery(function() {
			  	jQuery( window ).on( "init.icegram", function(e, ig) {
				  	// Find and init all RM forms within Icegram messages/divs and init them
				  	if(ig){
					  	jQuery.each(ig.messages, function(i, msg){
					  		var form = jQuery(msg.el).find('form.rainmaker_form');
					  		if(form && !form.hasClass('ig_form_init_done')){
					  			form.rmInitForm();
					  			form.addClass('ig_form_init_done');
					  		}
					  	});
				  	}

			  	}); // init.icegram
				
				//Handle CTA function(s) after successful submission of form
			  	jQuery( window ).on('rm.success', function(e) {
			  		if( typeof icegram !== 'undefined'){
					  	var msg_id = (jQuery(e.target.closest('[id^=icegram_message_]')).attr('id') || '').split('_').pop() || 0 ;
		  				var ig_msg = icegram.get_message_by_id(msg_id) || undefined;
					  	if(ig_msg && ig_msg.data.cta === 'form_via_ajax'){
							var ajax_option = ig_msg.data.cta_option_form_via_ajax;
					  		var hide_after = 200;
					  		var response_text = ig_msg.data.response_text || ig_msg.el.find('.rm_form_message').html() || '';

							if(ig_msg.data.show_response == 'yes' && response_text !== ''){
								response_text = '<div class="ig_form_response_text">'+ response_text +'</div>';
								ig_msg.el.find('.rm_form_message').html(response_text);
								hide_after = 3000;
							}
							setTimeout(function(){
						  		if(ajax_option == 'redirect_to_link'){
						  			if (typeof(ig_msg.data.redirect_to_link) === 'string' && ig_msg.data.redirect_to_link != '' && !/^tel:/i.test(ig_msg.data.redirect_to_link)) {
									    if (!/^https?:\/\//i.test(ig_msg.data.redirect_to_link) ) {
									    	ig_msg.data.redirect_to_link = "http://" + ig_msg.data.redirect_to_link;
									    }
								    }
									(ig_msg.data.redirect_to_link != '') ? window.location.href = ig_msg.data.redirect_to_link : ig_msg.hide();
						  		}
								ig_msg.hide();
							}, hide_after);
						}
			  		}
				});

			});
			</script>

		<?php
		}
	}
}