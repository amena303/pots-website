<?php
include_once 'plugin.DAO.class.php';

class Contacto {
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
		self::$SLUG = "contacto";
		self::$ID = self::$SLUG."-bloque";
		self::$PATH = plugin_dir_path( __FILE__ );
		self::$URL = plugin_dir_url( __FILE__ );

		self::$PLUGIN_SLUG = PLUGIN_SLUG;
		self::$PLUGIN_URL = PLUGIN_URL;
		self::$PLUGIN_PATH = PLUGIN_PATH;

		//-- Admin
		self::$PAGADMIN_TITULO = "Contacto";
		self::$PAGADMIN_SECCION = "Contacto";

		//-- Menu
		add_action('admin_menu', array($this, 'adminMenu'));
		//-- Init
		if ( 'wp-login.php' != $GLOBALS['pagenow'] ): add_action( 'init', array($this, 'setupDefInit') ); endif;
		//-- Scripts
		add_action( 'wp_enqueue_scripts', array($this, 'scripts') );
		//-- Styles
		add_action( 'wp_enqueue_scripts', array($this, 'styles') );
		//-- Scripts Admin
		add_action( 'admin_enqueue_scripts', array($this, 'scripts_ADMIN') );
		//-- Styles Admin
		add_action( 'admin_enqueue_scripts', array($this, 'styles_ADMIN') );
		//-- Handler AJAX
		add_action('wp_ajax_reg'.self::$SLUG, array($this, 'registroController'));
		add_action('wp_ajax_nopriv_reg'.self::$SLUG, array($this, 'registroController'));
		//-- Shortcode
		add_shortcode(self::$SLUG, array($this, 'registroVista'));

