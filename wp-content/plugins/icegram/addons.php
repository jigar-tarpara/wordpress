<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('body').on('click', '.icegram_add-ons_filter li', function(event){
		jQuery(this).parent().find('a').removeClass('current');
		jQuery(this).find('a').addClass('current');
		//detect which tab filter item was selected
		var selected_filter = jQuery(event.target).data('type');
		if(selected_filter !== 'all'){
			jQuery('.cd-gallery').find('li:not(".'+selected_filter+'")').fadeOut(100);
			jQuery('.cd-gallery').find('li.'+selected_filter).fadeIn(100);
		}else{
			jQuery('.cd-gallery').find('li').fadeIn(100);
		}
	});
    jQuery('.update-nag').hide();
});
</script>
<style>
.ig_addons_wrap .cd-tab-filter{
	display: inline-block;
	background-color: #FFF;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
	z-index: 1;
	padding: 0px 10px 8px 3px;
	font-size: 1.2em;
	width: 90%;
}
.ig_addons_wrap .cd-tab-filter ul{
  	background: rgba(0, 0, 0, 0);
	position: static;
	box-shadow: none;
	text-align: center;
 }
.ig_addons_wrap .filter a{
	margin:-5px 0 0 20px;
}
.ig_addons_wrap .filter a{
 	text-decoration: none;

 }
</style>
<?php

if ( empty($ig_addons) ) {
	$ig_addons = get_transient( 'icegram_addons_data' );
}
if ( empty($ig_addons) ) {
	$ig_addons = array();
}
	
?>
<div class="wrap ig_addons_wrap">
	<h2>
		<?php _e( 'Icegram Add-ons', 'icegram' ); ?>
	</h2>
	<div class="icegram_add-ons_filter wp-filter">
		<ul class="filter-links">
			<li data-filter="all"><a href="#" data-type="all"><?php _e( 'All', 'icegram' ); ?></a></li>
			<!-- <li data-filter="installed"><a href="#" data-type="installed"><?php _e( 'Installed', 'icegram' ); ?></a></li> -->
			<li data-filter="message-type"><a href="#" data-type="message-type"><?php _e( 'Message Type', 'icegram' ); ?></a></li>
			<li data-filter="themes"><a href="#" data-type="themes"><?php _e( 'Themes', 'icegram' ); ?></a></li>
			<li data-filter="targeting"><a href="#" data-type="targeting"><?php _e( 'Targeting', 'icegram' ); ?></a></li>
			<li data-filter="reporting"><a href="#" data-type="reporting"><?php _e( 'Reporting', 'icegram' ); ?></a></li>
		</ul>
	</div>

	<section class="cd-gallery">
		<ul class="addons">
			<?php
			if (count($ig_addons) > 0) {
				foreach ($ig_addons as $addon) {
					$class = (is_plugin_active($addon->slug)) ? 'installed' : '';
					?>
					<li class="addon <?php echo $class .' '. str_replace(',', ' ', $addon->category) ; ?>">
						<a href="<?php echo $addon->link;?>?utm_source=inapp&utm_campaign=addons&utm_medium=store" target="_blank">			
							<h3><?php echo '<span style="display:inherit;">'.$addon->name.'</span>'; 
							    ?>
							    <?php
							    if( !empty( $addon->image ) ) {
									  echo "<img src=".$addon->image.">";
								}?>
								<?php 
								if($class !== 'installed'){
							    	echo '<span class="addon_btn button button-small button-primary">'.__('Get This Addon','icegram').'</span>';
									
								}else{
									echo '<span class="pill">'.__('Already Installed','icegram').'</span>';
								}
								?>
							</h3>
							<p>
								<?php echo $addon->descripttion; ?>
							</p>
						</a>
					</li>
					<?php
				}
			} else {
				echo "<p>". __( 'Sorry! No Add-ons available currently.', 'icegram') . "</p>";
			}	
			?>
		</ul>
	</section>
</div>