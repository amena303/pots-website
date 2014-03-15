<?php

	//-- Actions
	//add_action('login_head', 'custom_adminLogin');
	add_action('admin_head', 'custom_adminHeader');
	//--
	add_action( 'login_enqueue_scripts', 'login_enqueue_scripts' );
	add_action('wp_print_scripts', 'disableAutoSave' );
	//-- Quitar Menus
	add_action( 'admin_menu', 'menu_remove_tools', 99 );
	//-- Hoook into the 'wp_dashboard_setup' action to register our function
	add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
	//-- Quitar bienvenida
	add_action('load-index.php', 'remove_welcome_panel');
	//-- Remover bar
	//add_action( 'init', 'fb_remove_admin_bar', 0 );
	//--
	add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );
	//--
	if ( !current_user_can( 'edit_users' ) ) :
		add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	endif;
	//--
	add_action('wp_before_admin_bar_render', 'wp_admin_bar_new_item');
	//-- Leer más
	//add_filter('excerpt_more', 'excerpt_leermas');
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	add_filter( 'excerpt_more', 'custom_excerpt_more' );
	//-- Filters - Menu
	//add_filter('wp_nav_menu','current_to_active');
	//add_filter('nav_menu_css_class', 'custom_wp_nav_menu');
	//add_filter('nav_menu_item_id', 'nav_id_filter', 10, 2 );
	//add_filter('page_css_class', 'custom_wp_nav_menu');
	//-- Filters - Misc
	add_filter('admin_footer_text', 'custom_adminFooter');
	add_filter('show_admin_bar', '__return_false' );
	add_filter('intermediate_image_sizes_advanced', 'set_thumbnail_size_by_post_type', 10);
	//add_filter('login_redirect', 'dashboard_redirect');
	//-- Quitar Menus
	add_action('admin_menu', 'remove_menus');
	//-- Cambiar envÃ­o de correo
	//add_filter('wp_mail_from', 'new_mail_from');
	//add_filter('wp_mail_from_name', 'new_mail_from_name');
	//-- Opciones de pÃ¡gina
	//add_filter('screen_options_show_screen', 'remove_screen_options');
	//--
	if ( !current_user_can( 'edit_users' ) ) :
		add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
	endif;
	//--
	add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );
	//--
	add_filter( 'get_user_option_screen_layout_dashboard', 'so_screen_layout_dashboard' );
	//--
	add_filter('login_headerurl', 'wpc_url_login');
	//--
	add_filter('pre_get_posts', 'set_post_order_in_admin');
	//--
	//-- Enlace pliskin
	//--
	function wp_admin_bar_new_item() {
		global $wp_admin_bar;
		//$wp_admin_bar->add_menu(array('id' => 'wp-admin-bar-hpp-item','title' => __('pliskin'),'href' => 'http://www.pots.com/'));
	}
	//--
	//--
	//--
	function custom_excerpt_length( $length ) {
		return 20;
	}
	function custom_excerpt_more( $more ) {
		return '...';
	}
	// function excerpt_leermas($output, $leermas = 'Read More') {
	// 	//global $post;
	// 	$output = str_replace('[...]', '...', $output);
	// 	return $output/* . '<a href="'. get_permalink($post->ID) . '"> '.$leermas.'</a>'*/;
	// }

	function set_post_order_in_admin( $wp_query ) {
		if (is_admin()):
			//echo 'dada';
			//echo get_post_field('menu_order', $post->ID);
			//$wp_query->set('meta_key', 'order');
			//$wp_query->set('orderby', 'meta_value');
			//$wp_query->set('order', 'DESC');
			//$wp_query->set( 'orderby', 'title' );
			//$wp_query->set( 'order', 'ASC' );
		endif;
	}
	//-------------------------------
	//-- Remove menu tools
	//-------------------------------
	function menu_remove_tools(){
		//http://wp.tutsplus.com/tutorials/creative-coding/customizing-your-wordpress-admin/
		global $menu;
		global $submenu;
		remove_menu_page('edit.php?post_type=noticia'); // Dashboard
		//http://102nueve.com/wp-admin/
		remove_menu_page('index.php'); // Dashboard
		remove_submenu_page('index.php', 'update-core.php'); // Dashboard
		remove_menu_page('separator1'); // Dashboard
		remove_menu_page('separator2'); // Dashboard
		remove_menu_page('separator-last'); // Dashboard
		//remove_menu_page('edit.php'); // Entradas
		//remove_menu_page('upload.php'); // Remove the Tools Menu
		remove_menu_page('edit-comments.php'); // Remove the Tools Menu
		remove_menu_page('link-manager.php'); // Remove the Tools Menu
		//remove_menu_page('edit.php?post_type=page'); // Posttype
		//remove_menu_page('themes.php'); // Remove the Tools Menu
		//remove_menu_page('plugins.php'); // Remove the Tools Menu
		//remove_menu_page('users.php'); // Remove the Tools Menu
		//remove_menu_page('tools.php'); // Remove the Tools Menu
		//remove_menu_page('options-general.php'); // Remove the Tools Menu
		//remove_submenu_page('themes.php','theme-editor.php');
	}
	//--
	function remove_menus(){
		global $menu;
		$restricted = array();
		//$restricted = array(__('Links'), __('Comments'), __('Appearance'));
		//$restricted = array(__('Links'), __('Comments'), __('Appearance'), __('Tools'));
//		end ($menu);
//		while (prev($menu)){
//			$value = explode(' ',$menu[key($menu)][0]);
//			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
//				unset($menu[key($menu)]);
//			}
//		}
	}
	//-- Use your own external URL logo link
	function wpc_url_login(){
		return get_bloginfo('wpurl'); // your URL here
	}
	function so_screen_layout_columns( $columns ) {
		$columns['dashboard'] = 1;
		return $columns;
	}
	function so_screen_layout_dashboard() {
		return 1;
	}
	//-------------------------------
	//-- Custom Brand Admin Login
	//-------------------------------
	function login_enqueue_scripts(){
		$options = get_option('custom_admin_branding_link');
		$login_logo = get_bloginfo('template_directory').'/assets/img-admin/login-logo.png';
		$login_button_color = "#21759B";
		$login_background = get_bloginfo('template_directory') . "/assets/img-admin/fondos/login-bgd-".(rand(0,3)).".jpg";
		$login_button_background = get_bloginfo('template_directory') . "/assets/img-admin/login-btn.jpg";
		//$login_button_background = get_bloginfo('url', 'display') . "/wp-admin/images/button-grad.png";
		$login_border_color = "#298CBA";
		$login_border_hover_color = $options['login_border_hover_color'];
		$login_text_color = "#FFF";
		$backtoblog_color = "#FFFFFF";
		$backtoblog_hover_color = "#D54E21";
		$nav_color = "#FFFFFF";
		$nav_hover_color = "#D54E21";
		$lost_password_color = "#21759B";
		$lost_password_hover_color = "#D54E21";
		?>
		<div class="background-cover"></div>
		<style type="text/css" media="screen">
			p.submit input:hover {
				border-color: <?php echo $login_border_hover_color; ?>;
			}
			/*---*/
			.login #nav{
				margin: 0 0 0 8px !important;
				text-align: right;
			}
			.login #nav a {
				color: <?php echo $nav_color; ?> !important;
				text-shadow: none !important;
				font-family: Tahoma;
				font-size: 11px;
				text-decoration: none;
				text-shadow: none !important;
			}
			.login #nav a:hover {
				color: <?php echo $nav_hover_color; ?> !important;
				text-shadow: none !important;
			}
			/*---*/
			.login #backtoblog{
				margin: 0 0 0 8px !important;
				display: none;
			}
			.login #backtoblog a
			{
				color: <?php echo $backtoblog_color; ?> !important;
				text-shadow: none !important;
			}
			.login #backtoblog a:hover
			{
				color:#96C800 <?php echo $backtoblog_hover_color; ?> !important;
				text-shadow: none !important;
			}
			/*---*/
			#wphead
			{
				background:#069
			}
			/*---*/
			.background-cover
			{
				background: url('<?php echo $login_background; ?>') no-repeat center center fixed;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				position:fixed;
				top:0;
				left:0;
				z-index:10;
				overflow: hidden;
				width: 100%;
				height:100%;
			}
			#login
			{
				z-index:9999; position:relative;
			}
			.login form
			{
				box-shadow: 0px 0px 0px 0px !important;
			}
			.login h1 a
			{
				background: url('<?php echo $login_logo; ?>') no-repeat center top !important;
				height: 140px;
				width: auto;
			}
			input.button-primary,
			button.button-primary,
			a.button-primary
			{
				background: <?php echo $login_button_color; ?>  url('<?php echo $login_button_background; ?>' ) repeat-x scroll left top  !important;
				border-radius: 3px !important;
				border:none !important;
				font-weight:normal !important;
				text-shadow:none !important;
				color: <?php echo $login_text_color ?> !important;
			}
			.button:active,
			.submit input:active,
			.button-secondary:active
			{
				background:#96C800 !important;
				text-shadow: none !important;
			}
		</style>
		<script>
			//jQuery(document).ready(function(){