		add_filter('query_vars'.self::$SLUG, array($this, 'parameter_queryvars'));
	}

	function parameter_queryvars( $qvars )
	{
		$qvars[] = 'pagina';
		return $qvars;
	}

	//paginacion($, $, $, $, $);
	function paginacion($pag_act, $pag_tot, $pag_ran, $pag_base = '') {
		ob_start();

		$showitems = ($pag_ran * 2) + 1;
		if (empty($pag_act)):
			$pag_act = 1;
		endif;
		if (1 != $pag_tot):
		?>

			<ul class='pagination'>

				<?php
					if ($pag_act > 2 && $pag_act > $pag_ran + 1 && $showitems < $pag_tot):
					//-- 
					$pag_base = add_query_arg(array(
						'pagina' => 1
						, 'page' => self::$SLUG
					), admin_url('admin.php'));
				?>
					<li>
						<a data-pag="<?php echo ($pag_base - 1); ?>" href="<?php echo $pag_base; ?>">Inicio</a>
					</li>
				<?php
					endif;
				?>

				<?php
					if ($pag_act > 1 && $showitems < $pag_tot):
					//-- 
					$pag_base = add_query_arg(array(
						'pagina' => ($pag_act - 1)
						, 'page' => self::$SLUG
					), admin_url('admin.php'));
				?>
					<li>
						<a data-pag="<?php echo ($pag_act - 1); ?>" href="<?php echo $pag_base; ?>">Anterior</a>
					</li>
				<?php
					endif;
				?>

				<?php
					for ($i = 1; $i <= $pag_tot; $i++) :
						if (1 != $pag_tot && (!($i >= $pag_act + $pag_ran + 1 || $i <= $pag_act - $pag_ran - 1) || $pag_tot <= $showitems )):
							if( $pag_act == $i):
								//-- 
								$pag_base = add_query_arg(array(
									'pagina' => $i
									, 'page' => self::$SLUG
								), admin_url('admin.php'));
				?>
								<li class='active'>
									<a data-pag="<?php echo $i; ?>" href='<?php echo  $pag_base; ?>'><?php echo $i; ?><div class='current sr-only'>&nbsp;</div></a>
								</li>
				<?php
							else:
								//-- 
								$pag_base = add_query_arg(array(
									'pagina' => $i
									, 'page' => self::$SLUG
								), admin_url('admin.php'));
				?>
								<li>
									<a data-pag="<?php echo $i; ?>" href="<?php echo  $pag_base; ?>" class="inactive"><?php echo $i; ?></a></li>
								</li>
				<?php 
							endif;
						endif;
					endfor;
				?>

				<?php
					if ($pag_act < $pag_tot && $showitems < $pag_tot):
						//-- 
						$pag_base = add_query_arg(array(
							'pagina' => $pag_act + 1
							, 'page' => self::$SLUG
						), admin_url('admin.php'));
				?>
					<a data-pag="<?php echo ($pag_act + 1); ?>" href="<?php echo $pag_base; ?>">Siguiente</a>
				<?php
					endif;
				?>

				<?php
					if ($pag_act < $pag_tot - 1 && $pag_act + $pag_ran - 1 < $pag_tot && $showitems < $pag_tot):
						//-- 
						$pag_base = add_query_arg(array(
							'pagina' => $pag_tot
							, 'page' => self::$SLUG
						), admin_url('admin.php'));
				?>
					<a data-pag="<?php echo ($pag_tot); ?>" href="<?php echo $pag_base; ?>">Siguiente</a>
				<?php
					endif;
				?>
			</ul>

		<?php
			/*
			$hml .= 'pgdNum-> '.$pag_act.'<br>';
			$hml .= 'pgdTot-> '.$pag_tot.'<br>';
			$hml .= 'pgdRng-> '.$pag_ran.'<br>';
			*/
		endif;
		$dom_data = ob_get_clean();

		return $dom_data;
	}

	//-- Strip
	function stripTags($keys, &$arr) {
		foreach($keys as $key):
			if (key_exists($key, $arr)):
				$arr[$key] = strip_tags($arr[$key]);
			endif;
		endforeach;
	}

	//-- Trim
	function trimValues($keys, &$arr) {
		foreach($keys as $key):
			if(key_exists($key, $arr)):
				$arr[$key] = trim($arr[$key]);
			endif;
		endforeach;
	}

	//-- mm/dd/aaaa -> dd/mm/aaaa
	function convertir_fecha_english2normal($fecha) {
		$mifecha = "";
		$lafecha = "";
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
		$lafecha = $mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
		return $lafecha;
	}

	//-- dd/mm/aaaa -> mm/dd/aaaa
	function convertir_fecha_normal2english($fecha_hora) {
		$fecha_hora = explode(' ', $fecha_hora);
		$fecha = $fecha_hora[0];
		$hora = $fecha_hora[1];
		$mifecha = "";
		$lafecha = "";
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
		$lafecha = $mifecha[3]."-".$mifecha[2]."-".$mifecha[1];

		//echo $lafecha.' '.$hora;
		return $lafecha.' '.$hora;
	}

	//-- Correo Usuario
	function correoUsuario($datos) {
		ob_start();
	?>
		Hemos recibido una solicitud de tu parte en nuestro sitio web.<br><br>
		Actualmente nos encontramos procesando tu pedido.<br><br>
		<!-- También puedes unirte a nuestra comunidad en <a target="_blank" href="http://facebook.com">Facebook</a>. <br><br>-->
		¡Feliz día!<br><br>
		Atte<br>
		El equipo de <?php echo get_bloginfo( 'name' ); ?><br><br>
	<?php
		$cuerpo_correo = ob_get_clean();

		$dominio = get_domain_root();
		$titulo_pag = get_bloginfo( 'name' );
		$cabeceras = array("From: $titulo_pag <info@".$dominio.">");
		wp_mail($datos['email'], $titulo_pag.' - Contacto', $cuerpo_correo, $cabeceras);
	}

	//-- Correo Admin
	function correoAdmin($datos) {
		ob_start();
	?>
		Someone has been request registered at contact form, here the information:<br><br>
		<table>
			<tbody>
				<tr>
					<td><span style="font-weight: bold;">Nombre</span></td>
					<td> : </td>
					<td><?php echo $datos['nombre']; ?></td>
				</tr>
				<tr>
					<td><span style="font-weight: bold;">Last Name</span></td>
					<td> : </td>
					<td><?php echo $datos['apellido']; ?></td>
				</tr>
				<tr>
					<td><span style="font-weight: bold;">Message</span></td>
					<td> : </td>
					<td><?php echo $datos['tema_interes']; ?></td>
				</tr>
<!-- 
				<tr>
					<td><span style="font-weight: bold;">Thelephone</span></td>
					<td> : </td>
					<td><?php echo $datos['telefono']; ?></td>
				</tr>
 -->
				<tr>
					<td><span style="font-weight: bold;">Email</span></td>
					<td> : </td>
					<td><?php echo $datos['email']; ?></td>
				</tr>
			</tbody>
		</table><br><br>
<!--
		Agradecemos se le dé seguimiento a esta solicitud lo más pronto posible.<br><br>
-->
		Thankyou!<br><br>
	<?php
		$cuerpo_correo = ob_get_clean();

		$dominio = get_domain_root();
		$titulo_pag = get_bloginfo( 'name' );
		$cabeceras = array("From: $titulo_pag <info@".$dominio.">");

		wp_mail('drmartinkf@gmail.com', $titulo_pag.' - Contacto', $cuerpo_correo, $cabeceras);
	}

	//-- Validar campos
	function vacios($elementos, &$arr) {
		//-- Inicializando error
		$res = array('error' => 0, 'data' => '');

		foreach($elementos as $llave => $valores):
			if(key_exists($llave, $arr)):
				if(empty($arr[$llave])):
					$res = array('error' => 1, 'data' => $elementos[$llave]);
				endif;
			endif;
		endforeach;

		return $res;
	}

	//-- Validar
	function validar(&$datos) {
		//Inicializando error
		$res = array('error' => 0, 'data' => '');

		//Verificando que faltan parametros
		if (empty($datos)):
			$json['data'] = 'Faltan datos';
			$json['error'] = 1;
			return $res;
		endif;


		//Strip (elimina tags HTML)
		self::stripTags
		(
			array
			(
				'nombre',
				'apellido',
				'tema_interes',
				'telefono',
				'asunto'
			),
			$datos
		);
		//Trim (espacios inicio, final)
		self::trimValues
		(
			array
			(
				'nombre',
				'apellido',
				'tema_interes',
				'telefono',
				'asunto'
			),
			$datos
		);

		//Campos vacios (mensajes personalizados a la Ramayac)
		$res =
		self::vacios
		(
			array
			(
				'nombre' => 'Campo vacío',
				'apellido' => 'Campo vacío',
				'tema_interes' => 'Campo vacío',
				'telefono' => 'Campo vacío',
				'asunto' => 'Campo vacío'
			),
			$datos
		);

		//Validacion "rigurosa" de email (a la Ramayac)
		if(!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)):
			$res['data'] = 'Correo invalido';
			$res['error'] = 1;
			return $res;
		endif;

		if($res['error'] == 1):
			return $res;
		endif;

		return $res;
	}

	//-- Setup Default(admin, user) Init
	public function setupDefInit() {
	}

	//-- Setup Admin Init
	public function setupAdmInit() {
	}
	//-- Styles ADMIN
	public function styles_ADMIN() {
		if(is_admin()):

			//-----
			//Generar Less
			//-----
			try{
				if(!class_exists('lessc')):
					throw new Exception('<br><br>¡La clase lessc no ha sido encontrada!<br><br><br>');
				endif;

				$less = new lessc(self::$PLUGIN_PATH . 'assets/css-admin/plugins/'.self::$SLUG.'/style.less');
				file_put_contents(self::$PLUGIN_PATH . 'assets/css-admin/plugins/'.self::$SLUG.'/style.css', $less->parse());

				//--
				// $less = new lessc(self::$PLUGIN_PATH . '/lib/css/bootstrap/less/bootstrap.less');
				// file_put_contents(self::$PLUGIN_PATH . '/lib/css/bootstrap/bootstrap.css', $less->parse());

				// //--
				// $less = new lessc(self::$PLUGIN_PATH. 'lib/css/bootstrap.datepicker/less/bootstrap.datepicker.less');
				// file_put_contents(self::$PLUGIN_PATH. 'lib/css/bootstrap.datepicker/bootstrap.datepicker.css', $less->parse());

				// //--
				// $less = new lessc(self::$PLUGIN_PATH . '/lib/css/bootstrapWordpressAdmin/less/bootstrap.less');
				// file_put_contents(self::$PLUGIN_PATH . '/lib/css/bootstrapWordpressAdmin/bootstrap.css', $less->parse());

			}
			catch( Exception $e ) {
				echo $e->getMessage();
			}

			//-----
			//Register
			//-----
			//Styles

			if(!wp_style_is('jquery.bootstrap-css', 'registered')):
				wp_register_style('jquery.bootstrap-css', self::$PLUGIN_URL . '/lib/css/bootstrap/bootstrap.css');
			endif;
			if(!wp_style_is('jquery.bootstrap.datepicker-css', 'registered')):
				wp_register_style('jquery.bootstrap.datepicker-css', self::$PLUGIN_URL . '/lib/css/bootstrap.datepicker/bootstrap.datepicker.css');
			endif;
			if(!wp_style_is('jquery.bootstrapWordpressAdmin-css', 'registered')):
				wp_register_style('jquery.bootstrapWordpressAdmin-css', self::$PLUGIN_URL . '/lib/css/bootstrapWordpressAdmin/bootstrap.css');
			endif;

			if( !wp_style_is(self::$SLUG.'-admin.style', 'registered') )
				wp_register_style(self::$SLUG.'-admin.style', self::$PLUGIN_URL.'assets/css-admin/plugins/'.self::$SLUG.'/style.css');

			// if( !wp_style_is('bootstrapcssWP-fixes', 'registered') )
			// 	wp_register_style('bootstrapcssWP-fixes', self::$PLUGIN_URL.'assets/css-admin/bootstrap/bootstrap-fixes.css');

			//-----
			//Encolar
			//-----
			//Styles

			if( !wp_style_is('jquery.bootstrap-css', 'queue')):
				wp_enqueue_style('jquery.bootstrap-css');
			endif;

			if( !wp_style_is('jquery.bootstrap.datepicker-css', 'queue')):
				wp_enqueue_style('jquery.bootstrap.datepicker-css');
			endif;

			if( !wp_style_is('jquery.bootstrapWordpressAdmin-css', 'queue')):
				wp_enqueue_style('jquery.bootstrapWordpressAdmin-css');
			endif;

			if(!wp_style_is(self::$SLUG.'-admin.style', 'queue'))
				wp_enqueue_style(self::$SLUG.'-admin.style');

			// if(!wp_style_is('bootstrapcssWP', 'queue'))
			// 	wp_enqueue_style('bootstrapcssWP');

			// if(!wp_style_is('bootstrapcssWP-fixes', 'queue'))
			// 	wp_enqueue_style('bootstrapcssWP-fixes');
		endif;
	}

	//-- Scripts ADMIN
	public function scripts_ADMIN() {
		if(is_admin()):

			//-----
			//Register
			//-----

			if(!wp_script_is('jquery.bootstrap-transition-js', 'registered')):
				wp_register_script('jquery.bootstrap-transition-js', self::$PLUGIN_URL . 'lib/js/bootstrap/transition.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-alert-js', 'registered')):
				wp_register_script('jquery.bootstrap-alert-js', self::$PLUGIN_URL . 'lib/js/bootstrap/alert.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-modal-js', 'registered')):
				wp_register_script('jquery.bootstrap-modal-js', self::$PLUGIN_URL . 'lib/js/bootstrap/modal.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-dropdown-js', 'registered')):
				wp_register_script('jquery.bootstrap-dropdown-js', self::$PLUGIN_URL . 'lib/js/bootstrap/dropdown.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-scrollspy-js', 'registered')):
				wp_register_script('jquery.bootstrap-scrollspy-js', self::$PLUGIN_URL . 'lib/js/bootstrap/scrollspy.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-tab-js', 'registered')):
				wp_register_script('jquery.bootstrap-tab-js', self::$PLUGIN_URL . 'lib/js/bootstrap/tab.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-tooltip-js', 'registered')):
				wp_register_script('jquery.bootstrap-tooltip-js', self::$PLUGIN_URL . 'lib/js/bootstrap/tooltip.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-popover-js', 'registered')):
				wp_register_script('jquery.bootstrap-popover-js', self::$PLUGIN_URL . 'lib/js/bootstrap/popover.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-button-js', 'registered')):
				wp_register_script('jquery.bootstrap-button-js', self::$PLUGIN_URL . 'lib/js/bootstrap/button.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-collapse-js', 'registered')):
				wp_register_script('jquery.bootstrap-collapse-js', self::$PLUGIN_URL . 'lib/js/bootstrap/collapse.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-carousel-js', 'registered')):
				wp_register_script('jquery.bootstrap-carousel-js', self::$PLUGIN_URL . 'lib/js/bootstrap/carousel.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-affix-js', 'registered')):
				wp_register_script('jquery.bootstrap-affix-js', self::$PLUGIN_URL . 'lib/js/bootstrap/affix.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap.datepicker-js', 'registered')):
				wp_register_script('jquery.bootstrap.datepicker-js', self::$PLUGIN_URL . 'lib/js/bootstrap.datepicker/bootstrap.datepicker.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.keyfilter-js', 'registered')):
				wp_register_script('jquery.keyfilter-js', self::$PLUGIN_URL.'lib/js/jquery.keyfilter.js', array( 'jquery' ), '1', false);
			endif;
			if(!wp_script_is('jquery.charlimit-js', 'registered')):
				wp_register_script('jquery.charlimit-js', self::$PLUGIN_URL.'lib/js/jquery.charlimit.js', array( 'jquery' ), '1', true);
			endif;
			if(!wp_script_is('jquery.validate-js', 'registered')):
				wp_register_script('jquery.validate-js', self::$PLUGIN_URL.'lib/js/jquery.validate.js', array( 'jquery' ), '1', false);
			endif;

