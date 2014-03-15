<?php


class Kernel {
    public static $SLUG = "";
    public static $ID = "";
	public static $PATH = "";
    public static $URL = "";
	public static $PLUGIN_SLUG = "";
	public static $PLUGIN_URL = "";
	public static $PLUGIN_PATH = "";
	//
	public static $PAGADMIN_TITULO = "";
	public static $PAGADMIN_SECCION = "";

	//-- Construct Hooks
	public function __construct() {
		self::$SLUG = "kernel";
		self::$ID = self::$SLUG."-bloque";
		self::$PATH = plugin_dir_path( __FILE__ );
		self::$URL = plugin_dir_url( __FILE__ );

		self::$PLUGIN_SLUG = PLUGIN_SLUG;
		self::$PLUGIN_URL = PLUGIN_URL;
		self::$PLUGIN_PATH = PLUGIN_PATH;

		//-- Admin
		self::$PAGADMIN_TITULO = "";
		self::$PAGADMIN_SECCION = "";

		//-- Init
		if ( 'wp-login.php' != $GLOBALS['pagenow'] ): add_action( 'init', array($this, 'setupDefInit') ); endif;

		//-- Admin Init
		add_action('admin_init', array($this, 'setupAdmInit'));

		//-- Scripts
		add_action( 'wp_enqueue_scripts', array($this, 'scripts') );
		//-- Styles
		add_action( 'wp_enqueue_scripts', array($this, 'styles') );

		//-- Scripts Admin
		add_action( 'admin_enqueue_scripts', array($this, 'scripts_ADMIN') );
		//-- Styles Admin
		add_action( 'admin_enqueue_scripts', array($this, 'styles_ADMIN') );
		//-- Widgets
		//add_action( 'widgets_init', array($this, 'sidebars') );
		//-- AJAX Admin Image
		add_action( 'wp_ajax_imgauto', array($this, 'imgauto') );
		add_action( 'wp_ajax_nopriv_imgauto', array($this, 'imgauto') );
		//-- Guardar detalles de metaboxes
		add_action('save_post', array($this, 'savDet'));
	}

	//-- Styles
	public function styles() {
		if(!is_admin()):

			//-----
			//Generar Less
			//-----
			try {
				if( !class_exists('lessc') ):
					throw new Exception('<br><br>¡La clase lessc no ha sido encontrada! #LULZIES<br><br><br>');
				endif;
				//$less = new lessc(self::$PLUGIN_PATH.'css/plugins/'.self::$SLUG.'/style.less');
				//file_put_contents(self::$PLUGIN_PATH.'css/plugins/'.self::$SLUG.'/style.css', $less->parse());
			}
			catch( Exception $e ) {
				echo $e->getMessage();
			}

			//-----
			//Register
			//-----
			//Styles
			if( !wp_style_is(self::$SLUG.'.style', 'registered') )
				wp_register_style(self::$SLUG.'.style', self::$PLUGIN_URL.'css/plugins/'.self::$SLUG.'/style.css');

			//-----
			//Enqueque
			//-----
			//Styles
			if(!wp_style_is(self::$SLUG.'.style', 'queue'))
				wp_enqueue_style(self::$SLUG.'.style');

		endif;
	}

	//-- Scripts
	public function scripts() {
		if(is_admin()):
			//-----
			//Register
			//-----
			//Scripts
			if(!wp_script_is(self::$SLUG.'.script', 'registered'))
				wp_register_script(self::$SLUG.'.script', self::$PLUGIN_URL.'js/plugins/'.self::$SLUG.'/script.js', array('jquery'));

			//-----
			//Enqueque
			//-----
			//Scripts
			if(!wp_script_is(self::$SLUG.'.script', 'queue'))
				wp_enqueue_script(self::$SLUG.'.script');
		endif;
	}

	//-- Styles
	public function styles_ADMIN() {
		if(is_admin()):

			//-----
			//Generar Less
			//-----
			try {
				if( !class_exists('lessc') ):
					throw new Exception('<br><br>¡La clase lessc no ha sido encontrada! #LULZIES<br><br><br>');
				endif;
				//$less = new lessc(self::$PLUGIN_PATH.'css-admin/plugins/'.self::$SLUG.'/style.less');
				//file_put_contents(self::$PLUGIN_PATH.'css-admin/plugins/'.self::$SLUG.'/style.css', $less->parse());
			}
			catch( Exception $e ) {
				echo $e->getMessage();
			}

			//-----
			//Register
			//-----
			//Styles
			if( !wp_style_is(self::$SLUG.'-admin.style', 'registered') )
				wp_register_style(self::$SLUG.'-admin.style', self::$PLUGIN_URL.'css-admin/plugins/'.self::$SLUG.'/style.css');

			if( !wp_style_is('bootstrapcssWP', 'registered') )
				wp_register_style('bootstrapcssWP', self::$PLUGIN_URL.'css-admin/bootstrap/bootstrap.css');

			if( !wp_style_is('bootstrapcssWP-fixes', 'registered') )
				wp_register_style('bootstrapcssWP-fixes', self::$PLUGIN_URL.'css-admin/bootstrap/bootstrap-fixes.css');

			if(!wp_style_is('jquery.ui.all', 'registered'))
				wp_register_style('jquery.ui.all', self::$PLUGIN_URL.'js/jqueryui/themes/base/jquery.ui.all.css');

			//-----
			//Enqueque
			//-----
			//Styles
			if(!wp_style_is(self::$SLUG.'-admin.style', 'queue'))
				wp_enqueue_style(self::$SLUG.'-admin.style');

			if(!wp_style_is('bootstrapcssWP', 'queue'))
				wp_enqueue_style('bootstrapcssWP');

			if(!wp_style_is('bootstrapcssWP-fixes', 'queue'))
				wp_enqueue_style('bootstrapcssWP-fixes');

			if(!wp_style_is('jquery.ui.all', 'queue'))
				wp_enqueue_style('jquery.ui.all');

		endif;
	}

