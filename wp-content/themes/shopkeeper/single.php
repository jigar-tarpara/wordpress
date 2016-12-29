<?php get_header(); ?>

	<div id="primary" class="content-area blog-single 11">
        
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
	
				<?php get_template_part( 'content', get_post_format() ); ?>
				
	
				<?php shopkeeper_content_nav( 'nav-below' ); ?>
	
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>
	
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
        
                <div style="" class="row normal_height vc_row wpb_row vc_row-fluid email_newsletter vc_custom_1448270194273"><div class="newsletter_left wpb_column vc_column_container vc_col-sm-3"><div class="wpb_wrapper">
            <div class="wpb_single_image wpb_content_element vc_align_center">
                
                <figure class="wpb_wrapper vc_figure">
                    <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="382" height="198" src="https://test2.upfit.de/wp-content/uploads/sites/23/2015/11/newsletter_left1.png" class="vc_single_image-img attachment-full" alt="newsletter_left"></div>
                </figure>
            </div>
        </div></div><div class="newsletter_center wpb_column vc_column_container vc_col-sm-6"><div class="wpb_wrapper"><h2 style="font-size: 36px;color: #162c5d;text-align: center" class="vc_custom_heading main-hedding">Kostenlose Tipps &amp; Rabatte</h2>
            <div class="wpb_content_element  sub_headding">
                <div class="wpb_wrapper">
                    <p>Bleibe auf dem Laufenden und erhalte kostenlose Tipps und Tricks, Infos zu neuen Programmen sowie Rabattaktionen. </p>
        
                </div> 
            </div> 
            <div class="wpb_raw_code wpb_content_element wpb_raw_html">
                <div class="wpb_wrapper">
                    <!-- Begin MailChimp Signup Form -->
        <div id="mc_embed_signup" class="form mc4wp-form">
        <form action="//upfit.us10.list-manage.com/subscribe/post?u=9dbd4ef5899238712edccd39a&amp;id=236f1cc04c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate="novalidate">
            
        <p class="mc4wp-form-email">
            <input type="email" value="" name="EMAIL" class="fir_inp inp tooltipstered" id="list_email" placeholder="Emailadresse eingeben...">
            <input type="submit" value="Kostenlos registrieren" name="subscribe" id="register_email">
            <i class="arrow_icon"></i>
            <span class="email_err"></span>
        </p>
        </form>
        </div>
        <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot 
        
        <!--End mc_embed_signup-->
                </div>
            </div>
        
            <div class="wpb_raw_code wpb_raw_js">
                <div class="wpb_wrapper">
                    
        <script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script><script type="text/javascript">(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                </div>
            </div>
        </div></div><div class="newsletter_right wpb_column vc_column_container vc_col-sm-3"><div class="wpb_wrapper">
            <div class="wpb_single_image wpb_content_element vc_align_center">
                
                <figure class="wpb_wrapper vc_figure">
                    <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="389" height="226" src="https://test2.upfit.de/wp-content/uploads/sites/23/2015/11/newsletter_right1.png" class="vc_single_image-img attachment-full" alt="newsletter_right"></div>
                </figure>
            </div>
        </div></div></div>
           
    </div><!-- #primary -->

<?php get_footer(); ?>