//			if(!wp_script_is('tiny_mce', 'registered'))
//				wp_register_script('tiny_mce', self::$PLUGIN_URL.'/assets/js-admin/form/script.js');

			if(!wp_script_is(self::$SLUG.'-admin.script', 'registered'))
				wp_register_script(self::$SLUG.'-admin.script', self::$PLUGIN_URL.'assets/js-admin/plugins/'.self::$SLUG.'/script.js');

			// if(!wp_script_is('bootstrapjs', 'registered'))
			// 	wp_register_script('bootstrapjs', self::$PLUGIN_URL.'assets/js/bootstrap/bootstrap.js');

			//-----
			//Encolar
			//-----
			//Scripts

			if(!wp_script_is('jquery.bootstrap-transition-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-transition-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-alert-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-alert-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-modal-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-modal-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-dropdown-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-dropdown-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-scrollspy-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-scrollspy-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-tab-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-tab-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-tooltip-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-tooltip-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-popover-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-popover-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-button-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-button-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-collapse-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-collapse-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-carousel-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-carousel-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-affix-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-affix-js');
			endif;
			if(!wp_script_is('jquery.bootstrap.datepicker-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap.datepicker-js');
			endif;
			if(!wp_script_is('jquery.keyfilter-js', 'queue')):
				wp_enqueue_script('jquery.keyfilter-js');
			endif;
			if(!wp_script_is('jquery.charlimit-js', 'queue')):
				wp_enqueue_script('jquery.charlimit-js');
			endif;
			if(!wp_script_is('jquery.validate-js', 'queue')):
				wp_enqueue_script('jquery.validate-js');
			endif;

			// if(!wp_script_is('tiny_mce', 'queue'))
			// 	wp_enqueue_script('tiny_mce');

			if(!wp_script_is(self::$SLUG.'-admin.script', 'queue'))
				wp_enqueue_script(self::$SLUG.'-admin.script');

			// if(!wp_script_is('bootstrapjs', 'queue'))
			// 	wp_enqueue_script('bootstrapjs');

		endif;
	}

	//-- Administracion registros
	public function registroVistaADMIN() {
	?>
		<?php 
			//-- Parameters
			// $pag_act  = 	(isset($wp_query->query_vars['pagina'])) ? $wp_query->query_vars['pagina'] : '1';
			$pag_act  = 	is_null($_GET['pagina']) ? 1 : $_GET['pagina'];
			$pag_act  = 	(int) $pag_act;
			$pag_ppp  =	10;

			// var_dump((int) $pag_act);
		?>
		<?php 
			$contacto         = new ContactoDAO();
			$registros        = $contacto->getAll($pag_act, $pag_ppp);
			$registros_pagTot = $contacto->getTotalPages($pag_ppp);
			// var_dump($registros_pagTot);
		?>

		<?php 
			//-- Pagination
			$pag_ran  =	4;
			$pag_tot  = $registros_pagTot;
			// $pag_base =	get_admin_url() . 'admin.php?page=' . self::$SLUG ;
			$pag_base = add_query_arg(array(
				// 'pagina' => $pag_act
				'page' => self::$SLUG
			), admin_url('admin.php'));
			// var_dump($pag_base);
		?>

		<div class="wrap form-admin">
			<div class="icon32 icon32-posts-autos" id="icon-edit"><br></div>
			<h2 class="cabecera"><?php echo self::$PAGADMIN_TITULO; ?>&nbsp;<!--<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">Launch</button>--></h2>

			<!-- Button trigger modal -->

			<!-- Modal -->
			<div class="modal modal_wpadmin fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Modal title</h4>
						</div>
						<div class="modal-body">
							...
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>

			<div class="filters">
				<!-- Nav tabs -->
				<ul class="nav nav-pills">
					<li class="active">
						<a href="#nofilter" data-toggle="tab">No filter</a>
					</li>
					<li>
						<!-- 
						<a href="#date" data-toggle="tab">By Date</a>
						-->
					</li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane nofilter active" id="nofilter">
						<h4 class="titulo">-No filter-</h4>
					</div>
					<div class="tab-pane date" id="date">
						<h4 class="titulo">-By Date-</h4>
						<form>
							<input type="hidden" name="page" value="subscripcion" />
							<div class="fechas">
								<div class="input-daterange input-group" id="datepicker">
									<input type="text" class="input-sm form-control" name="start" />
									<span class="input-group-addon">to</span>
									<input type="text" class="input-sm form-control" name="end" />
								</div>
							</div>
							<button type="submit" class="btn btn-primary btn-md">Reload</button>
						</form>
					</div>
				</div>				
			</div>

			<?php
				if($pag_tot > 1 ):
			?>

				<div class="paginacion">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">

								<?php
									echo "<span style='display:none;'>";
										//var_dump($pgdLinkBase);
									echo "</span>";

									//ajx_programas( $pgdActual, $pgdPorPagina, $pgdPostParent, $pgdRango, $pgdLinkBase );

									//-- Paginacion
									$paginacion	=  self::paginacion($pag_act, $pag_tot, $pag_ran, $pag_base);
									echo $paginacion;
								?>
							</div>
						</div>
					</div>
				</div>
			<?php
				endif;
			?>

			<div class="registros">
				<table class="wp-list-table widefat post fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="numero">#</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Message</th>
							<th>Fecha Creación (aaaa/mm/dd hh:mm:ss)</th>
							<!--<th>Control</th>-->
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="numero">#</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Message</th>
							<th>Fecha Creación (aaaa/mm/dd hh:mm:ss)</th>
							<!--<th>Control</th>-->
						</tr>
					</tfoot>
					<?php
					$numero = 0;
					foreach ($registros as $registro){
					$numero++;
					?>
					<tr>
						<form action="<?php echo $_SERVER[REQUEST_URI]; ?>" method="post">
							<input name="id" value="<?php echo $registro->id; ?>" type="hidden" />
							<input name="email" value="<?php echo $registro->email; ?>" type="hidden" />

							<td class="numero"><?php echo $numero; ?></td>
							<td><?php echo $registro->nombre; ?></td>
							<td><?php echo $registro->apellido; ?></td>
							<td><?php echo $registro->email; ?></td>
							<td><?php echo $registro->asunto; ?></td>
							<td><?php echo $registro->fechacreacion; ?></td>
							<!--<td><input type="submit" class="button" name="borrar" value="Borrar"></td>-->
						</form>
					</tr>
					<?php
					}
					?>
				</table>
			</div>

			<?php
				if($pag_tot > 1 ):
			?>
				<div class="paginacion">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">

								<?php
									echo "<span style='display:none;'>";
										//var_dump($pgdLinkBase);
									echo "</span>";

									//ajx_programas( $pgdActual, $pgdPorPagina, $pgdPostParent, $pgdRango, $pgdLinkBase );

									//-- Paginacion
									$paginacion	=  self::paginacion($pag_act, $pag_tot, $pag_ran, $pag_base);
									echo $paginacion;
								?>
							</div>
						</div>
					</div>
				</div>
			<?php
				endif;
			?>

		</div>
		<script>

			jQuery(document).ready(<?php echo self::$SLUG; ?>_ready);
			function <?php echo self::$SLUG; ?>_ready(){
				//-- 
				jQuery('.input-daterange').datepicker({
					format: "yyyy/mm/dd",
					startView: 1,
					todayBtn: true,
					language: "es",
					orientation: "top auto",
					keyboardNavigation: false,
					forceParse: false,
					todayHighlight: true,
					beforeShowDay: 
					function (date){
						if (date.getMonth() == (new Date()).getMonth())
						{
							switch (date.getDate()){
								case 4:
								return {
									tooltip: 'Example tooltip',
									classes: 'active'
								};
								case 8:
								return false;
								case 12:
								return "green";
							}
						}
					}
				});
			}
		</script>
	<?php
	}

	//-- Admin Menu
	public function adminMenu() {
		add_menu_page(self::$PAGADMIN_TITULO, self::$PAGADMIN_SECCION, 8, self::$SLUG, array($this, 'registroVistaADMIN'), self::$PLUGIN_URL."assets/img-admin/plugins/contacto/favicon.ico", 58);
	}

	//-- Styles
	public function styles() {
		if(!is_admin()):
			//var_dump(get_declared_classes());
			try {
				if(!class_exists('lessc') ):
					throw new Exception('<br><br>¡La clase lessc no ha sido encontrada!<br><br><br>');
				endif;

				// //--
				// $less = new lessc(self::$PLUGIN_PATH. 'lib/css/bootstrap/less/bootstrap.less');
				// file_put_contents(self::$PLUGIN_PATH. 'lib/css/bootstrap/less/bootstrap.css', $less->parse());

				// $less = new lessc(self::$PLUGIN_PATH. 'assets/css/plugins/'.self::$SLUG.'/style.less');
				// file_put_contents(self::$PLUGIN_PATH. 'assets/css/plugins/'.self::$SLUG.'/style.css', $less->parse());

				//$less = new lessc(self::$PLUGIN_PATH.'assets/css/bootstrap/less/bootstrap.less');
				//file_put_contents(self::$PLUGIN_PATH.'assets/css/bootstrap/less/bootstrap.css', $less->parse());
			}
			catch( Exception $e ) {
				echo $e->getMessage();
			}






			//-----
			//Register
			//-----

			//Styles

			//------------------------------------------------------------------------------------ LIB

			if( !wp_style_is('jquery.fancybox-css', 'registered') ):
				wp_register_style('jquery.fancybox-css', self::$PLUGIN_URL . 'lib/css/jquery.fancybox/jquery.fancybox.css');
			endif;
			if( !wp_style_is('jquery.fancybox-buttons-css', 'registered') ):
				wp_register_style('jquery.fancybox-buttons-css', self::$PLUGIN_URL . 'lib/css/jquery.fancybox/helpers/jquery.fancybox-buttons.css');
			endif;
			if( !wp_style_is('jquery.fancybox-thumbs-css', 'registered') ):
				wp_register_style('jquery.fancybox-thumbs-css', self::$PLUGIN_URL . 'lib/css/jquery.fancybox/helpers/jquery.fancybox-thumbs.css');
			endif;


			if(!wp_style_is('jquery.bootstrap-css', 'registered')):
				wp_register_style('jquery.bootstrap-css', self::$PLUGIN_URL . 'lib/css/bootstrap/less/bootstrap.css');
			endif;

			if(!wp_style_is('jquery.jscrollpane-css', 'registered')):
				wp_register_style('jquery.jscrollpane-css', self::$PLUGIN_URL . 'lib/css/jquery.jscrollpane/jquery.jscrollpane.css');
			endif;
			if(!wp_style_is('jquery.jscrollpane.lozenge-css', 'registered')):
				wp_register_style('jquery.jscrollpane.lozenge-css', self::$PLUGIN_URL . 'lib/css/jquery.jscrollpane/jquery.jscrollpane.lozenge.css');
			endif;
			//------------------------------------------------------------------------------------ LIB

			//------------------------------------------------------------------------------------ ASSETS
			if( !wp_style_is(self::$SLUG.'.style', 'registered') ):
				wp_register_style(self::$SLUG.'.style', self::$PLUGIN_URL.'assets/css/plugins/'.self::$SLUG.'/style.css');
			endif;
			//------------------------------------------------------------------------------------ ASSETS


			//-----
			//Enqueque
			//-----

			//Styles

			//------------------------------------------------------------------------------------ LIB
			if( !wp_style_is('jquery.fancybox-css', 'queue' ) ):
				wp_enqueue_style( 'jquery.fancybox-css' );
			endif;
			if( !wp_style_is('jquery.fancybox-buttons-css', 'queue' ) ):
				wp_enqueue_style( 'jquery.fancybox-buttons-css' );
			endif;
			if( !wp_style_is('jquery.fancybox-thumbs-css', 'queue' ) ):
				wp_enqueue_style( 'jquery.fancybox-thumbs-css' );
			endif;

			if( !wp_style_is('jquery.bootstrap-css', 'queue')):
				wp_enqueue_style('jquery.bootstrap-css');
			endif;
			//------------------------------------------------------------------------------------ LIB

			//------------------------------------------------------------------------------------ ASSETS
			if(!wp_style_is(self::$SLUG.'.style', 'queue')):
				wp_enqueue_style(self::$SLUG.'.style');
			endif;
			//------------------------------------------------------------------------------------ ASSETS

			//Aquí pasó algo raro LOL
		endif;
	}

	//-- Scripts
	public function scripts() {
		if(!is_admin()):


			//-----------------
			//Registrar
			//-----------------

			//Scripts

			//------------------------------------------------------------------------------------ LIB
			if( wp_script_is('jquery', 'registered') ):
				wp_deregister_script('jquery');
				wp_register_script('jquery', self::$PLUGIN_URL . 'lib/js/jquery.js', array(), '1.3', false);
			endif;
			if( !wp_script_is('jquery.migrate', 'registered') ):
				wp_register_script('jquery.migrate', self::$PLUGIN_URL . 'lib/js/jquery.migrate.js', array('jquery'), '1.0', false);
			endif;

			if( !wp_script_is('jquery.fancybox-js', 'registered') ):
				wp_register_script('jquery.fancybox-js', self::$PLUGIN_URL . 'lib/js/jquery.fancybox/jquery.fancybox.js', array( 'jquery' ), '1', false);
			endif;
			if( !wp_script_is('jquery.fancybox-thumbs-js', 'registered') ):
				wp_register_script('jquery.fancybox-thumbs-js', self::$PLUGIN_URL . 'lib/js/jquery.fancybox/helpers/jquery.fancybox-thumbs.js', array( 'jquery.fancybox-js' ), '1', false);
			endif;
			if( !wp_script_is('jquery.fancybox-media-js', 'registered') ):
				wp_register_script('jquery.fancybox-thumbs-js', self::$PLUGIN_URL . 'lib/js/jquery.fancybox/helpers/jquery.fancybox-media.js', array( 'jquery.fancybox-js' ), '1', false);
			endif;
			if( !wp_script_is('jquery.fancybox-buttons-js', 'registered') ):
				wp_register_script('jquery.fancybox-buttons-js', self::$PLUGIN_URL . 'lib/js/jquery.fancybox/helpers/jquery.fancybox-buttons.js', array( 'jquery.fancybox-js' ), '1', false);
			endif;

			if(!wp_script_is('jquery.bootstrap-transition-js', 'registered')):
				wp_register_script('jquery.bootstrap-transition-js', self::$PLUGIN_URL . 'lib/js/bootstrap/transition.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-alert-js', 'registered')):
				wp_register_script('jquery.bootstrap-alert-js', self::$PLUGIN_URL . 'lib/js/bootstrap/alert.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-modal-js', 'registered')):
				wp_register_script('jquery.bootstrap-modal-js', self::$PLUGIN_URL . 'lib/js/bootstrap/modal.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-dropdown-js', 'registered')):
				wp_register_script('jquery.bootstrap-dropdown-js', self::$PLUGIN_URL . 'lib/js/bootstrap/dropdown.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-scrollspy-js', 'registered')):
				wp_register_script('jquery.bootstrap-scrollspy-js', self::$PLUGIN_URL . 'lib/js/bootstrap/scrollspy.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-tab-js', 'registered')):
				wp_register_script('jquery.bootstrap-tab-js', self::$PLUGIN_URL . 'lib/js/bootstrap/tab.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-tooltip-js', 'registered')):
				wp_register_script('jquery.bootstrap-tooltip-js', self::$PLUGIN_URL . 'lib/js/bootstrap/tooltip.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-popover-js', 'registered')):
				wp_register_script('jquery.bootstrap-popover-js', self::$PLUGIN_URL . 'lib/js/bootstrap/popover.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-button-js', 'registered')):
				wp_register_script('jquery.bootstrap-button-js', self::$PLUGIN_URL . 'lib/js/bootstrap/button.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-collapse-js', 'registered')):
				wp_register_script('jquery.bootstrap-collapse-js', self::$PLUGIN_URL . 'lib/js/bootstrap/collapse.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-carousel-js', 'registered')):
				wp_register_script('jquery.bootstrap-carousel-js', self::$PLUGIN_URL . 'lib/js/bootstrap/carousel.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-affix-js', 'registered')):
				wp_register_script('jquery.bootstrap-affix-js', self::$PLUGIN_URL . 'lib/js/bootstrap/affix.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.keyfilter-js', 'registered')):
				wp_register_script('jquery.keyfilter-js', self::$PLUGIN_URL.'lib/js/jquery.keyfilter.js', array( 'jquery' ), '1', false);
			endif;
			if(!wp_script_is('jquery.charlimit-js', 'registered')):
				wp_register_script('jquery.charlimit-js', self::$PLUGIN_URL.'lib/js/jquery.charlimit.js', array( 'jquery' ), '1', true);
			endif;
			if(!wp_script_is('jquery.validate-js', 'registered')):
				wp_register_script('jquery.validate-js', self::$PLUGIN_URL.'lib/js/jquery.validate.js', array( 'jquery' ), '1', false);
			endif;

			//------------------------------------------------------------------------------------ LIB

			//------------------------------------------------------------------------------------ ASSETS
			if(!wp_script_is(self::$SLUG.'.script', 'registered')):
				wp_register_script(self::$SLUG.'.script', self::$PLUGIN_URL.'assets/js/plugins/'.self::$SLUG.'/script.js', array( 'jquery' ), '1', false);
			endif;

			//------------------------------------------------------------------------------------ ASSETS

			//-----------------
			//Agregar
			//-----------------

			//Scripts

			//------------------------------------------------------------------------------------ LIB
			if(!wp_script_is( 'jquery', 'queue' ) ):
				wp_enqueue_script('jquery');
			endif;
			if(!wp_script_is( 'jquery.migrate', 'queue' ) ):
				wp_enqueue_script('jquery.migrate');
			endif;


			if(!wp_script_is( 'jquery.fancybox-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.fancybox-js' );
			endif;
			if(!wp_script_is( 'jquery.fancybox-thumbs-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.fancybox-thumbs-js' );
			endif;
			if(!wp_script_is( 'jquery.fancybox-media-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.fancybox-media-js' );
			endif;
			if(!wp_script_is( 'jquery.fancybox-buttons-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.fancybox-buttons-js' );
			endif;


			if(!wp_script_is('jquery.bootstrap-transition-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-transition-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-alert-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-alert-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-modal-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-modal-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-dropdown-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-dropdown-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-scrollspy-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-scrollspy-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-tab-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-tab-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-tooltip-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-tooltip-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-popover-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-popover-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-button-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-button-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-collapse-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-collapse-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-carousel-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-carousel-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-affix-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-affix-js');
			endif;
			if(!wp_script_is('jquery.keyfilter-js', 'queue')):
				wp_enqueue_script('jquery.keyfilter-js');
			endif;
			if(!wp_script_is('jquery.charlimit-js', 'queue')):
				wp_enqueue_script('jquery.charlimit-js');
			endif;
			if(!wp_script_is('jquery.validate-js', 'queue')):
				wp_enqueue_script('jquery.validate-js');
			endif;
			//------------------------------------------------------------------------------------ LIB

			//------------------------------------------------------------------------------------ ASSETS
			if(!wp_script_is(self::$SLUG.'.script', 'queue')):
				wp_enqueue_script(self::$SLUG.'.script');
			endif;
			//------------------------------------------------------------------------------------ ASSETS

		endif;
	}

	//-- Formulario via AJAX desde el front-end
	function registroVista() { ?>
		<!-- MODAL -->
<!--		<div class="modal modal-form hide fade" id="modal-form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Contacto</h3>
			</div>
			<div class="modal-body">-->

		<div class="form_<?php echo self::$SLUG; ?>">
			<div class="form_wrapper" style="width: 100%; margin: 0px auto 0px auto;">


				<form class="form-horizontal form-form" id="form-form">
					<div class="container">


						<div class="row show-grid">
							<div class="col-md-6">
								<div class="container">

									<div class="row show-grid">
										<div class="col-md-12">
											<label class="control-label label-nombre" for="form-nombre">First Name</label>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<div class="form-group">
												<div>
													<input id="form-nombre" class="form-control focused required" name="form[nombre]" placeholder="First Name" maxlength="1000" type="text" value="" />
												</div>
											</div>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<label class="control-label label-nombre" for="form-apellido">Last Name</label>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<div class="form-group">
												<div>
													<input id="form-nombre" class="form-control focused required" name="form[apellido]" placeholder="Last Name" maxlength="1000" type="text" value="" />
												</div>
											</div>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<label class="control-label label-email" for="form-email">E-mail Address</label>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<div class="form-group">
												<div>
													<input id="form-email" class="form-control focused required mask-email" name="form[email]" placeholder="Email" maxlength="200" type="text" value="" />
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
							<div class="col-md-6">
								<div class="container">

									<div class="row show-grid">
										<div class="col-md-12">
											<label class="control-label label-asunto" for="form-asunto">Message</label>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<div class="form-group">
												<div>
													<textarea rows="5" id="form-asunto" class="form-control focused required message" name="form[asunto]" placeholder="Message" maxlength="1500"></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="row show-grid">
										<div class="col-md-12">
											<div class="form-group">
												<div class="controls" style="text-align: left;">
													<button id="form-aceptar" type="submit" class="btn btn-lg btn-primary btn-aceptar" data-loading-text="Sending...">Send</button>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

<!-- 
						<div class="row show-grid">
							<div class="col-md-3">
								<label class="control-label label-direccion" for="form-nombre">Dirección</label>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<div>
										<input id="form-direccion" class="form-control focused required" name="form[direccion]" placeholder="Dirección" maxlength="1000" type="text" value="" />
									</div>
								</div>
							</div>
						</div>
-->
<!-- 
						<div class="row show-grid">
							<div class="col-md-3">
								<label class="control-label label-telefono" for="form-telefono">Teléfono</label>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<div>
										<input id="form-telefono" class="form-control focused required" name="form[telefono]" placeholder="Número telefónico" maxlength="1000" type="text" value="" />
									</div>
								</div>
							</div>
						</div>
-->
<!-- 
						<div class="row show-grid">
							<div class="col-md-12">
								<div class="form-group">
									<div class="controls" style="text-align: center;">
										<button id="form-aceptar" type="submit" class="btn btn-lg btn-primary btn-aceptar" data-loading-text="Enviando...">Contactar</button>
									</div>
								</div>
							</div>
						</div>
-->
					</div>
				</form>

			</div>
		<!-- /MODAL -->
		</div>

		<script>
			jQuery(document).ready(fun_ready);
			function fun_ready()
			{
				var now = new Date();

				// Modal - Form
//				$('#modal-form').modal({
//					keyboard: false,
//					show: false,
//					backdrop: true
//				});

				// Contacto
//				$('body').on('click', 'a[href$="#contacto"]', function (e) {
//					e.preventDefault();
//					$('#modal-form').modal('show');
//				});

				//------------------
				// FORMULARIO Contacto
				//------------------

				// Form
				//formTD         = $('.modal-form .modal-body form');//Formulario Agregar Spec
				formTD           = $('.form_<?php echo self::$SLUG; ?> form');//Formulario Agregar Spec
				//formTDGuardar  = $('.modal-form .modal-footer .btn-aceptar')//Botón Enviar Spec
				formTDGuardar    = $('.btn-aceptar')//Botón Enviar Spec
				//formTDCancelar = $('.modal-form .modal-footer .btn-cancelar')//Botón Enviar Spec
				formTDCancelar   = $('.btn-cancelar')//Botón Enviar Spec

//				// Validaciones
//                formTD.find('input.mask-letras').charLimit({limit: 100});
//                formTD.find('textarea.mask-textarea').charLimit({limit: 500});
//                formTD.find('input.mask-int').charLimit({limit: 15});
//                formTD.find('input.mask-pint').charLimit({limit: 8});
//                formTD.find('input.mask-pfloat').charLimit({limit: 5});

				// Validando formulario (definiendo reglas de validación)
				formTD_validate = formTD.validate({
					submitHandler:
					function(form)
					{
						var sendData          = null;
						sendData              = $(form).serializeArray();
						sendData.push({'name' : 'action', 'value': '<?php echo 'reg'.self::$SLUG; ?>' });
						sendData.push({'name' : 'cmd', 'value': 'agregar'});
						//console.dir(sendData);


						$.ajax({
							url: '<?php bloginfo('url'); ?>/wp-admin/admin-ajax.php',
							type: 'post',
							//dataType: 'json',
							data: $.param(sendData)
						})
						.done(function(data){
							//Show me, show you
							console.dir(data);

							//Resetea estado
							formTDGuardar.button('reset');
							if(data.error)
							{
								alert('We have a problem');
							}
							else
							{
								alert('Thankyou');
								$('#modal-form').hide();
							}

							//-- Validacion
							formTD_validate.resetForm();
							formTD.find('.control-group.has-error').removeClass('has-error');
							formTD.find('.control-group.has-success').removeClass('has-success');
							//formTD.find("input").val("");
							formTD.find("input[name!='f_email'][name!='tipo'][name!='tipo_entrada'][name!='tipo_n'][name!='tipo_f'][name!='tipo_t']").val("");
							formTD.find("textarea").val("");

							//$('#modal-form').modal('hide');

						});
						return false;
					},
					rules:
					{
						//						'nombre',
						//						'fechaform',
						//						'nombre',
						//						'apellido',
						//						'fechanacimiento',
						//						'telefono',
						//						'celular',
						//						'licencia',
						//						'email'
						'form[nombre]'       :
						{
						required             : true,
						maxlength            : 400
						},
						'form[apellido]'     :
						{
						required             : true,
						maxlength            : 400
						},
						'form[telefono]'     :
						{
						required             : true,
						minlength            : 8,
						maxlength            : 8,
						number               : true
						},
						'form[tema_interes]' :
						{
						required             : true,
						maxlength            : 500
						},
						'form[email]'        :
						{
						required             : true,
						maxlength            : 500,
						email                : true
						},
						'form[asunto]'       :
						{
						required             : true,
						maxlength            : 1500
						}
					},
					highlight      :
					function(element, errorClass, validClass){
						$(element)
						.closest('.form-group')
						.removeClass(validClass)
						.addClass(errorClass);
					},
					unhighlight    :
					function(element, errorClass, validClass){
						$(element)
						.closest('.form-group')
						.removeClass(errorClass)
						.addClass(validClass);
					},
					success        :
					function(label){
					},
					validClass     : "has-success",
					errorClass     : "has-error",
					errorElement   : "em",
					errorPlacement :
					function(error, element)
					{
						error.appendTo( element.parent() );
					}

				});
				// Click Guardar
				formTDGuardar.on('click', function(ele){
					ele.preventDefault();
					formTD_validate.resetForm();
					formTDGuardar.find('.form-group.has-error').removeClass('has-error');
					formTDGuardar.find('.form-group.has-success').removeClass('has-success');

                    if(formTD.valid() == true){
                        formTDGuardar.button('reset');
                        formTDGuardar.button('loading');
                    }
                    formTD.submit();
				});

			}
		</script>
	<?php
	}

	//-- "Controlador" para las peticiones
	function registroController() {
		global $_POST;

		$contacto = $_POST['form'];

		//var_dump($contacto);

		$res = self::validar($contacto);

		if($res['error'] == 0):

			$contactoDAO = new ContactoDAO();

//			if($contactoDAO->existe($contacto['email'])):
//				$res['msg'] = 'Ya hay un form con ese correo';
//				$res['err'] = 1;
//			else:
//				$ins = $contactoDAO->insertar($contacto);
//				$res['msg'] = 'Registro insertado con exito: '.$ins;
//				global $email_html;
//				wp_mail($contacto['email'], 'Solicitud form recibida', $email_html);
//			endif;

			$ins = $contactoDAO->insertar($contacto);

			//self::correoUsuario($contacto);
			self::correoAdmin($contacto);

			$res['mensaje'] = 'Registro insertado con exito: '.$ins;
			//$res['err'] = 0;

		else:
			//Existente
			$res['mensaje'] = 'Problemas';
			$res['error'] = 1;
		endif;

		//var_dump($json);
		//var_dump($contacto);

		die(json_encode($res));
	}

	//-- Intall
	public static function install() {
		global $wpdb;
		$contacto = new ContactoDAO();

		if ($wpdb->get_var("show tables like '".$contacto->getTableName()."'") != $contacto->getTableName()) {

			$sql =
			"CREATE TABLE IF NOT EXISTS `".$contacto->getTableName()."`
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`nombre` varchar(500) NOT NULL,
				`apellido` varchar(500) NOT NULL,
				`tema_interes` varchar(500) NOT NULL,
				`telefono` varchar(500) NOT NULL,
				`email` varchar(500) NOT NULL,
				`asunto` text NOT NULL,
				`direccion` text NOT NULL,
				`fechacreacion` timestamp NULL DEFAULT NULL,
				`borrado` INT(1) DEFAULT '0',
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";


			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}

		add_option(self::$PLUGIN_SLUG."_db_version", "1.0");
	}
}
?>