<?php
/*
 * WAT
 * @author   KannanC
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('WAT')) {

    class WAT
    {
	private  $wp_df_menu;
	private  $wp_df_submenu;
	private $wps_options = 'wat_options';
	private $wps_menuorder_options = 'wat_menuorder';

	public function __construct()
	{
	    $this->generateOptions();
	    add_action('admin_menu', array($this, 'wps_sub_menus'));
	    add_action('admin_init', array($this, 'initialize_defaults'), 19);
	    add_action('admin_init', array($this, 'customize_admin_menu'), 29);
            
                        add_action( 'admin_head', array($this, 'maincssStyles'), 999 );
                        add_action( 'login_head', array($this, 'logincssStyles') );
	    add_filter('custom_menu_order', array($this, 'wpsCustommenusort'));
	    add_filter('menu_order', array($this, 'wpsCustommenusort'));

	    add_filter('admin_title', array($this, 'custom_admin_title'), 999, 2);	
	    add_action( 'init', array($this, 'initFunctionss') );
	    
	    add_action( 'admin_bar_menu', array($this, 'add_wpshapere_menus'), 1 );
	    add_action( 'admin_bar_menu', array($this, 'add_wpshapere_nav_menus'), 99);
	    add_action('wp_dashboard_setup', array($this, 'widget_functions'));
	    if ( ! has_action( 'login_enqueue_scripts', array($this, 'wpshapereloginAssets') ) )
		   add_action('login_enqueue_scripts', array($this, 'wpshapereloginAssets'), 10);
	    add_action( 'admin_enqueue_scripts', array($this, 'wpshapereAssets'), 99999 );
	    add_action('wp_before_admin_bar_render', array($this, 'wps_remove_bar_links'), 0);
	    add_filter('login_headerurl', array($this, 'wpshapere_login_url'));
	    add_filter('login_headertitle', array($this, 'wpshapere_login_title'));
	    add_action('admin_head', array($this, 'generalFns'), 99);    
	    
	    add_action( 'admin_bar_menu', array($this, 'update_avatar_size'), 999 );
	    add_action('plugins_loaded',array($this, 'download_settings'));
	    add_action('login_footer', array($this, 'login_footer_content'), 1);
		
	    add_action('wp_head', array($this, 'frontendActions'), 99999);
                        add_action('tf_wat_options_saved_wat', array($this, 'importWattheme'));
	}
	
	public function initialize_defaults()
                    {
	    global $menu, $submenu;
	    $this->wp_df_menu = $menu;
	    $this->wp_df_submenu = $submenu;
	}

	public function is_wps_single()
                    {
	    if(!is_multisite())
		return true;
	    elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL'))
		return true;
	    else return false;
	}
                    
                    function importWattheme() {
                        if(isset($_POST['wat_import_theme']) && $_POST['wat_import_theme']) {
                            //initialize WAT themes
                            $get_wat_themes = new WPSTHEMES();
                            $wat_themes = $get_wat_themes->get_wat_themes();
                            
                            $theme_selected = trim($_POST['wat_import_theme']);
                            
                            $get_wps_options_default = $this->get_wps_option_data('wat_options');
                            $get_wps_options_color = unserialize(base64_decode($wat_themes[$theme_selected]));
                            $wps_color_theme_data = array_merge($get_wps_options_default, $get_wps_options_color);
                            $wps_color_theme_data = serialize($wps_color_theme_data);
                            if($this->is_wps_single()) {
                                    update_option($this->wps_options, $wps_color_theme_data);
                            }
                            else {
                                    update_site_option($this->wps_options, $wps_color_theme_data);
                            }
                        }
                    }

	public function initFunctionss()
                    {
                        if($this->get_wps_option('disable_auto_updates') === true)
                            add_filter( 'automatic_updater_disabled', '__return_true' );

                        if($this->get_wps_option('disable_update_emails') === true)
                                add_filter( 'auto_core_update_send_email', '__return_false' );
                
                        if(null !== $this->get_wps_option('hide_profile_color_picker') && $this->get_wps_option('hide_profile_color_picker') === true) {
                                remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
                        }		
                        register_nav_menus(array(			
                                'wpshapere_adminbar_menu' => 'Adminbar Menu'
                        ));			
	}

	public function wpshapereloginAssets()
	{	
                        wp_enqueue_script("jquery");
                        wp_enqueue_script( 'loginjs-js', WAT_DIR_URI . 'assets/js/loginjs.js', array( 'jquery' ), '', true );
	}
	public function wpshapereAssets($nowpage) 
	{
	    wp_enqueue_style( 'dashicons' );
	    wp_enqueue_style('fontAwesome-css', WAT_DIR_URI . 'assets/font-awesome/css/font-awesome.min.css', '', WAT_VERSION);
	    wp_enqueue_style('wpshapereMain-css', WAT_DIR_URI . 'assets/css/wat.styles.css', '', WAT_VERSION);
	    wp_enqueue_script( 'jquery-ui-core' );
	    wp_enqueue_script( 'jquery-ui-sortable' );
                        if($this->get_wps_option('admin_menu_type') == 'menusl') {
                            wp_enqueue_style('wat-perfect-scrollbar', WAT_DIR_URI . 'assets/css/perfect-scrollbar.css', '', WAT_VERSION);
                            wp_enqueue_script( 'wat-scrollbar', WAT_DIR_URI . 'assets/js/perfect-scrollbar.jquery.js', array( 'jquery' ), '', true );
                            wp_enqueue_script( 'wat-slidingmenu', WAT_DIR_URI . 'assets/js/sliding.js', array( 'jquery' ), '', true );
                        }
		//wp_enqueue_script( 'wat-scrollbar', WAT_DIR_URI . 'assets/js/jquery.scrollbar.js', array( 'jquery' ), '', true );
	    wp_enqueue_script( 'wat-scriptjs', WAT_DIR_URI . 'assets/js/script.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'wat-prettify', WAT_DIR_URI . 'assets/js/prettify/prettify.js', array( 'jquery' ), '', true );
                        if($nowpage == 'toplevel_page_wat-options') {	
                            wp_enqueue_script( 'wat-livepreview', WAT_DIR_URI . 'assets/js/live-preview.js', array( 'jquery' ), '', true );
                        }
	    if($nowpage == 'wat-options_page_wps_admin_menuorder') {		   
		wp_enqueue_style('iconPicker-css', WAT_DIR_URI . 'includes/icon-picker/css/icon-picker.css', '', WAT_VERSION);
		wp_enqueue_script( 'iconPicker-js', WAT_DIR_URI . 'includes/icon-picker/js/icon-picker.js', array( 'jquery' ), '', true );
	    }
	}

	public function generateOptions()
	{
	    include 'wat-options.php';
	}//generate options fn

	public function generalFns() {
	    $screen = get_current_screen();
                        $admin_generaloptions = $this->get_wps_option('admin_generaloptions');
	    if(!empty($admin_generaloptions)) {
                            foreach($admin_generaloptions as $general_opt) {
                                    if(isset($screen) && $general_opt == 1) {
                                            $screen->remove_help_tabs();
                                    }
                                    elseif($general_opt == 2) {
                                            add_filter('screen_options_show_screen', '__return_false');
                                    }
                                    elseif($general_opt == 3) {
                                            remove_action('admin_notices', 'update_nag', 3);
                                    }
                                    elseif($general_opt == 4) {
                                            remove_submenu_page('index.php', 'update-core.php');
                                    }
                            }
	    }
	    //footer contents
	    add_filter( 'admin_footer_text', array($this, 'wpsbrandFooter') );
	    //remove wp version
	    add_filter( 'update_footer', array($this, 'wpsremoveVersion'), 99);
                        
	    //prevent access to wpshapere menu for non-superadmin
	    if( (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') ){
		if($screen->id == "toplevel_page_wpshapere-options" || $screen->id == "wpshapere-options_page_wps_admin_menuorder" || $screen->id == "wpshapere-options_page_wps_impexp_settings") {
		    wp_die("<div style='width:70%; margin: 30px auto; padding:30px; background:#fff'><h4>Sorry, you don't have sufficient previlege to access to this page!</h4></div>");
		    exit();
		}
	    }
	?>
<script type="text/javascript">
    jQuery(function() {
            jQuery("input[name='wat_show_all_menu_to_admin']").change(function(){
                    if (jQuery(this).val() === '2') {
                            jQuery('tr.wat_privilege_users').css('display', 'table-row');
                    }             
                    else {
                            jQuery('tr.wat_privilege_users').css('display', 'none');
                    }
            });
    });
</script>

		<?php
	}
        
        public function maincssStyles() {
            include_once 'wat-main.css.php';
        }
        
        public function logincssStyles() {
            include_once 'wat-login.css.php';
        }
        
        public function watCompresscss($css) {
            $cssContents = "";
            // Remove comments
            $cssContents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
            // Remove space after colons
            $cssContents = str_replace(': ', ':', $cssContents);
            // Remove whitespace
            $cssContents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $cssContents);
            return $cssContents;
        }

        public function custom_admin_title($admin_title, $title)
	{
	    return get_bloginfo('name') . " &#45; " . $title;
	}
	
	public function custom_email_addr($email){
		if($this->get_wps_option('email_settings') == 1)
			return get_option('admin_email');
		else return $this->get_wps_option('email_from_addr');
	}
	
	public function custom_email_name($name){
		if($this->get_wps_option('email_settings') == 1)
			return get_option('blogname');
		else return $this->get_wps_option('email_from_name');
	}

	public function wps_sub_menus() 
	{
	    //add options page to sort and remove admin menus.
	    add_submenu_page( 'wat-options', 'WAT Options - Customize Admin Menus', 'Customize Admin Menus', 'manage_options', 'wps_admin_menuorder', array($this,'wpsmenuOrder') );
	    add_submenu_page( 'wat-options', 'WAT Options - Import and Export Settings', 'Import-Export Settings', 'manage_options', 'wps_impexp_settings', array($this, 'wpsexportSettings') );
		
	    //Remove wat menu
	    $get_blogid = get_current_blog_id();
	    if( defined('HIDE_WAT_OPTION_LINK') || (defined('NETWORK_ADMIN_CONTROL') && $get_blogid != 1) || (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') )
		    remove_menu_page('wat-options');
	}

	public function wpsmenuOrder() 
	{
	    global $menu, $submenu;
	    $wps_sorteddmenu = $this->get_wps_option_data($this->wps_menuorder_options);
	    $submenu_sort_exists = $wps_sorteddmenu['index.php_sbchild'];
	    echo '<div class="wrap titan-framework-panel-wrap"><h2>Customize Admin Menus</h2><div id="message" class="updated below-h2"><p>By default, all menu items will be shown to administrator users. <a href="' . admin_url() .'admin.php?page=wat-options&tab=general_options#wat_show_all_menu_to_admin2"><strong>Click here</strong></a> to customize who can access to all menu items.</p></div><div class="wps_menu_order">';
	    echo '<form class="menu_sort_form" name="menu_sort" method="post" action="">';
	    echo '<ol class="sortable sortUls" id="menu_sortable_left">';
	    $menu_num = 0;

	    $parItems = $this->wp_df_menu; 
	    
	    foreach ($parItems as $k => $menuItem) {
		$menu_num++;
		if(!empty($menuItem[0])) {
		    $menu_slug = $menuItem[2];
		    $get_menu_name = explode("<span", $menuItem[0]);
		    $menu_name = (empty($get_menu_name[0])) ? $menu_slug : $get_menu_name[0];
		    $wps_clean_name = $this->wps_clean_name($get_menu_name[0]);
		    $wps_menu_data = (isset($wps_sorteddmenu[$wps_clean_name])) ? $wps_sorteddmenu[$wps_clean_name] : NULL; //print_r($wps_menu_data);
		    $menu_hide = ($wps_menu_data[3] == "hide") ? "checked='checked'" : "";
		    $custom_menu_label = (isset($wps_menu_data[0])) ? $wps_menu_data[0] : "";
		    $custom_menu_icon = (isset($wps_menu_data[2])) ? $wps_menu_data[2] : "";
		    $custom_icon = (isset($custom_menu_icon)) ? explode("|", $custom_menu_icon) : "";
                                            echo '<li><div class="menuDiv">';
                                            echo '<div class="menu_handle">' . $menu_name . '<a href="" id="' . $menu_num . '" class="admin_menu_edit"></a>';
                                            echo '<a href="" title="Click to show/hide children" id="' . $menu_num . '" class="disclose plus"></a>';
                                            echo '</div>';
                                            echo '<div style="display:none;" class="menu_edit_content" id="menu_edit_'.$menu_num.'">';
                                            echo '<input type="hidden" name="parentmenu_item['.$menu_num.']" value="'.$wps_clean_name.'^' . $menu_slug . '^' . $menu_num . '" />';
                                            //menu name
                                            echo '<input type="hidden" name="menu_item_name['.$menu_num.']" value="'.$wps_clean_name.'" />';
                                            //custom label
                                            echo '<div class="menu_edit_wrap"><label>Rename Label</label><input autocomplete="off" type="text" class="widefat edit-menu-item-title" name="menu_item_label['.$menu_num.']" value="'. $custom_menu_label .'" /></div>';
                                            //custom icon
                                            echo '<div class="menu_edit_wrap"><input class="regular-text" type="hidden" id="menu_icon_picker_'.$menu_num.'" name="menu_item_icon['.$menu_num.']" value="'.$custom_menu_icon.'"/>
                                            <label for"icon_picker">Choose Icon</label><div id="" data-target="#menu_icon_picker_'.$menu_num.'" class="icon-picker ';
                                            if(isset($custom_icon[0])) echo $custom_icon[0] . " "; if(isset($custom_icon[1])) echo $custom_icon[1];
                                            echo '"></div></div>';
                                            //Show/Hide Link
                                            echo '<div class="menu_edit_wrap"><input type="checkbox"' . $menu_hide . ' class="widefat edit-menu-item-title" name="menu_item_hide['.$menu_num.']" value="hide" /> <label>Hide Link</label></div>';
                                            echo  '</div></div>';
	
	//Populating sub menu items
	$subItems = (isset($this->wp_df_submenu[$menuItem[2]])) ? $this->wp_df_submenu[$menuItem[2]] : ""; //print_r($subItems);
	if(isset($subItems) && !empty($subItems)) {
	    echo '<ol id="child_' . $menu_num . '">';
	    foreach($subItems as $subItem_key => $subItem){
		$menu_num++;
		$submenu_name = explode("<span", $subItem[0]);
			$submenu_name = trim($submenu_name[0]);
			$wps_clean_subname = $this->wps_clean_name($submenu_name);
			$sbmenu_custom_label = (isset($wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem[2]][1])) ? $wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem[2]][1] : ""; //print_r($subItem);
			$sbmenu_hide = (isset($wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem[2]][3])) ? $wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem[2]][3] : "";
			$arr_num = $subItem_key;
			
		$sbmenu_chk_val = (isset($sbmenu_hide) && $sbmenu_hide == 'hide') ? "checked='checked'" : "";
		echo '<li id="'. $wps_clean_subname .'_'.$menu_num.'"><div class="menu_handle">'. $submenu_name . '<a href="" id="' . $menu_num . '" class="admin_menu_edit"></a></div>';
		echo '<div style="display:none;" class="menu_edit_content" id="menu_edit_'.$menu_num.'">';
		//custom label
		echo '<div class="menu_edit_wrap"><label>Rename Label</label><input type="text" class="widefat edit-menu-item-title" name="' . $wps_clean_name . '_child_label['.$arr_num.']" value="'. $sbmenu_custom_label .'" /></div>';
		echo '<div class="menu_edit_wrap"><input type="checkbox" '. $sbmenu_chk_val . ' class="widefat edit-menu-item-title" name="' . $wps_clean_name . '_child_hide['.$arr_num.']" value="hide" /> <label>Hide Link</label></div>';
		echo '<input type="hidden" name="'. $wps_clean_name .'_child['. $subItem_key .']" value="' . $submenu_name . "^" . $subItem[2] . '^' . $subItem_key . '" />';
		echo '</div></li>';
	    }
	    echo '</ol>';
	}
	
	echo '</li>'; //close of parent list
		   
		}
	    }

	    echo '</ol>';
	 
	    wp_nonce_field('wps_admin_custommenu_nonce','wps_admin_custommenu_field');
	    echo '<br /><input name="save_sorting" class="button button-primary button-hero" type="submit" value="Save Customization" /><br /><br /><input class="button action" type="submit" name="reset_sorting" value="Reset Customization" onClick="return confirm(\'Do you really want to Reset?\');" />
	    </form>';
	    echo '</div></div>';	

	}
	
	public function customize_admin_menu(){
	    global $menu, $submenu;
	    $wps_sorteddmenu = $this->get_wps_option_data($this->wps_menuorder_options);
	    $privilege_users = $this->get_wps_option('privilege_users'); 
	    $user_id = get_current_user_id();
	    $submenu_sort_exists = $wps_sorteddmenu['index.php_sbchild'];
	    if(isset($menu) && !empty($menu)){
	    foreach ($menu as $menu_key => &$menu_value)
		{

			$menuId = explode('<span', $menu_value[0]); 
			$cleanLabel = $this->wps_clean_name($menuId[0]);
			$getMenudata = (isset($wps_sorteddmenu[$cleanLabel])) ? $wps_sorteddmenu[$cleanLabel] : NULL;
			$menu_value[5] = ""; //removing list ID in order to override icons set by other plugins
			if($menu_value[4] != 'wp-menu-separator' && !preg_match("/separator/i",$menu_value[4])){
				if(is_super_admin()) {
					if($this->get_wps_option('show_all_menu_to_admin') == 2 && !in_array($user_id, $privilege_users) && $getMenudata[3] == "hide")
						unset($menu[$menu_key]);
				}
				elseif(!is_super_admin() && $getMenudata[3] == "hide")
					unset($menu[$menu_key]);

				if(!empty($getMenudata[0])) $menu_value[0] = trim($getMenudata[0]);
				$getIcondata = explode("|", $getMenudata[2]); 
				$wps_icon_class = ' wps_icon_' . $cleanLabel;
				$iconType = explode("|", $getMenudata[2]);
				if($iconType[0] == "dashicons")
					$menu_value[6] = trim($iconType[1]);
				else {			
					$menu_value[4] = $menu_value[4] . $wps_icon_class;
				}

				//customize sub menu items
				if(isset($submenu[$menu_value[2]]) && !empty($submenu_sort_exists)){
					foreach ($submenu[$menu_value[2]] as $submenu_key => &$submenu_val){
						$sbmenu_label = (isset($wps_sorteddmenu[$menu_value[2] .'_sbchild'][$submenu_val[2]][1])) ? $wps_sorteddmenu[$menu_value[2] .'_sbchild'][$submenu_val[2]][1] : "";
						$sbmenu_hide = (isset($wps_sorteddmenu[$menu_value[2] .'_sbchild'][$submenu_val[2]][3])) ? $wps_sorteddmenu[$menu_value[2] .'_sbchild'][$submenu_val[2]][3] : "";
						if(is_super_admin()) {
							if($this->get_wps_option('show_all_menu_to_admin') == 2 && !in_array($user_id, $privilege_users) && $sbmenu_hide == "hide")
							unset($submenu[$menu_value[2]][$submenu_key]);
						}
						if(!is_super_admin() && $sbmenu_hide == "hide")
							unset($submenu[$menu_value[2]][$submenu_key]);

						if(!empty($sbmenu_label)) $submenu_val[0] = trim($sbmenu_label);
					}
				}		

			}
	    }
	  }
	}

	public function wpsCustommenusort($menu_ord) 
	{
	    $wps_sorteddmenu = $this->get_wps_option_data($this->wps_menuorder_options);
	    if(!empty($wps_sorteddmenu)) {
		if (!$menu_ord) return true;
		$custom_order = array();
		foreach ($wps_sorteddmenu as $sorted_menu_key => $sorted_menu_values) {
		    if(strpos($sorted_menu_key, '_sbchild') === false)
			$custom_order[] = $sorted_menu_values[1];
		}
		return $custom_order;
	    } 
	    else return array(
		    'index.php', 'separator1',
	    );
	}

	public function wpsexportSettings()
	{
		echo '<div class="wrap titan-framework-panel-wrap"><h2>Export Settings <span>Save the below contents to a text file.</span></h2><div style="padding:15px">';
		echo '<textarea class="widefat" rows="10" >' . $this->wps_settings() . '</textarea>';
		echo '</div>';
		echo '<h2>Import Settings</h2>';
		if(isset($_GET['page']) && $_GET['page'] == 'wps_impexp_settings' && isset($_GET['status']) && $_GET['status'] == 'updated')
			echo '<div class="updated top"><p><strong>Settings Imported.</strong></p></div>';
		echo '<div style="padding:15px">';
		echo '<form name="wpsimport_settings" method="post" action="" enctype="multipart/form-data">
			<input type="hidden" name="wps_import_settings" value="1" />
			<textarea class="widefat" name="wps_import_settings_data" rows="10" ></textarea><br /><br />
			<input class="button button-primary button-hero" type="submit" value="Import Settings" />';
		wp_nonce_field('wps_import_settings_nonce','wps_import_settings_field');
		echo '</form>		
		';
		echo '</div></div>';	
	}

	public function download_settings()
	{
                                load_plugin_textdomain( 'wat', false, WAT_PATH . '/languages/' );
		if(isset($_POST['wps_import_settings_field']) ) {
			if(!wp_verify_nonce( $_POST['wps_import_settings_field'], 'wps_import_settings_nonce' ) )
				exit();
			$imp_settings_data = trim($_POST['wps_import_settings_data']);
			if(empty($imp_settings_data)) {
				wp_safe_redirect( admin_url( 'admin.php?page=wps_impexp_settings&status=fileerror' ) ); 
				exit();				
			}

			if(!empty($imp_settings_data)) {
				$decodeddata = base64_decode($imp_settings_data);
				$datacontent = explode("---nnn---", $decodeddata);
				$wpshapere_options_data = trim($datacontent[0]);
				$wpsmenuorder_data = trim($datacontent[1]);
				if($this->is_wps_single()) {
				    update_option($this->wps_options, $wpshapere_options_data);
				    update_option($this->wps_menuorder_options, $wpsmenuorder_data);
				}
				else {
				    update_site_option($this->wps_options, $wpshapere_options_data);
				    update_site_option($this->wps_menuorder_options, $wpsmenuorder_data);
				}
				wp_safe_redirect( admin_url( 'admin.php?page=wps_impexp_settings&status=updated' ) ); 
				exit();
			}
		}
		
		if(isset($_POST['wps_admin_custommenu_field']) ) {
			if(!wp_verify_nonce( $_POST['wps_admin_custommenu_field'], 'wps_admin_custommenu_nonce' ) )
			    exit();
			if(isset($_POST['save_sorting'])) {
				$wpsmenuOrder = array();
				foreach($_POST['parentmenu_item'] as $parentMenu){
					$split_parent = explode("^", $parentMenu);
					$menuName = $this->wps_clean_name($split_parent[0]);
					$custom_label = isset($_POST['menu_item_label'][$split_parent[2]]) ? $_POST['menu_item_label'][$split_parent[2]] : null;
					$custom_icon = isset($_POST['menu_item_icon'][$split_parent[2]]) ? $_POST['menu_item_icon'][$split_parent[2]] : null;
					$menu_hide = isset($_POST['menu_item_hide'][$split_parent[2]]) ? $_POST['menu_item_hide'][$split_parent[2]] : null;
					$wpsmenuOrder[$menuName] = array($custom_label, $split_parent[1], $custom_icon, $menu_hide);

					//sub menu items
					$childname = $menuName . '_child';
					$childlabel = $menuName . '_child_label';
					$childhide = $menuName . '_child_hide';
					unset($wpssubmenuOrder);
					$wpssubmenuOrder = array();
					if(isset($_POST[$childname])){
						foreach($_POST[$childname] as $childMenu){
							$sb_key = explode("^", $childMenu);
							$subcustom_label = (isset($_POST[$childlabel][$sb_key[2]])) ? trim($_POST[$childlabel][$sb_key[2]]) : "";
							$submenu_hide = (isset($_POST[$childhide][$sb_key[2]])) ? trim($_POST[$childhide][$sb_key[2]]) : "";
							$wpssubmenuOrder[$sb_key[1]] = array($sb_key[0], $subcustom_label, $sb_key[2], $submenu_hide);
						}
					}
					$subMenu_slug = trim($split_parent[1]);
					$wpsmenuOrder[$subMenu_slug . '_sbchild'] = $wpssubmenuOrder;
				}

				$custom_admin_menu_order = serialize($wpsmenuOrder);
				if($this->is_wps_single())
					update_option($this->wps_menuorder_options, $custom_admin_menu_order);
				else 
					update_site_option($this->wps_menuorder_options, $custom_admin_menu_order);
			}
			elseif(isset($_POST['reset_sorting'])) {
				if($this->is_wps_single())
					update_option($this->wps_menuorder_options, '');
				else 
					update_site_option($this->wps_menuorder_options, '');
			}
		}
	}
	
	public function wps_settings() {
		if($this->is_wps_single())
			$settings_data = get_option($this->wps_options) . "---nnn---" . get_option($this->wps_menuorder_options);
		else
			$settings_data = get_site_option($this->wps_options) . "---nnn---" . get_site_option($this->wps_menuorder_options);
		return base64_encode($settings_data);
	}

	public function login_footer_content()
	{
	        $login_footer_content = $this->get_wps_option('login_footer_content');
		echo '<div class="login_footer_content">';
		if(!empty($login_footer_content)) echo $this->get_wps_option('login_footer_content');
		echo '</div>';
	}

	public function wpsbrandFooter() 
	{
		echo $this->get_wps_option('admin_footer_txt');
	}

	public function wpsremoveVersion()
	{
		return '';
	}

	//admin bar customization
	public function wps_remove_bar_links() 
	{
                            global $wp_admin_bar;
                            $hide_admin_bar_menus = $this->get_wps_option('hide_admin_bar_menus');
                            $wp_admin_bar->remove_menu('view');
                            if(isset($hide_admin_bar_menus)){
                                    foreach ($hide_admin_bar_menus as $hide_bar_menu) {
                                        if($hide_bar_menu == 1)
                                                $wp_admin_bar->remove_menu('site-name');
                                        elseif($hide_bar_menu == 2)
                                                $wp_admin_bar->remove_menu('updates');
                                        elseif($hide_bar_menu == 3)
                                                $wp_admin_bar->remove_menu('comments');
                                        elseif($hide_bar_menu == 4)
                                                $wp_admin_bar->remove_menu('new-content');
                                        elseif($hide_bar_menu == 5)
                                                $wp_admin_bar->remove_menu('edit-profile');
                                        elseif($hide_bar_menu == 6)
                                                $wp_admin_bar->remove_menu('my-account');
                                        elseif($hide_bar_menu == 7)
                                                $wp_admin_bar->remove_menu('wp-logo');
                                    }
                            }
	}

	public function add_wpshapere_menus($wp_admin_bar) {
		$admin_logo = $this->get_wps_option('admin_logo');
		$admin_logo_url = $this->get_wps_option('admin_logo_url');
		if(!empty($admin_logo) || !empty($admin_logo_url)) {
			$wp_admin_bar->add_node( array(
				'id'    => 'wat_site_title',
				'title' => $this->get_wps_option('admin_title'),
				'href'  => get_site_url(),
				'meta'  => array( 'class' => 'wat_site_title' )
			) );
		}
	}

	public function add_wpshapere_nav_menus($wp_admin_bar)
	{
		//add Nav items to adminbar
		if( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'wpshapere_adminbar_menu' ] ) ) {

			$custom_nav_object = wp_get_nav_menu_object( $locations[ 'wpshapere_adminbar_menu' ] );
			if(!isset($custom_nav_object->term_id))
				return;
			$menu_items = wp_get_nav_menu_items( $custom_nav_object->term_id );

			foreach( (array) $menu_items as $key => $menu_item ) {		
				if( $menu_item->classes ) {		
					$classes = implode( ' ', $menu_item->classes );		
				} else {		
					$classes = "";		
				}		
				$meta = array(
					'class' 	=> $classes,
					'target' 	=> $menu_item->target,
					'title' 	=> $menu_item->attr_title
				);		
				if( $menu_item->menu_item_parent ) {		
					$wp_admin_bar->add_node(
						array(
						'parent' 	=> $menu_item->menu_item_parent,
						'id' 		=> $menu_item->ID,							
						'title' 	=> $menu_item->title,
						'href' 		=> $menu_item->url,
						'meta' 		=> $meta
						)
					);		
				} else {		
					$wp_admin_bar->add_node(
						array(
						'id' 		=> $menu_item->ID,
						'title' 	=> $menu_item->title,
						'href' 		=> $menu_item->url,
						'meta' 		=> $meta
						)
					);
				}
			} //foreach
		} 
	}

	public function update_avatar_size( $wp_admin_bar ) {

		//update avatar size
		$user_id      = get_current_user_id();
		$current_user = wp_get_current_user();		
		if ( ! $user_id )
			return;		
		$avatar = get_avatar( $user_id, 36 );
		$howdy  = sprintf( __('Howdy, %1$s'), $current_user->display_name );
		$account_node = $wp_admin_bar->get_node( 'my-account' );		
		$title = $howdy . $avatar;
		$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'title' => $title
			) );

	}

	public function get_wps_option($option_id) {
	    return $this->watOptions->getOption( $option_id );
	}

	public function get_wps_option_data( $option_id ) {
	    if($this->is_wps_single())
		return unserialize(get_option($option_id));
	    else
		return unserialize(get_site_option($option_id));
	}

	public function get_wps_image_url($imgid, $size='full') {
	    global $switched, $wpdb;
			
	    if ( is_numeric( $imgid ) ) {
		if(!$this->is_wps_single()) {
                                            switch_to_blog(1);
                                            $imageAttachment = wp_get_attachment_image_src( $imgid, $size );
                                            restore_current_blog();
                                        }
		else $imageAttachment = wp_get_attachment_image_src( $imgid, $size );
                                            
                                        return $imageAttachment[0];
	    } 
	}

	public function wpshapere_login_url()
	{
		$login_logo_url = $this->get_wps_option('login_logo_url');
		if(empty($login_logo_url))
			return site_url();
		else return $login_logo_url;
	}
	public function wpshapere_login_title()
	{
		return get_bloginfo('name');
	}
	
	private function wps_clean_name($var){
		$variable = trim(strtolower($var));
		$variable = str_replace(" ", "_", $variable);
		return $variable;
	}

	public function widget_functions() {
		global $wp_meta_boxes;
		$remove_dash_widgets = $this->get_wps_option('remove_dash_widgets');

		//Removing unwanted widgets
		if(isset($remove_dash_widgets)) {
                                            foreach ($remove_dash_widgets as $rm_dash_widget) {
                                                    if($rm_dash_widget == 1)
                                                            remove_action('welcome_panel', 'wp_welcome_panel');
                                                    elseif($rm_dash_widget == 2)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
                                                    elseif($rm_dash_widget == 3)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
                                                    elseif($rm_dash_widget == 4)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
                                                    elseif($rm_dash_widget == 5)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
                                                    elseif($rm_dash_widget == 6)
                                                            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
                                                    elseif($rm_dash_widget == 7)
                                                            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
                                                    elseif($rm_dash_widget == 8)
                                                            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
                                                    elseif($rm_dash_widget == 9)
                                                            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
                                                    elseif($rm_dash_widget == 10)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
                                                    elseif($rm_dash_widget == 11)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
                                                    elseif($rm_dash_widget == 12)
                                                            unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
                                            }
		}

		//Creating new widgets
		$wps_widget_handle = array();
		for($i = 1; $i <= 4; $i++) {
                                            $wps_widget_handle['type'] = $this->get_wps_option( 'wps_widget_' . $i .'_type' );
                                            $wps_widget_handle['pos'] = $this->get_wps_option( 'wps_widget_' . $i .'_position' );
                                            $wps_widget_handle['title'] = $this->get_wps_option( 'wps_widget_' . $i .'_title' );
                                            $wps_widget_handle['content'] = do_shortcode($this->get_wps_option( 'wps_widget_' . $i .'_content' ));
                                            $wps_widget_handle['rss'] = $this->get_wps_option( 'wps_widget_' . $i .'_rss' );
                                            if(!empty($wps_widget_handle['title']) || !empty($wps_widget_handle['content']) || !empty($wps_widget_handle['rss']))
                                                    add_meta_box('wps_dashwidget_' . $i, $wps_widget_handle['title'], array($this, 'wps_display_widget_content'), 'dashboard', $wps_widget_handle['pos'], 'high', $wps_widget_handle);
		}
	}

	public function wps_display_widget_content($post, $wps_widget_handle)
	{
		if($wps_widget_handle['args']['type'] == 1) {
			echo '<div class="rss-widget">';  
			 wp_widget_rss_output(array(  
				  'url' => $wps_widget_handle['args']['rss'],
				  'items' => 5,
				  'show_summary' => 1,  
				  'show_author' => 1,  
				  'show_date' => 1  
			 ));  
			 echo "</div>";
		}
		else {
			echo $wps_widget_handle['args']['content'];
		}
	}
	
	public function wpsiconStyles(){
                            $wps_sorteddmenu = $this->get_wps_option_data('wat_menuorder');
                            $faicons = new WATFAICONS();
                            $faicons_data = $faicons->watFa_icons();
                            $icon_styles = "";
                            if(!empty($wps_sorteddmenu)){
                                    foreach($wps_sorteddmenu as $menu_data_key => $menu_data_val){
                                            $sel_icon = (isset($menu_data_val[2])) ? $menu_data_val[2] : "";
                                            $icon_data = explode("|", $sel_icon);
                                            if( strpos($menu_data_key, '_sbchild') === false && $icon_data[0] == 'fa') {				
                                                    if(isset($icon_data[1]) && !empty($icon_data[1])){
                                                    $icon_styles .= '#adminmenu li.wps_icon_' . $menu_data_key . ' a.wps_icon_' . $menu_data_key . ' div.wp-menu-image:before {';
                                                    $icon_styles .= 'font-family: "FontAwesome" !important; content: "' . $faicons_data[$icon_data[1]] . '" !important';
                                                    $icon_styles .= '} ';
                                                    }
                                            }

                                    }
                            }
                            return $icon_styles;
	}
	
	public function frontendActions()
	{
	    //remove admin bar	
	    if($this->get_wps_option('hide_admin_bar') === true) {
		add_filter( 'show_admin_bar', '__return_false' );
		echo '<style type="text/css">html { margin-top: 0 !important; }</style>';
	    }
	    else {
?>
		<style type="text/css">
		#wpadminbar, #wpadminbar .menupop .ab-sub-wrapper { background: <?php echo $this->get_wps_option('admin_bar_color'); ?>;}
                                        #wpadminbar a.ab-item, #wpadminbar>#wp-toolbar span.ab-label, #wpadminbar>#wp-toolbar span.noticon { color: <?php echo $this->get_wps_option('admin_bar_menu_color'); ?> }
                                        #wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar .quicklinks .menupop ul li a:focus, #wpadminbar .quicklinks .menupop ul li a:focus strong, #wpadminbar .quicklinks .menupop ul li a:hover, #wpadminbar-nojs .ab-top-menu>li.menupop:hover>.ab-item, #wpadminbar .ab-top-menu>li.menupop.hover>.ab-item, #wpadminbar .quicklinks .menupop ul li a:hover strong, #wpadminbar .quicklinks .menupop.hover ul li a:focus, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar li .ab-item:focus:before, #wpadminbar li a:focus .ab-icon:before, #wpadminbar li.hover .ab-icon:before, #wpadminbar li.hover .ab-item:before, #wpadminbar li:hover #adminbarsearch:before, #wpadminbar li:hover .ab-icon:before, #wpadminbar li:hover .ab-item:before, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover, #wpadminbar li:hover .ab-item:after, #wpadminbar>#wp-toolbar a:focus span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar>#wp-toolbar li:hover span.ab-label { color: <?php echo $this->get_wps_option('admin_bar_menu_hover_color'); ?> }

                                        .quicklinks li.wpshape_site_title { width: 200px !important; }
                                        .quicklinks li.wpshape_site_title a{ outline:none; border:none;
                                        <?php if($this->is_wps_single()){
                                          $admin_logo_id = $this->get_wps_option('admin_logo');
                                          $admin_logo_url = $this->get_wps_image_url($admin_logo_id);
                                        }
                                        else $admin_logo_url = $this->get_wps_option('admin_logo_url');
                                        if(!empty($admin_logo_url)){ ?>
                                        background-image:url(<?php echo $admin_logo_url;  ?>) !important; background-repeat: no-repeat !important; background-position: center center !important; background-size: 70% auto !important; text-indent:-9999px !important; width: auto !important; 
                                        <?php } ?>
                                         }

                                        #wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar-nojs .ab-top-menu>li.menupop:hover>.ab-item, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li.menupop.hover>.ab-item, #wpadminbar .ab-top-menu>li.hover>.ab-item { background: none }
                                        #wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a { color: <?php echo $this->get_wps_option('admin_bar_menu_color'); ?>; font-size:13px !important }
                                        #wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img {	width: 20px; height: 20px; border-radius: 100px; -moz-border-radius: 100px; -webkit-border-radius: 100px; 	border: none; }
		</style>
		<?php
	    }
	}

	public static function deleteOptions()
	{
		//delete_option( $this->wps_options );
		//delete_option( $this->wps_menuorder_options );
	}
	
        }

}

$watclass = new WAT();