	//-- Scripts
	public function scripts_ADMIN() {
		if(is_admin()):
			//-----
			//Register
			//-----
			//Scripts
			if(!wp_script_is(self::$SLUG.'-admin.script', 'registered'))
				wp_register_script(self::$SLUG.'-admin.script', self::$PLUGIN_URL.'js-admin/plugins/'.self::$SLUG.'/script.js');

			if(!wp_script_is('jquery.ui.core', 'registered'))
				wp_register_script('jquery.ui.core', self::$PLUGIN_URL.'js/jqueryui/ui/jquery.ui.core.js');

//			if(!wp_script_is('jquery.ui.draggable', 'registered'))
//				wp_register_script('jquery.ui.draggable', self::$PLUGIN_URL.'js/jqueryui/ui/minified/jquery.ui.draggable.min.js');

			if(!wp_script_is('jquery.ui.widget', 'registered'))
				wp_register_script('jquery.ui.widget', self::$PLUGIN_URL.'js/jqueryui/ui/jquery.ui.widget.js');

			if(!wp_script_is('jquery.ui.menu', 'registered'))
				wp_register_script('jquery.ui.menu', self::$PLUGIN_URL.'js/jqueryui/ui/jquery.ui.menu.js');

			if(!wp_script_is('jquery.ui.autocomplete', 'registered'))
				wp_register_script('jquery.ui.autocomplete', self::$PLUGIN_URL.'js/jqueryui/ui/jquery.ui.autocomplete.js');

			if(!wp_script_is('jquery.ui.position', 'registered'))
				wp_register_script('jquery.ui.position', self::$PLUGIN_URL.'js/jqueryui/ui/jquery.ui.position.js');

			if(!wp_script_is('jquery.ui.datepicker', 'registered'))
				wp_register_script('jquery.ui.datepicker', self::$PLUGIN_URL.'js/jqueryui/ui/jquery.ui.datepicker.js');

			if(!wp_script_is('jquery.ui.datepicker', 'registered'))
				wp_register_script('jquery.ui.datepicker', self::$PLUGIN_URL.'js/jqueryui/ui/i18n/jquery.ui.datepicker-es.js');

			if(!wp_script_is('bootstrapjs', 'registered'))
				wp_register_script('bootstrapjs', self::$PLUGIN_URL.'js/bootstrap/bootstrap.js');

			//-----
			//Enqueque
			//-----
			//Scripts
			if(!wp_script_is('tiny_mce', 'queue'))
				wp_enqueue_script('tiny_mce');

			if(!wp_script_is(self::$SLUG.'-admin.script', 'queue'))
				wp_enqueue_script(self::$SLUG.'-admin.script');

			if(!wp_script_is('jquery.ui.core', 'queue'))
				wp_enqueue_script('jquery.ui.core');

//			if(!wp_script_is('jquery.ui.draggable', 'queue'))
//				wp_enqueue_script('jquery.ui.draggable');

			if(!wp_script_is('jquery.ui.widget', 'queue'))
				wp_enqueue_script('jquery.ui.widget');

			if(!wp_script_is('jquery.ui.autocomplete', 'queue'))
				wp_enqueue_script('jquery.ui.autocomplete');

			if(!wp_script_is('jquery.ui.menu', 'queue'))
				wp_enqueue_script('jquery.ui.menu');

			if(!wp_script_is('jquery.ui.position', 'queue'))
				wp_enqueue_script('jquery.ui.position');

			if(!wp_script_is('jquery.ui.datepicker', 'queue'))
				wp_enqueue_script('jquery.ui.datepicker');

			if(!wp_script_is('bootstrapjs', 'queue'))
				wp_enqueue_script('bootstrapjs');
		endif;
	}

	//-- Imagenes de un auto
	function imgauto() {
		global $_REQUEST;
		$pid = $_REQUEST['pid'];//Comando

		header("Content-Type: text/json");
		header("Cache-Control: no-cache, must-revalidate");

		$imagenes = get_thumbImagesAll($pid);
		die(json_encode($imagenes));
	}

	//--
	function get_page_template_name($post_id) {
		$plantilla = "";
		//global $post;  // The data structure for the current Page is stored in this global variable.
		// Grab the template filename from Page metadata, but discard any .php extension.
		//$plantilla = str_replace('.php', '', get_post_meta($post_id, '_wp_page_template', true));
		$plantilla = str_replace('page-templates/', '', get_post_meta($post_id, '_wp_page_template', true));

		return $plantilla;
	}

	//-- Setup Admin(admin) Init
	public function setupAdmInit() {
		//global $post, $page;
		$post_id = $_GET['post'];
		$plantilla_sel = "";
		$plantilla_sel = $this->get_page_template_name($post_id);

		if (is_admin()):

			//$templates = get_page_templates($post_id);
//			foreach ( $templates as $template_name => $template_filename ):
//				//echo "$template_name ($template_filename)<br />";
//				//echo $template_name;
//			endforeach;

			//var_dump($this->get_page_template_name($post_id));

			//echo "222".$plantilla_sel;
			switch ( $plantilla_sel ):
				case 'page-inicio.php' :
					//add_meta_box("sel_alertasPAG_BOX", "Alerta", array($this, "alertas_data"), "page", "normal", "high");
				break;
				case 'page-staff.php' :
					//add_meta_box("sel_staff_data_BOX", "Datos", array($this, "PAG_staff_data"), "page", "normal", "high");
				break;
			endswitch;

			//add_meta_box("sel_staff_data_BOX", "Datos", array($this, "staff_data"), "staff", "normal", "high");
			//add_meta_box("sel_producto_data_BOX", "Datos Programa", array($this, "producto_data"), "producto", "normal", "high");
			//add_meta_box("sel_servicio_data_BOX", "Datos Servicio", array($this, "servicio_data"), "servicio", "normal", "high");
		endif;
	}

