<?php add_thickbox(); ?>

<div class="wrap about-wrap getbowtied-about-wrap">
	
    <?php require_once('global/pages-header.php'); ?>

	<div class="updated error importer-notice importer-notice-1" style="display: none;">
		<p><strong><?php echo __( "We're sorry but the demo data could not import. It is most likely due to low PHP configurations on your server.", 'getbowtied' ); ?></strong></p>
		<p><?php echo sprintf( __( 'Please use %s to factory reset your Wordpress , then come back and retry.', 'getbowtied' ), '<a href="' . admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=850&amp;height=450' . '" class="button-primary thickbox" title="">WordPress Reset Plugin</a>' ); ?></p>
	</div>

	<?php

	if ( class_exists( 'RegenerateThumbnails' ) ) :

		$regenerate_thumbnails_link = admin_url() . "tools.php?page=regenerate-thumbnails";
		$regenerate_thumbnails_class = "";
	
	else :

		$regenerate_thumbnails_link = admin_url() . "plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=850&amp;height=450";
		$regenerate_thumbnails_class = "thickbox";

	endif;

	?>
	
	<div class="updated importer-notice importer-notice-2" style="display: none;"><p><strong><?php echo __( "Good job! The demo data was successfully imported. You may need to", "getbowtied" ); ?> <a href="<?php echo $regenerate_thumbnails_link; ?>" class="<?php echo $regenerate_thumbnails_class; ?>" title=""><?php echo __( "regenerate your thumbnails", "getbowtied" ); ?></a>.</strong></p></div>

	<div class="getbowtied-themes-demo">
		<div class="theme-browser rendered">
			<div class="themes">

				<!-- Default -->
				<div class="theme">
					
					<div class="theme-screenshot">
						<img src="<?php echo $getbowtied_settings['demo_image']; ?>" alt="">
					</div>
					
					<h3 class="theme-name" id="default"><?php echo getbowtied_theme_name() . " - " . __( "Default Demo", "getbowtied" ); ?></h3>
					
					<div class="theme-actions">
						<?php printf( '<a class="button button-primary getbowtied-install-demo-button" data-demo-id="default" href="#">%1s</a>', __( "Install", "getbowtied" ) ); ?>
						<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', $getbowtied_settings['dummy_data_preview'], __( "Live Preview", "getbowtied" ) ); ?>
					</div>
					
					<div class="demo-import-loader preview-all"></div>
					
					<div class="demo-import-loader preview-default"><i class="dashicons dashicons-admin-generic"></i></div>
				
				</div>


			</div>
		</div>
	</div>

</div>