//				//console.log('ready');
//				jQuery('#login h1 a').attr('href', '/');
//				jQuery('#login h1 a').attr('title', 'Click aquÃ­ para ir al sitio');
			//});
		</script>
	<?php
	}
	//--
	function remove_screen_options(){
		return false;
	}
	//--
	function wps_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('about');
		$wp_admin_bar->remove_menu('wporg');
		$wp_admin_bar->remove_menu('documentation');
		$wp_admin_bar->remove_menu('support-forums');
		$wp_admin_bar->remove_menu('feedback');
		$wp_admin_bar->remove_menu('view-site');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
	}
	//-- Remover barras
	function fb_remove_admin_bar() {
		wp_deregister_script( 'admin-bar' );
		wp_deregister_style( 'admin-bar' );
		remove_action( 'init', '_wp_admin_bar_init' );
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
		// maybe also: 'wp_head'
		foreach ( array( 'admin_head' ) as $hook ) {
			add_action(
				$hook,
				create_function(
					'',
					"
						echo
						'
						<style>
							.wp-first-item
							{
								display: none;
							}
							html.wp-toolbar
							{
								padding-top: 0px !important; //28
							}
							body.admin-bar #wpcontent,
							body.admin-bar #adminmenu
							{
								padding-top: 0px !important;
							}
						</style>
						';
					"
				)
			);
		}
	}
	//--
	function new_mail_from($old) {
		$dominio = get_bloginfo('wpurl');
		$dominio = get_option('siteurl'); //or home
		$dominio = str_replace('http://', '', $dominio);
		$dominio = str_replace('www', '', $dominio); //add the . after the www if you don't want it
		$dominio = strstr($dominio, '/', true); //PHP5 only, this is in case WP is not root
		//return 'admin@'.$dominio;
		//return 'admin@mediolleno.com.sv';
		return $old;
	}
	//--
	function new_mail_from_name($old) {
		//$sitio = get_bloginfo('sitename');
		//$sitio = 'insysacorp.com';
		//return $sitio;
		return $old;
	}
	//--
	function remove_welcome_panel(){
		remove_action('welcome_panel', 'wp_welcome_panel');
		$user_id = get_current_user_id();
		if ( 1 == get_user_meta( $user_id, 'show_welcome_panel', true ) ):
			update_user_meta( $user_id, 'show_welcome_panel', 0 );
		endif;
	}
	//--
	function example_remove_dashboard_widgets() {
//		$wp_meta_boxes['dashboard']['normal']['high']['dashboard_browser_nag']
//		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']
//		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']
//		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']
//		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']
//
//		$wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']
//		$wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']
//		$wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
//		$wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']
		//var_dump($wp_meta_boxes);
		remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	}
	//-- Add page slug as nav IDs
	function nav_id_filter( $id, $item ){
		if($item->title == 'Nuestros Autos')
		{
			//var_dump($item);
		}
		return 'nav-'.sanitize_title($item->title, 'display');
		//return 'nav-'.cleanname($item->title, 'display');
	}
	//-- Deletes all CSS classes and id's, except for those listed in the array below
	function custom_wp_nav_menu($var){
		$classes =
			(is_array($var))?array_intersect($var, array(
				//List of allowed menu classes
				'current_page_item',
				'current_page_parent',
				'current_page_ancestor',
				//'first',
				//'last',
				//'vertical',
				//'horizontal'
			)
		) : '';
		//$estilo = 'nav-'.sanitize_title($item->title, 'display');
		//$classes[] = $estilo;
		return $classes;
	}
	//-- Replaces "current-menu-item" with "active"
	function current_to_active($text){
		//var_dump(is_page('nuestros-autos'));
		//var_dump($text);
		//"<a href="http://chevrolet.com.sv/">Nuestros Autos</a></li>";
		if(is_single())
		{
			$replace = array(
				//List of menu item classes that should be changed to "active"
				'current_page_item' => 'activo',
				'current_page_parent' => 'activo',
				'current_page_ancestor' => 'activo',
				//'>Nuestros Autos<' => '>Nuestros Autos<'
			);
		}
		else
		{
			$replace = array(
				//List of menu item classes that should be changed to "active"
				'current_page_item' => 'activo',
				'current_page_parent' => 'activo',
				'current_page_ancestor' => 'activo'
			);
		}
		switch(is_user_logged_in()):
			case true:
				$text_aux = ">Tu Cuenta </a><a style='text-align: center; padding-left: 0px; margin-left: -10px;' href='".wp_logout_url( home_url() )."'>(salir)</a>";
				$text = str_replace(">Tu Cuenta</a>", $text_aux, $text);
			break;
			case false:
				//$text = str_replace(">Tu Cuenta</a>", ">Tu Cuenta</a>", $text);
			break;
		endswitch;
//		if(!is_single('nuestros-autos'))
//		{
			$text = str_replace(array_keys($replace), $replace, $text);
//		}
		return $text;
	}
	//-- Limpiar nombre
	function cleanname($v){
		$v = preg_replace('/[^a-zA-Z0-9s]/', '', $v);
		$v = str_replace(' ', '-', $v);
		$v = strtolower($v);
		return $v;
	}
	//-- Deletes empty classes and removes the sub menu class
	function strip_empty_classes($menu){
		$menu = preg_replace('/ class=""| class="sub-menu"/','',$menu);
		return $menu;
	}
	//-- Thumbs
	function set_thumbnail_size_by_post_type( $sizes )
	{
		$post_type  = get_post_type($_REQUEST['post_id']);
		//$post_type = get_transient( 'current_upload_parent_type' );
		//delete_transient( 'current_upload_parent_type' );
		switch($post_type):
			case 'ponentes':
//				$sizes['thumbnail'] = array('width' => 300, 'height' => 140, 'crop' => true);
//				$sizes['medium'] = array('width' => 320, 'height' => 215, 'crop' => true);
//				$sizes['large'] = array('width' => 670, 'height' => 320, 'crop' => true);
			break;
			default:
				//-- Thumbnail
				$sizes['thumbnail']		= array('width' => 60, 'height' => 60, 'crop' => false);
//				$sizes['thumbnail_1']	= array('width' => 120, 'height' => 120, 'crop' => true);
				//-- Medium
				$sizes['medium']		= array('width' => 200, 'height' => 200, 'crop' => false);
//				$sizes['medium_1']		= array('width' => 260, 'height' => 135, 'crop' => true);
//				$sizes['medium_2']		= array('width' => 300, 'height' => 140, 'crop' => true);
//				$sizes['medium_3']		= array('width' => 320, 'height' => 215, 'crop' => true);
//				//-- Large
				$sizes['large']			= array('width' => 400, 'height' => 400, 'crop' => false);
			break;
		endswitch;
		return $sizes;
	}
	//-- Autosalvar
	function disableAutoSave()
	{
		wp_deregister_script('autosave');
	}
	//-------------------------------
	//-- Soporte
	//-------------------------------
	if (function_exists('add_theme_support')):
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
	endif;
	if (function_exists('add_post_type_support')):
		add_post_type_support('page', 'excerpt');
	endif;
	if (function_exists('remove_post_type_support')):
		remove_post_type_support('page', 'editor');
		remove_post_type_support('page', 'comments');
	endif;
	//-------------------------------
	//-- Login Redirect
	//-------------------------------
	function dashboard_redirect($url){
		global $current_user;
		// is there a user ?
		if(is_array($current_user->roles)) {
			// check, whether user has the author role:
			if(in_array('admin', $current_user->roles)) {
				 $url = 'edit.php?post_type=page';
			}
			return $url;
		}
	}
	//-------------------------------
	//-- Custom Brand Footer Admin
	//-------------------------------
	function custom_adminFooter(){
	?>
	<style>
		#footer-upgrade
		{
			display:none;
		}
	</style>
	<?php
		echo 'Desarrollado por <a href="http://pots.com">pots.com</a>, contacto a: <a href="mailto:hi@pots.com">hi@pots.com</a>';
	}
	//-------------------------------
	//-- Custom Brand Admin Header
	//-------------------------------
	function custom_adminHeader(){
	?>
		<style type="text/css">
			#contextual-help-link-wrap { display: none !important; }
		</style>
		<style>
			#header-logo
			{
				background: none no-repeat 0px 0px transparent !important;
				display: none;
			}
			#wphead
			{
				background:#069
			}
		</style>
	<?php
	}

?>