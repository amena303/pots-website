<?php
	/*
	Plugin Name: Kernel
	Plugin URI:
	Description: Define tipos, taxonomías, widgets y métodos necesarios para todos lo que necesita el CMS
	Version: 0.1
	Author: dr__martin
	Author URI: http://twitter.com/dr__martin
	License: Licencia GI
	*/
 
	//-- Define
	define(PLUGIN_PATH, plugin_dir_path( __FILE__ ));
	define(PLUGIN_URL, plugin_dir_url( __FILE__ ));
	define(PLUGIN_SLUG, __FILE__ );

	//-- Includes
	include_once 'util.php';
	//include_once 'plugins/kernel/plugin.php';
	include_once 'plugins/contacto/plugin.php';
	include_once 'plugins/subscripcion/plugin.php';
	//include_once 'widgets/staff/widget.php';
	//include_once 'widgets/twitter/widget.php';
	//include_once 'widgets/noticias/widget.php';
	//include_once 'widgets/blog/widget.php';
	//include_once 'widgets/bisnesbook/widget.php';
	//include_once 'widgets/aquisedijo/widget.php';
	//include_once 'widgets/programa/widget.php';
	//include_once 'widgets/rescate/widget.php';
	//include_once 'widgets/alertas/widget.php';
	//include_once 'widgets/anuncio/widget.php';
	//include_once 'widgets/division/widget.php';

	//Includes
	//include_once 'plugins/autos/autos.php';
	//include_once 'plugins/autos.specs/specs.php';
	//include_once 'paginacion.class.php';

	if(!class_exists('lessc')):
		//throw new Exception('<br>¡La clase Radio no ha sido encontrada!<br>');
		include_once 'inc/lessphp/lessc.inc.php';
	endif;

	//-- Verificando
	try {
		// if( !class_exists('Kernel') ):
		// 	throw new Exception('<br>¡La clase Radio no ha sido encontrada!<br>');
		// endif;
		if( !class_exists('Contacto') ):
			throw new Exception('<br>¡La clase Contacto no ha sido encontrada!<br>');
		endif;
	}
	catch( Exception $e ) {
		echo $e->getMessage();
	}

	//-- Kernel
	//new Kernel();
	//-- Plugin
	new Contacto();
	//-- Plugin
	new Subscripcion();

	//-- Hooks
	register_activation_hook(__FILE__, 'plugin_install');

	//-- Instalación
	function plugin_install() {
		Contacto::install();
		Subscripcion::install();
		//Kernel::install();
	}


?>