	//-- Setup Default(admin, user) Init
	public function setupDefInit() {
		//-- Menu
		register_nav_menus(
			array(
				'contenedor_menusuperior'	=>	'Menu Container Supérieur',
				//'contenedor_menuinferior'	=>	'Contenedor Menu Inferior',
				'contenedor_menupie'		=>	'Pie Menu Container'
			)
		);

		//5 - below Posts
		//10 - below Media
		//15 - below Links
		//20 - below Pages
		//25 - below comments
		//60 - below first separator
		//65 - below Plugins
		//70 - below Users
		//75 - below Tools
		//80 - below Settings
		//100 - below second separator

		//-- ACTUALITES
		$labels = array(
			'name'                => _x( 'Actualites', 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( 'Actualites', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( 'Actualites', 'text_domain' ),
			'parent_item_colon'   => __( 'Actualite père', 'text_domain' ),
			'all_items'           => __( 'Tous les actualites', 'text_domain' ),
			'view_item'           => __( 'Voir actualite', 'text_domain' ),
			'add_new_item'        => __( 'Ajouter actualite', 'text_domain' ),
			'add_new'             => __( 'Nouveau actualites', 'text_domain' ),
			'edit_item'           => __( 'Modifier actualite', 'text_domain' ),
			'update_item'         => __( 'Mettre à jour actualite', 'text_domain' ),
			'search_items'        => __( 'Rechercher actualite', 'text_domain' ),
			'not_found'           => __( 'Non actualites', 'text_domain' ),
			'not_found_in_trash'  => __( 'Non actualites', 'text_domain' ),
		);

		$rewrite = array(
			'slug'                => 'actualite',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);

		$args = array(
			'label'               => __( 'actualites', 'text_domain' ),
			'description'         => __( 'Pages de actualite', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'taxonomies'          => array( 'category', 'post_tag' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25,
			'menu_icon'           => self::$PLUGIN_URL."img-admin/posttypes/actualite/favicon.ico",
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			//'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);

		if(!post_type_exists( 'actualite' )):
			//register_post_type( 'actualite', $args );
		endif;

	}

	//-- Registers our main widget area and the front page widget areas.
	function sidebars() {

		// //--
		// //-- GENERAL
		// //--
		// //--- GENERAL - Cab Sup
		// register_sidebar( array(
		// 	'name' => 'GENERAL - Cabecera Derecha',
		// 	'id' => 'gen-cab-sup',
		// 	'description' => 'Aparece en entradas, artículos, páginas incluso en la plantilla opcional de página principal "Página Inicio", que tiene sus propios widgets',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- GENERAL - Foo Sup
		// register_sidebar( array(
		// 	'name' => 'GENERAL - Pie Derecha',
		// 	'id' => 'gen-pie-der',
		// 	'description' => 'Aparece en entradas, artículos, páginas incluso en la plantilla opcional de página principal "Página Inicio", que tiene sus propios widgets',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //-- GENERAL - Fil Sup
		// register_sidebar( array(
		// 	'name' => 'GENERAL - Fila Superior',
		// 	'id' => 'gen-fil-sup',
		// 	'description' => 'Aparece en entradas, artículos, páginas incluso en la plantilla opcional de página principal "Página Inicio", que tiene sus propios widgets',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //-- GENERAL - Fil Sup
		// register_sidebar( array(
		// 	'name' => 'GENERAL - Fila Inferior',
		// 	'id' => 'gen-fil-inf',
		// 	'description' => 'Aparece en entradas, artículos, páginas incluso en la plantilla opcional de página principal "Página Inicio", que tiene sus propios widgets',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //-- GENERAL - Lateral
		// register_sidebar( array(
		// 	'name' => 'GENERAL - Lateral',
		// 	'id' => 'gen-lat',
		// 	'description' => 'Aparece en entradas y páginas excepto en la plantilla opcional de página principal "Página Inicio", que tiene sus propios widgets',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );




		// //--
		// //-- INICIO
		// //--
		// //--- INICIO - Columna Superior Izquierda
		// register_sidebar( array(
		// 	'name' => 'INICIO - Columna Superior Izquierda',
		// 	'id' => 'ini-col-sup-izq',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- INICIO - Columna Superior Derecha
		// register_sidebar( array(
		// 	'name' => 'INICIO - Columna Superior Derecha',
		// 	'id' => 'ini-col-sup-der',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- INICIO - Col Med Izq
		// register_sidebar( array(
		// 	'name' => 'INICIO - Columna Media Izquierda',
		// 	'id' => 'ini-col-med-izq',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- INICIO - Col Med Der
		// register_sidebar( array(
		// 	'name' => 'INICIO - Columna Media Derecha',
		// 	'id' => 'ini-col-med-der',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- INICIO - Fil Sup
		// register_sidebar( array(
		// 	'name' => 'INICIO - Fila Superior',
		// 	'id' => 'ini-fil-sup',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- INICIO - Fil Med
		// register_sidebar( array(
		// 	'name' => 'INICIO - Fila Media',
		// 	'id' => 'ini-fil-med',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );
		// //--- INICIO - Fil Inf
		// register_sidebar( array(
		// 	'name' => 'INICIO - Fila Inferior',
		// 	'id' => 'ini-fil-inf',
		// 	'description' => 'Aparece al usar la plantilla opcional de "Página Inicio" con una página establecida como página principal estática (Configuración General)',
		// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		// 	'after_widget' => '</aside>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );


	}

	//-- Intall
	public static function install() {
		//self::$specs->install();
		//self::$cotizaciones->install();
	}

	//-- Producto Data
	function producto_data() {
		global $post;
		$obj = get_post_custom($post->ID);
		//-- General
		$sel_tipo		= $obj["producto_tipo"][0];
		//-- Padre
		$sel_horario	= $obj["producto_horario"][0];
		$sel_produccion	= $obj["producto_produccion"][0];
		$sel_conduccion = $obj["producto_conduccion"][0];
		$sel_direcccion	= $obj["producto_direcccion"][0];
		$sel_invitado	= $obj["producto_invitado"][0];
		//-- Hijo
		$sel_fecha		= $obj["producto_fecha"][0];
		//--
		//var_dump($sel_tipo);

		//-- Disponibles
		$items_dat = "";
		$items_tot = 0;

		//-- Posts
		$args = array(
			'post_type' => 'producto',
			'post_status' => 'publish',
			'post_parent' => 0,
			'post_per_page' => -1
		);
		//-- Consulta
		$qry = new WP_Query($args);
		switch ( $qry->have_posts() ) :
			case true :
				$items_dat = $qry->get_posts();
				$items_tot = count($items_dat);

				//-- Recorrido
				for ($con=0; $con<$items_tot; $con++) :
//					//-- Item
//					$item = $items_dat[$con];
//					//-- Item Data
//					setup_postdata($item);
//					//-- Campos
//					$titulo		= $item->post_title;
//					$texto		= get_the_excerpt();
//					$enlace		= get_permalink();
//					$pid		= get_the_ID();
					//$items_opc .= "<option value=\"".$pid."\" ".( $pid==$padre ? "selected='selected'" : "" );
				endfor;
			break;
			case false :
			break;
		endswitch;

		//$sel_tipo		= ( $sel_tipo=="" ? "LISTADO_PRODUCTOS" : $sel_tipo );
		//$sel_tipo		= ( $sel_tipo=="LISTADO_PRODUCTOS" && $items_tot==0 ? "LISTADO_MARCAS" : $sel_tipo );

		$items_dat = "";
		$items_tot = 0;
	?>
		<div class="bootstrap-wpadmin">

			<div class="seleccion">
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="seleccion">Tipo:</label>
						<div class="controls">
							<select id="seleccion" name="producto[tipo]">
								<option value="LISTADO_MARCAS" <?php echo ( "LISTADO_MARCAS"==$sel_tipo ? "selected='selected'" : "" ); ?> >
									Listado Marcas
								</option>
								<option value="LISTADO_PRODUCTOS" <?php echo ( "LISTADO_PRODUCTOS"==$sel_tipo ? "selected='selected'" : "" ); ?> >
									Listado Productos
								</option>
								<option value="PRODUCTO" <?php echo ( "PRODUCTO"==$sel_tipo ? "selected='selected'" : "" ); ?> >
									Producto
								</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<hr/>

			<!--<div class="bloque bloque_listado_productos" style="<?php echo ( "LISTADO_PRODUCTOS"!=$sel_tipo ? "display:none;" : "" ); ?>">-->
			<div class="bloque bloque_listado_productos" style="">
				<div class="form-horizontal">
					<!--
					<div class="control-group" style="">
						<label class="control-label" for="producto">Padre:&nbsp;</label>
						<div class="controls">
							<?php
								$post_type_object = get_post_type_object($post->post_type);
								if ( $post_type_object->hierarchical ) :
									$pages = wp_dropdown_pages(
												array(
													'post_type' => 'producto',
													'selected' => $post->post_parent,
													'name' => 'parent_id',
													'depth' => 1,
													'show_option_none' => '',
													'sort_column'=> 'menu_order, post_title',
													'exclude' => $post->ID,
													'echo' => 0));
									if ( ! empty($pages) ) :
										echo $pages;
									endif;
								endif;
							?>
						</div>
					</div>
					-->
					<div class="control-group" style="display: none;">
						<label class="control-label" for="fecha">Fecha:&nbsp;</label>
						<div class="controls">
							<input
								id="fecha"
								class="input-xlarge focused required"
								name="producto[fecha]"
								placeholder="Escriba fecha"
								maxlength="100"
								type="text"
								value="<?php echo $sel_fecha; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="invitado">Invitado(s):&nbsp;<br/><span class="chiquito">(Un invitado por línea)</span></label>
						<div class="controls">
							<textarea
								id="invitado"
								class="input-xxlarge focused required"
								name="producto[invitado]"
								placeholder="Escriba invitado(s)"
								maxlength="50000"><?php echo $sel_invitado; ?></textarea>
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="audio">Audio(s):&nbsp;<br/><span class="chiquito">(Se muestran una vez subidos, al re-cargar la página)</span></label>
						<div class="controls">
							<?php
								//-- Audio
								$audio = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'audio' ) );
							if ( ! empty( $audio ) ) :
								foreach ( $audio as $attachment_id => $attachment ) :
									$att_id = $attachment->ID;
									$att_titulo = $attachment->post_title;
									$att_excerpt = $attachment->post_excerpt;
									$att_content = $attachment->post_content;

									$att_url = wp_get_attachment_url( $att_id, 'full' );
									$att_enlace = wp_get_attachment_link( $att_id, '' , false, false, ' ');

				//					var_dump($attachment->post_title);
				//					var_dump($attachment->post_excerpt);
				//					var_dump($attachment->post_content);
							?>
									<div>
										<?php echo do_shortcode('[mejsaudio src="'.$att_url.'" width="280"]'); ?>
										<!--<a href="<?php echo $att_url; ?>" title="<?php //echo $att_enlace; ?>" rel="audio-file"><?php echo $att_titulo; ?></a>-->
									</div>
							<?php
								endforeach;
							endif;
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="bloque bloque_listado_marcas" style="<?php echo ( "LISTADO_MARCAS"!=$sel_tipo ? "display:none;" : "" ); ?>">
				<div class="form-horizontal">
					<div class="control-group" style="display: none;">
						<label class="control-label" for="horario">Horario</label>
						<div class="controls">
							<input
								id="horario"
								class="input-xlarge focused required"
								name="producto[horario]"
								placeholder="Escriba el horario"
								maxlength="100"
								type="text"
								value="<?php echo $sel_horario; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="produccion">Producción</label>
						<div class="controls">
							<input
								id="produccion"
								class="input-xlarge focused required"
								name="producto[produccion]"
								placeholder="Escriba produccion"
								maxlength="100"
								type="text"
								value="<?php echo $sel_produccion; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="conduccion">Conductores</label>
						<div class="controls">
							<input
								id="conduccion"
								class="input-xlarge focused required"
								name="producto[conduccion]"
								placeholder="Escriba los conductores"
								maxlength="100"
								type="text"
								value="<?php echo $sel_conduccion; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="direcccion">Direccción</label>
						<div class="controls">
							<input
								id="direcccion"
								class="input-xlarge focused required"
								name="producto[direcccion]"
								placeholder="Escriba los conductores"
								maxlength="100"
								type="text"
								value="<?php echo $sel_direcccion; ?>" />
						</div>
					</div>
					<!--
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox"> Remember me
						</label>
						<button type="submit" class="btn">Sign in</button>
					</div>
					-->
				</div>
			</div>

		</div>

		<script>
			jQuery(document).ready(function( $ ) {
			});
		</script>

		<script>
			jQuery(document).ready(function( $ ) {

				//--
				switch($('#seleccion option:selected').val()){
					case 'LISTADO_MARCAS':
						// $('.bloque_hijo #parent_id').attr('name','parent_id_BAD');
						// //console.log("LISTADO_MARCAS");

						// $('#wp-content-editor-container').slideDown('fast');
						// //$('#wp-content-editor-container').css({'display':'block'});
						// $('#post-status-info').css({'display':'block'});
						// $('#content-html').css({'display':'block'});
						// $('#content-tmce').css({'display':'block'});
					break;
					case 'LISTADO_PRODUCTOS':
						// $('.bloque_hijo #parent_id').attr('name','parent_id');
						// //console.log("LISTADO_PRODUCTOS");

						// $('#wp-content-editor-container').slideUp('fast');
						// //$('#wp-content-editor-container').css({'display':'none'});
						// $('#post-status-info').css({'display':'none'});
						// $('#content-html').css({'display':'none'});
						// $('#content-tmce').css({'display':'none'});
					break;
					case 'PRODUCTO':
						// $('.bloque_hijo #parent_id').attr('name','parent_id');
						// //console.log("LISTADO_PRODUCTOS");

						// $('#wp-content-editor-container').slideUp('fast');
						// //$('#wp-content-editor-container').css({'display':'none'});
						// $('#post-status-info').css({'display':'none'});
						// $('#content-html').css({'display':'none'});
						// $('#content-tmce').css({'display':'none'});
					break;
				}

				//-- General
				$("#seleccion").change(function () {
					var sel = $('#seleccion option:selected').val();
					if(sel){
						sel = sel.toLowerCase();
						// $('.bloque').css({'display':'none'});
						// $('.bloque_'+sel).css({'display':'block'});

						switch($('#seleccion option:selected').val()){
							case 'LISTADO_MARCAS':
								// $('.bloque_hijo #parent_id').attr('name','parent_id_BAD');

								// $('#wp-content-editor-container').slideDown('fast');
								// //$('#wp-content-editor-container').css({'display':'block'});
								// $('#post-status-info').css({'display':'block'});
								// $('#content-html').css({'display':'block'});
								// $('#content-tmce').css({'display':'block'});
							break;
							case 'LISTADO_PRODUCTOS':
								// $('.bloque_hijo #parent_id').attr('name','parent_id');

								// $('#wp-content-editor-container').slideUp('fast');
								// //$('#wp-content-editor-container').css({'display':'none'});
								// $('#post-status-info').css({'display':'none'});
								// $('#content-html').css({'display':'none'});
								// $('#content-tmce').css({'display':'none'});
							break;
							case 'PRODUCTO':
								// $('.bloque_hijo #parent_id').attr('name','parent_id');

								// $('#wp-content-editor-container').slideUp('fast');
								// //$('#wp-content-editor-container').css({'display':'none'});
								// $('#post-status-info').css({'display':'none'});
								// $('#content-html').css({'display':'none'});
								// $('#content-tmce').css({'display':'none'});
							break;
						}
					}
					//console.log($('#seleccion option:selected').val());
				});

				<?php
					//-- Disponibles
					$items_dat = "";
					$items_tot = "";

					//-- Posts
					$args = array(
						'post_type' => 'staff',
						'post_status' => 'publish'
					);
					//-- Consulta
					$qry = new WP_Query($args);
					switch ( $qry->have_posts() ) :
						case true :
							$items_dat = $qry->get_posts();
							$items_tot = count($items_dat);

							//-- Recorrido
							for ($con=0; $con<$items_tot; $con++) :
								//-- Item
								$item = $items_dat[$con];
								//-- Item Data
								setup_postdata($item);
								//-- Campos
								$titulo		= $item->post_title;
								$texto		= get_the_excerpt();
								$enlace		= get_permalink();
								//$obj		= get_post_custom($post->ID);
								//$usr_frase	= $obj["frase_autor"][0];
								//--
								$items_opc .= "\"".$titulo."\"".( $con==$items_tot-1 ? "" : "," );
							endfor;

//							$qry->the_post();
//							$pid = get_the_ID();
//							$titulo = get_the_title();
//							//echo the_permalink();
//							//echo '<br>'.get_the_title();
//							$conductores .= $titulo.",";
						break;
						case false :

						break;
					endswitch;
				?>

				var availableTags = [<?php echo $items_opc ?>];
				function split( val ) {
					return val.split( /,\s*/ );
				}
				function extractLast( term ) {
					return split( term ).pop();
				}

				//-- Conduccion
				$( "#conduccion" )
				// don't navigate away from the field on tab when selecting an item
				.bind( "keydown", function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
						event.preventDefault();
					}
				})
				.autocomplete({
					minLength: 0,
					source: function( request, response ) {
						// delegate back to autocomplete, but extract the last term
						response( $.ui.autocomplete.filter( availableTags, extractLast( request.term ) ) );
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				});


				//-- Direcccion
				$( "#direcccion" )
				// don't navigate away from the field on tab when selecting an item
				.bind( "keydown", function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
						event.preventDefault();
					}
				})
				.autocomplete({
					minLength: 0,
					source: function( request, response ) {
						// delegate back to autocomplete, but extract the last term
						response( $.ui.autocomplete.filter( availableTags, extractLast( request.term ) ) );
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				});

				//-- Produccion
				$( "#produccion" )
				// don't navigate away from the field on tab when selecting an item
				.bind( "keydown", function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
						event.preventDefault();
					}
				})
				.autocomplete({
					minLength: 0,
					source: function( request, response ) {
						// delegate back to autocomplete, but extract the last term
						response( $.ui.autocomplete.filter( availableTags, extractLast( request.term ) ) );
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				});

				//-- LISTADO_PRODUCTOS
				$( "#fecha" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: true,
					dateFormat: "yy-mm-dd",
					changeMonth: true,
					changeYear: true
				});
				$.datepicker.regional['es']
			});
		</script>
	<?php
	}


	//-- Servicio Data
	function servicio_data() {
		global $post;
		$obj = get_post_custom($post->ID);
		//-- General
		$sel_tipo		= $obj["servicio_tipo"][0];
		//-- Padre
		$sel_horario	= $obj["servicio_horario"][0];
		$sel_produccion	= $obj["servicio_produccion"][0];
		$sel_conduccion = $obj["servicio_conduccion"][0];
		$sel_direcccion	= $obj["servicio_direcccion"][0];
		$sel_invitado	= $obj["servicio_invitado"][0];
		//-- Hijo
		$sel_fecha		= $obj["servicio_fecha"][0];
		//--
		//var_dump($sel_tipo);

		//-- Disponibles
		$items_dat = "";
		$items_tot = 0;

		//-- Posts
		$args = array(
			'post_type' => 'servicio',
			'post_status' => 'publish',
			'post_parent' => 0,
			'post_per_page' => -1
		);
		//-- Consulta
		$qry = new WP_Query($args);
		switch ( $qry->have_posts() ) :
			case true :
				$items_dat = $qry->get_posts();
				$items_tot = count($items_dat);

				//-- Recorrido
				for ($con=0; $con<$items_tot; $con++) :
//					//-- Item
//					$item = $items_dat[$con];
//					//-- Item Data
//					setup_postdata($item);
//					//-- Campos
//					$titulo		= $item->post_title;
//					$texto		= get_the_excerpt();
//					$enlace		= get_permalink();
//					$pid		= get_the_ID();
					//$items_opc .= "<option value=\"".$pid."\" ".( $pid==$padre ? "selected='selected'" : "" );
				endfor;
			break;
			case false :
			break;
		endswitch;

		//$sel_tipo		= ( $sel_tipo=="" ? "LISTADO_PRODUCTOS" : $sel_tipo );
		//$sel_tipo		= ( $sel_tipo=="LISTADO_PRODUCTOS" && $items_tot==0 ? "LISTADO_MARCAS" : $sel_tipo );

		$items_dat = "";
		$items_tot = 0;
	?>
		<div class="bootstrap-wpadmin">

			<div class="seleccion">
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="seleccion">Tipo:</label>
						<div class="controls">
							<select id="seleccion" name="servicio[tipo]">
								<option value="LISTADO_MARCAS" <?php echo ( "LISTADO_MARCAS"==$sel_tipo ? "selected='selected'" : "" ); ?> >
									Listado Marcas
								</option>
								<option value="LISTADO_PRODUCTOS" <?php echo ( "LISTADO_PRODUCTOS"==$sel_tipo ? "selected='selected'" : "" ); ?> >
									Listado Productos
								</option>
								<option value="PRODUCTO" <?php echo ( "PRODUCTO"==$sel_tipo ? "selected='selected'" : "" ); ?> >
									Producto
								</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<hr/>

			<!--<div class="bloque bloque_listado_servicios" style="<?php echo ( "LISTADO_PRODUCTOS"!=$sel_tipo ? "display:none;" : "" ); ?>">-->
			<div class="bloque bloque_listado_servicios" style="">
				<div class="form-horizontal">
					<!--
					<div class="control-group" style="">
						<label class="control-label" for="servicio">Padre:&nbsp;</label>
						<div class="controls">
							<?php
								$post_type_object = get_post_type_object($post->post_type);
								if ( $post_type_object->hierarchical ) :
									$pages = wp_dropdown_pages(
												array(
													'post_type' => 'servicio',
													'selected' => $post->post_parent,
													'name' => 'parent_id',
													'depth' => 1,
													'show_option_none' => '',
													'sort_column'=> 'menu_order, post_title',
													'exclude' => $post->ID,
													'echo' => 0));
									if ( ! empty($pages) ) :
										echo $pages;
									endif;
								endif;
							?>
						</div>
					</div>
					-->
					<div class="control-group" style="display: none;">
						<label class="control-label" for="fecha">Fecha:&nbsp;</label>
						<div class="controls">
							<input
								id="fecha"
								class="input-xlarge focused required"
								name="servicio[fecha]"
								placeholder="Escriba fecha"
								maxlength="100"
								type="text"
								value="<?php echo $sel_fecha; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="invitado">Invitado(s):&nbsp;<br/><span class="chiquito">(Un invitado por línea)</span></label>
						<div class="controls">
							<textarea
								id="invitado"
								class="input-xxlarge focused required"
								name="servicio[invitado]"
								placeholder="Escriba invitado(s)"
								maxlength="50000"><?php echo $sel_invitado; ?></textarea>
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="audio">Audio(s):&nbsp;<br/><span class="chiquito">(Se muestran una vez subidos, al re-cargar la página)</span></label>
						<div class="controls">
							<?php
								//-- Audio
								$audio = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'audio' ) );
							if ( ! empty( $audio ) ) :
								foreach ( $audio as $attachment_id => $attachment ) :
									$att_id = $attachment->ID;
									$att_titulo = $attachment->post_title;
									$att_excerpt = $attachment->post_excerpt;
									$att_content = $attachment->post_content;

									$att_url = wp_get_attachment_url( $att_id, 'full' );
									$att_enlace = wp_get_attachment_link( $att_id, '' , false, false, ' ');

				//					var_dump($attachment->post_title);
				//					var_dump($attachment->post_excerpt);
				//					var_dump($attachment->post_content);
							?>
									<div>
										<?php echo do_shortcode('[mejsaudio src="'.$att_url.'" width="280"]'); ?>
										<!--<a href="<?php echo $att_url; ?>" title="<?php //echo $att_enlace; ?>" rel="audio-file"><?php echo $att_titulo; ?></a>-->
									</div>
							<?php
								endforeach;
							endif;
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="bloque bloque_listado_marcas" style="<?php echo ( "LISTADO_MARCAS"!=$sel_tipo ? "display:none;" : "" ); ?>">
				<div class="form-horizontal">
					<div class="control-group" style="display: none;">
						<label class="control-label" for="horario">Horario</label>
						<div class="controls">
							<input
								id="horario"
								class="input-xlarge focused required"
								name="servicio[horario]"
								placeholder="Escriba el horario"
								maxlength="100"
								type="text"
								value="<?php echo $sel_horario; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="produccion">Producción</label>
						<div class="controls">
							<input
								id="produccion"
								class="input-xlarge focused required"
								name="servicio[produccion]"
								placeholder="Escriba produccion"
								maxlength="100"
								type="text"
								value="<?php echo $sel_produccion; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="conduccion">Conductores</label>
						<div class="controls">
							<input
								id="conduccion"
								class="input-xlarge focused required"
								name="servicio[conduccion]"
								placeholder="Escriba los conductores"
								maxlength="100"
								type="text"
								value="<?php echo $sel_conduccion; ?>" />
						</div>
					</div>
					<div class="control-group" style="display: none;">
						<label class="control-label" for="direcccion">Direccción</label>
						<div class="controls">
							<input
								id="direcccion"
								class="input-xlarge focused required"
								name="servicio[direcccion]"
								placeholder="Escriba los conductores"
								maxlength="100"
								type="text"
								value="<?php echo $sel_direcccion; ?>" />
						</div>
					</div>
					<!--
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox"> Remember me
						</label>
						<button type="submit" class="btn">Sign in</button>
					</div>
					-->
				</div>
			</div>

		</div>

		<script>
			jQuery(document).ready(function( $ ) {
			});
		</script>

		<script>
			jQuery(document).ready(function( $ ) {

				//--
				switch($('#seleccion option:selected').val()){
					case 'LISTADO_MARCAS':
						// $('.bloque_hijo #parent_id').attr('name','parent_id_BAD');
						// //console.log("LISTADO_MARCAS");

						// $('#wp-content-editor-container').slideDown('fast');
						// //$('#wp-content-editor-container').css({'display':'block'});
						// $('#post-status-info').css({'display':'block'});
						// $('#content-html').css({'display':'block'});
						// $('#content-tmce').css({'display':'block'});
					break;
					case 'LISTADO_PRODUCTOS':
						// $('.bloque_hijo #parent_id').attr('name','parent_id');
						// //console.log("LISTADO_PRODUCTOS");

						// $('#wp-content-editor-container').slideUp('fast');
						// //$('#wp-content-editor-container').css({'display':'none'});
						// $('#post-status-info').css({'display':'none'});
						// $('#content-html').css({'display':'none'});
						// $('#content-tmce').css({'display':'none'});
					break;
					case 'PRODUCTO':
						// $('.bloque_hijo #parent_id').attr('name','parent_id');
						// //console.log("LISTADO_PRODUCTOS");

						// $('#wp-content-editor-container').slideUp('fast');
						// //$('#wp-content-editor-container').css({'display':'none'});
						// $('#post-status-info').css({'display':'none'});
						// $('#content-html').css({'display':'none'});
						// $('#content-tmce').css({'display':'none'});
					break;
				}

				//-- General
				$("#seleccion").change(function () {
					var sel = $('#seleccion option:selected').val();
					if(sel){
						sel = sel.toLowerCase();
						// $('.bloque').css({'display':'none'});
						// $('.bloque_'+sel).css({'display':'block'});

						switch($('#seleccion option:selected').val()){
							case 'LISTADO_MARCAS':
								// $('.bloque_hijo #parent_id').attr('name','parent_id_BAD');

								// $('#wp-content-editor-container').slideDown('fast');
								// //$('#wp-content-editor-container').css({'display':'block'});
								// $('#post-status-info').css({'display':'block'});
								// $('#content-html').css({'display':'block'});
								// $('#content-tmce').css({'display':'block'});
							break;
							case 'LISTADO_PRODUCTOS':
								// $('.bloque_hijo #parent_id').attr('name','parent_id');

								// $('#wp-content-editor-container').slideUp('fast');
								// //$('#wp-content-editor-container').css({'display':'none'});
								// $('#post-status-info').css({'display':'none'});
								// $('#content-html').css({'display':'none'});
								// $('#content-tmce').css({'display':'none'});
							break;
							case 'PRODUCTO':
								// $('.bloque_hijo #parent_id').attr('name','parent_id');

								// $('#wp-content-editor-container').slideUp('fast');
								// //$('#wp-content-editor-container').css({'display':'none'});
								// $('#post-status-info').css({'display':'none'});
								// $('#content-html').css({'display':'none'});
								// $('#content-tmce').css({'display':'none'});
							break;
						}
					}
					//console.log($('#seleccion option:selected').val());
				});

				<?php
					//-- Disponibles
					$items_dat = "";
					$items_tot = "";

					//-- Posts
					$args = array(
						'post_type' => 'staff',
						'post_status' => 'publish'
					);
					//-- Consulta
					$qry = new WP_Query($args);
					switch ( $qry->have_posts() ) :
						case true :
							$items_dat = $qry->get_posts();
							$items_tot = count($items_dat);

							//-- Recorrido
							for ($con=0; $con<$items_tot; $con++) :
								//-- Item
								$item = $items_dat[$con];
								//-- Item Data
								setup_postdata($item);
								//-- Campos
								$titulo		= $item->post_title;
								$texto		= get_the_excerpt();
								$enlace		= get_permalink();
								//$obj		= get_post_custom($post->ID);
								//$usr_frase	= $obj["frase_autor"][0];
								//--
								$items_opc .= "\"".$titulo."\"".( $con==$items_tot-1 ? "" : "," );
							endfor;

//							$qry->the_post();
//							$pid = get_the_ID();
//							$titulo = get_the_title();
//							//echo the_permalink();
//							//echo '<br>'.get_the_title();
//							$conductores .= $titulo.",";
						break;
						case false :

						break;
					endswitch;
				?>

				var availableTags = [<?php echo $items_opc ?>];
				function split( val ) {
					return val.split( /,\s*/ );
				}
				function extractLast( term ) {
					return split( term ).pop();
				}

				//-- Conduccion
				$( "#conduccion" )
				// don't navigate away from the field on tab when selecting an item
				.bind( "keydown", function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
						event.preventDefault();
					}
				})
				.autocomplete({
					minLength: 0,
					source: function( request, response ) {
						// delegate back to autocomplete, but extract the last term
						response( $.ui.autocomplete.filter( availableTags, extractLast( request.term ) ) );
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				});


				//-- Direcccion
				$( "#direcccion" )
				// don't navigate away from the field on tab when selecting an item
				.bind( "keydown", function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
						event.preventDefault();
					}
				})
				.autocomplete({
					minLength: 0,
					source: function( request, response ) {
						// delegate back to autocomplete, but extract the last term
						response( $.ui.autocomplete.filter( availableTags, extractLast( request.term ) ) );
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				});

				//-- Produccion
				$( "#produccion" )
				// don't navigate away from the field on tab when selecting an item
				.bind( "keydown", function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
						event.preventDefault();
					}
				})
				.autocomplete({
					minLength: 0,
					source: function( request, response ) {
						// delegate back to autocomplete, but extract the last term
						response( $.ui.autocomplete.filter( availableTags, extractLast( request.term ) ) );
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				});

				//-- LISTADO_PRODUCTOS
				$( "#fecha" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: true,
					dateFormat: "yy-mm-dd",
					changeMonth: true,
					changeYear: true
				});
				$.datepicker.regional['es']
			});
		</script>
	<?php
	}

	//-------------------------------
	//-- SaveDet
	//-------------------------------
	function savDet() {
		global $post;
		switch($post->post_type):
			case "page" :
				if ( !empty($_POST['widget']) && is_array($_POST['widget']) ):
					$data = $_POST['widget'];
					foreach($data as $key=>$item) :
						//var_dump($key);
						delete_post_meta($post->ID, 'widget_'.$key.'');
						add_post_meta($post->ID, 'widget_'.$key.'', $item);
					endforeach;
//					if($_POST["producto[tipo]"] == "LISTADO_MARCAS"):
//						$_POST['parent_id'] = 0;
//					endif;
				endif;
			break;
			case "producto" :
				if ( !empty($_POST['producto']) && is_array($_POST['producto']) ):
					$data = $_POST['producto'];
					foreach($data as $key=>$item) :
						//var_dump($key);
						delete_post_meta($post->ID, 'producto_'.$key.'');
						add_post_meta($post->ID, 'producto_'.$key.'', $item);
					endforeach;
//					if($_POST["producto[tipo]"] == "LISTADO_MARCAS"):
//						$_POST['parent_id'] = 0;
//					endif;
				endif;
			break;
			case "servicio" :
				if ( !empty($_POST['servicio']) && is_array($_POST['servicio']) ):
					$data = $_POST['servicio'];
					foreach($data as $key=>$item) :
						//var_dump($key);
						delete_post_meta($post->ID, 'servicio_'.$key.'');
						add_post_meta($post->ID, 'servicio_'.$key.'', $item);
					endforeach;
//					if($_POST["producto[tipo]"] == "LISTADO_MARCAS"):
//						$_POST['parent_id'] = 0;
//					endif;
				endif;
			break;
		endswitch;
	}

}
?>
