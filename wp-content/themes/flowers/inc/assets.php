<?php
/**
 * Implement Custom Header functionality for Flowers
 *
 * @package WordPress
 * @subpackage Flowers
 * @since Flowers 1.0
 */


	define('TEMPLATEPATH', get_template_directory_uri());
	define('TEMPLATEURL',  get_bloginfo('template_directory'));

	if(!class_exists('lessc')):
		//throw new Exception('<br>¡La clase LESSC no ha sido encontrada!<br>');
		include_once TEMPLATEPATH.'/inc/lessphp/lessc.inc.php';
	endif;


	//--
	add_action( 'wp_enqueue_scripts', 'styles' );
	add_action( 'wp_enqueue_scripts', 'scripts' );

	//-------------------------------
	//-- ASSETS CLIENT
	//-------------------------------
	//-- Enqueues scripts for front-end.
	function scripts() {

		if(!is_admin()):

			//-----------------
			//Registrar
			//-----------------

			//Scripts

			//------------------------------------------------------------------------------------ LIB
			if( wp_script_is('jquery', 'registered') ):
				wp_deregister_script('jquery');
				wp_register_script('jquery', TEMPLATEURL . '/lib/js/jquery.js', array(), '1.7.1', false);
			endif;
			if( !wp_script_is('jquery.migrate', 'registered') ):
				wp_register_script('jquery.migrate', TEMPLATEURL . '/lib/js/jquery.migrate.js', array('jquery'), '1.0', false);
			endif;


			if( !wp_script_is('jquery.waypoints-js', 'registered') ):
				wp_register_script('jquery.waypoints-js', TEMPLATEURL . '/lib/js/jquery.waypoints.js', array(), '1', false);
			endif;
			if( !wp_script_is('jquery.waypoints.sticky-js', 'registered') ):
				wp_register_script('jquery.waypoints.sticky-js', TEMPLATEURL . '/lib/js/jquery.waypoints.sticky.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('jquery.path-js', 'registered') ):
				wp_register_script('jquery.path-js', TEMPLATEURL . '/lib/js/jquery.path.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('jquery.easing-js', 'registered') ):
				wp_register_script('jquery.easing-js', TEMPLATEURL . '/lib/js/jquery.easing.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('jquery.tween-js', 'registered') ):
				wp_register_script('jquery.tween-js', TEMPLATEURL . '/lib/js/jquery.tween.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('jquery.curve-js', 'registered') ):
				wp_register_script('jquery.curve-js', TEMPLATEURL . '/lib/js/jquery.curve.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('jquery.curve.animate-js', 'registered') ):
				wp_register_script('jquery.curve.animate-js', TEMPLATEURL . '/lib/js/jquery.curve.animate.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('jquery.transform-js', 'registered') ):
				wp_register_script('jquery.transform-js', TEMPLATEURL . '/lib/js/jquery.transform.js', array( 'jquery' ), '1', false);
			endif;


			if( !wp_script_is('skrollr-js', 'registered') ):
				wp_register_script('skrollr-js', TEMPLATEURL . '/lib/js/skrollr.js', array(), '1', true);
			endif;


			if( !wp_script_is('jquery.fancybox-js', 'registered') ):
				wp_register_script('jquery.fancybox-js', TEMPLATEURL . '/lib/js/jquery.fancybox/jquery.fancybox.js', array( 'jquery' ), '1', false);
			endif;
			if( !wp_script_is('jquery.fancybox-thumbs-js', 'registered') ):
				wp_register_script('jquery.fancybox-thumbs-js', TEMPLATEURL . '/lib/js/jquery.fancybox/helpers/jquery.fancybox-thumbs.js', array( 'jquery.fancybox-js' ), '1', false);
			endif;
			if( !wp_script_is('jquery.fancybox-media-js', 'registered') ):
				wp_register_script('jquery.fancybox-thumbs-js', TEMPLATEURL . '/lib/js/jquery.fancybox/helpers/jquery.fancybox-media.js', array( 'jquery.fancybox-js' ), '1', false);
			endif;
			if( !wp_script_is('jquery.fancybox-buttons-js', 'registered') ):
				wp_register_script('jquery.fancybox-buttons-js', TEMPLATEURL . '/lib/js/jquery.fancybox/helpers/jquery.fancybox-buttons.js', array( 'jquery.fancybox-js' ), '1', false);
			endif;


			if(!wp_script_is('googlejsapi', 'registered')):
				wp_register_script('googlejsapi', '//www.google.com/jsapi', array(), '', false);
			endif;

			if(!wp_script_is('swfobject-js', 'registered')):
				wp_register_script('swfobject-js', TEMPLATEURL . '/lib/js/swfobject.js', array(), '', false);
			endif;


			if(!wp_script_is('jquery.bootstrap-transition-js', 'registered')):
				wp_register_script('jquery.bootstrap-js', TEMPLATEURL . '/lib/js/bootstrap/transition.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-alert-js', 'registered')):
				wp_register_script('jquery.bootstrap-alert-js', TEMPLATEURL . '/lib/js/bootstrap/alert.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-modal-js', 'registered')):
				wp_register_script('jquery.bootstrap-modal-js', TEMPLATEURL . '/lib/js/bootstrap/modal.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-dropdown-js', 'registered')):
				wp_register_script('jquery.bootstrap-dropdown-js', TEMPLATEURL . '/lib/js/bootstrap/dropdown.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-scrollspy-js', 'registered')):
				wp_register_script('jquery.bootstrap-scrollspy-js', TEMPLATEURL . '/lib/js/bootstrap/scrollspy.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-tab-js', 'registered')):
				wp_register_script('jquery.bootstrap-tab-js', TEMPLATEURL . '/lib/js/bootstrap/tab.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-tooltip-js', 'registered')):
				wp_register_script('jquery.bootstrap-tooltip-js', TEMPLATEURL . '/lib/js/bootstrap/tooltip.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-popover-js', 'registered')):
				wp_register_script('jquery.bootstrap-popover-js', TEMPLATEURL . '/lib/js/bootstrap/popover.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-button-js', 'registered')):
				wp_register_script('jquery.bootstrap-button-js', TEMPLATEURL . '/lib/js/bootstrap/button.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-collapse-js', 'registered')):
				wp_register_script('jquery.bootstrap-collapse-js', TEMPLATEURL . '/lib/js/bootstrap/collapse.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-carousel-js', 'registered')):
				wp_register_script('jquery.bootstrap-carousel-js', TEMPLATEURL . '/lib/js/bootstrap/carousel.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.bootstrap-affix-js', 'registered')):
				wp_register_script('jquery.bootstrap-affix-js', TEMPLATEURL . '/lib/js/bootstrap/affix.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.jscrollpane-js', 'registered')):
				wp_register_script('jquery.jscrollpane-js', TEMPLATEURL . '/lib/js/jquery.jscrollpane/jquery.jscrollpane.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.mousewheel-js', 'registered')):
				wp_register_script('jquery.mousewheel-js', TEMPLATEURL . '/lib/js/jquery.mousewheel.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.history-js', 'registered')):
				wp_register_script('jquery.history-js', TEMPLATEURL . '/lib/js/jquery.history.js', array(), '', false);
			endif;
			if(!wp_script_is('staterouter-js', 'registered')):
				wp_register_script('staterouter-js', TEMPLATEURL . '/lib/js/staterouter.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.imagesloaded-js', 'registered')):
				wp_register_script('jquery.imagesloaded-js', TEMPLATEURL . '/lib/js/jquery.imagesloaded.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.wookmark-js', 'registered')):
				wp_register_script('jquery.wookmark-js', TEMPLATEURL . '/lib/js/jquery.wookmark.js', array(), '', false);
			endif;
			if(!wp_script_is('typeahead.bundle-js', 'registered')):
				wp_register_script('typeahead.bundle-js', TEMPLATEURL . '/lib/js/typeahead.bundle.js', array(), '', false);
			endif;
			if(!wp_script_is('handlebars-js', 'registered')):
				wp_register_script('handlebars-js', TEMPLATEURL . '/lib/js/handlebars.js', array(), '', false);
			endif;

			if(!wp_script_is('jquery.animate-colors-js', 'registered')):
				wp_register_script('jquery.animate-colors-js', TEMPLATEURL . '/lib/js/jquery.animate-colors.js', array(), '', false);
			endif;

			if(!wp_script_is('jquery.backstretch-js', 'registered')):
				wp_register_script('jquery.backstretch-js', TEMPLATEURL . '/lib/js/jquery.backstretch.js', array(), '', false);
			endif;
			if(!wp_script_is('jquery.modernizr-js', 'registered')):
				wp_register_script('jquery.modernizr-js', TEMPLATEURL . '/lib/js/modernizr.2.5.3.min.js', array(), '', true);
			endif;

			//------------------------------------------------------------------------------------ LIB

			//------------------------------------------------------------------------------------ ASSETS
			if( !wp_script_is('script', 'registered') ):
				wp_register_script('script', TEMPLATEURL . '/assets/js/script.js', array(), '1', true);
			endif;
			if( !wp_script_is('script_skr', 'registered') ):
				wp_register_script('script_skr', TEMPLATEURL . '/assets/js/script_skr.js', array(), '1', true);
			endif;
			if(!wp_script_is('script_magazine', 'registered')):
				wp_register_script('script_magazine', TEMPLATEURL . '/assets/js/script_magazine.js', array(), '', true);
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


			if(!wp_script_is( 'jquery.waypoints-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.waypoints-js' );
			endif;
			if(!wp_script_is( 'jquery.waypoints.sticky-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.waypoints.sticky-js' );
			endif;


			if(!wp_script_is( 'jquery.path-js', 'queue' ) ):
				//wp_enqueue_script( 'jquery.path-js' );
			endif;


			if(!wp_script_is( 'jquery.easing-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.easing-js' );
			endif;


			if(!wp_script_is( 'jquery.tween-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.tween-js' );
			endif;


			if(!wp_script_is( 'jquery.cruve-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.curve-js' );
			endif;


			if(!wp_script_is( 'jquery.curve.animate-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.curve.animate-js' );
			endif;


			if(!wp_script_is( 'jquery.transform-js', 'queue' ) ):
				wp_enqueue_script( 'jquery.transform-js' );
			endif;


			if(!wp_script_is( 'skrollr-js', 'queue' ) ):
				//wp_enqueue_script( 'skrollr-js' );
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


			if(!wp_script_is('googlejsapi', 'queue')):
				//wp_enqueue_script('googlejsapi');
			endif;
			if(!wp_script_is('swfobject-js', 'queue')):
				wp_enqueue_script('swfobject-js');
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
				//wp_enqueue_script('jquery.bootstrap-scrollspy-js');
			endif;
			if(!wp_script_is('jquery.bootstrap-js', 'queue')):
				wp_enqueue_script('jquery.bootstrap-js');
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
			if(!wp_script_is('jquery.jscrollpane-js', 'queue')):
				wp_enqueue_script('jquery.jscrollpane-js');
			endif;
			if(!wp_script_is('jquery.mousewheel-js', 'queue')):
				wp_enqueue_script('jquery.mousewheel-js');
			endif;
			if(!wp_script_is('jquery.history-js', 'queue')):
				//wp_enqueue_script('jquery.history-js');
			endif;
			if(!wp_script_is('staterouter-js', 'queue')):
				//wp_enqueue_script('staterouter-js');
			endif;
			if(!wp_script_is('jquery.imagesloaded-js', 'queue')):
				wp_enqueue_script('jquery.imagesloaded-js');
			endif;
			if(!wp_script_is('jquery.wookmark-js', 'queue')):
				wp_enqueue_script('jquery.wookmark-js');
			endif;
			if(!wp_script_is('typeahead.bundle-js', 'queue')):
				wp_enqueue_script('typeahead.bundle-js');
			endif;
			if(!wp_script_is('handlebars-js', 'queue')):
				wp_enqueue_script('handlebars-js');
			endif;
			if(!wp_script_is('jquery.animate-colors-js', 'queue')):
				//wp_enqueue_script('jquery.animate-colors-js');
			endif;
			if(!wp_script_is('jquery.backstretch-js', 'queue')):
				//wp_enqueue_script('jquery.backstretch-js');
			endif;
			if(!wp_script_is('jquery.modernizr-js', 'queue')):
				//wp_enqueue_script('jquery.modernizr-js');
			endif;
			if(!wp_script_is('script_magazine', 'queue')):
				//wp_enqueue_script('script_magazine');
			endif;


			//------------------------------------------------------------------------------------ LIB

			//------------------------------------------------------------------------------------ ASSETS
			if(!wp_script_is( 'script', 'queue' ) ):
				wp_enqueue_script( 'script' );
			endif;
			if(!wp_script_is( 'script_skr', 'queue' ) ):
				//wp_enqueue_script( 'script_skr' );
			endif;
			//------------------------------------------------------------------------------------ ASSETS

		endif;
	}

	//-- Enqueues styles for front-end.
	function styles() {
		global $wp_styles;


		//-- Generando LESS
		if (!is_admin()):

			//Estilo

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/bootstrap/less/bootstrap.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/bootstrap/less/bootstrap.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/jquery.jscrollpane/jquery.jscrollpane.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/jquery.jscrollpane/jquery.jscrollpane.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/jquery.jscrollpane/jquery.jscrollpane.lozenge.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/jquery.jscrollpane/jquery.jscrollpane.lozenge.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-futura_cnd_md.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-futura_cnd_md.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-helvetica_neue.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-helvetica_neue.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-helvetica_neue_ltstdmdcno.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-helvetica_neue_ltstdmdcno.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-glyphicons_halflings_regular.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-glyphicons_halflings_regular.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-opensans_condbold.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-opensans_condbold.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-opensans_condlight.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-opensans_condlight.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/lib/css/fonts/font-genericons_regular.less');
			// file_put_contents(TEMPLATEPATH . '/lib/css/fonts/font-genericons_regular.css', $less->parse());

			//-- Estilo
			$less = new lessc(TEMPLATEPATH . '/assets/css/style_ie.less');
			// file_put_contents(TEMPLATEPATH . '/assets/css/style_ie.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/assets/css/style.less');
			file_put_contents(TEMPLATEPATH . '/assets/css/style.css', $less->parse());

			//--
			$less = new lessc(TEMPLATEPATH . '/assets/css/style-960/style.less');
			file_put_contents(TEMPLATEPATH . '/assets/css/style-960.css', $less->parse());

		endif;

		//-----
		//Register
		//-----

		//Styles

		//------------------------------------------------------------------------------------ LIB

		if( !wp_style_is('jquery.fancybox-css', 'registered') ):
			wp_register_style('jquery.fancybox-css', TEMPLATEURL . '/lib/css/jquery.fancybox/jquery.fancybox.css');
		endif;
		if( !wp_style_is('jquery.fancybox-buttons-css', 'registered') ):
			wp_register_style('jquery.fancybox-buttons-css', TEMPLATEURL . '/lib/css/jquery.fancybox/helpers/jquery.fancybox-buttons.css');
		endif;
		if( !wp_style_is('jquery.fancybox-thumbs-css', 'registered') ):
			wp_register_style('jquery.fancybox-thumbs-css', TEMPLATEURL . '/lib/css/jquery.fancybox/helpers/jquery.fancybox-thumbs.css');
		endif;


		if(!wp_style_is('jquery.bootstrap-css', 'registered')):
			wp_register_style('jquery.bootstrap-css', TEMPLATEURL . '/lib/css/bootstrap/less/bootstrap.css');
		endif;

		if(!wp_style_is('jquery.jscrollpane-css', 'registered')):
			wp_register_style('jquery.jscrollpane-css', TEMPLATEURL . '/lib/css/jquery.jscrollpane/jquery.jscrollpane.css');
		endif;
		if(!wp_style_is('jquery.jscrollpane.lozenge-css', 'registered')):
			wp_register_style('jquery.jscrollpane.lozenge-css', TEMPLATEURL . '/lib/css/jquery.jscrollpane/jquery.jscrollpane.lozenge.css');
		endif;


		if( !wp_style_is('font-futura_cnd_md', 'registered') ):
			wp_register_style( 'font-futura_cnd_md', TEMPLATEURL . '/lib/css/fonts/font-futura_cnd_md.css' );
		endif;
		if( !wp_style_is('font-helvetica_neue', 'registered') ):
			wp_register_style( 'font-helvetica_neue', TEMPLATEURL . '/lib/css/fonts/font-helvetica_neue.css' );
		endif;
		if( !wp_style_is('font-helvetica_neue_ltstdmdcno', 'registered') ):
			wp_register_style( 'font-helvetica_neue_ltstdmdcno', TEMPLATEURL . '/lib/css/fonts/font-helvetica_neue_ltstdmdcno.css' );
		endif;
		if( !wp_style_is('font-glyphicons_halflings_regular', 'registered') ):
			wp_register_style( 'font-glyphicons_halflings_regular', TEMPLATEURL . '/lib/css/fonts/font-glyphicons_halflings_regular.css' );
		endif;
		if( !wp_style_is('font-opensans_condbold', 'registered') ):
			wp_register_style( 'font-opensans_condbold', TEMPLATEURL . '/lib/css/fonts/font-opensans_condbold.css' );
		endif;
		if( !wp_style_is('font-opensans_condlight', 'registered') ):
			wp_register_style( 'font-opensans_condlight', TEMPLATEURL . '/lib/css/fonts/font-opensans_condlight.css' );
		endif;
		if( !wp_style_is('font-genericons_regular', 'registered') ):
			wp_register_style( 'font-genericons_regular', TEMPLATEURL . '/lib/css/fonts/font-genericons_regular.css' );
		endif;
		//------------------------------------------------------------------------------------ LIB

		//------------------------------------------------------------------------------------ ASSETS
		if( !wp_style_is('tema-style', 'registered') ):
			wp_register_style( 'tema-style', TEMPLATEURL . '/assets/css/style.css' );
		endif;
		if( !wp_style_is('tema-style-960', 'registered') ):
			wp_register_style( 'tema-style-960', TEMPLATEURL . '/assets/css/style-960.css' );
		endif;
		if( !wp_style_is('tema-style-ie', 'registered') ):
			wp_register_style( 'tema-style-ie', TEMPLATEURL . '/assets/css/style_ie.css' );
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

		if(!wp_style_is('jquery.jscrollpane-css', 'queue')):
			wp_enqueue_style('jquery.jscrollpane-css');
		endif;
		if(!wp_style_is('jquery.jscrollpane.lozenge-css', 'queue')):
			wp_enqueue_style('jquery.jscrollpane.lozenge-css');
		endif;

		if( !wp_style_is('font-futura_cnd_md', 'queue')):
			wp_enqueue_style('font-futura_cnd_md');
		endif;
		if( !wp_style_is('font-helvetica_neue', 'queue')):
			wp_enqueue_style('font-helvetica_neue');
		endif;
		if( !wp_style_is('font-helvetica_neue_ltstdmdcno', 'queue')):
			wp_enqueue_style('font-helvetica_neue_ltstdmdcno');
		endif;
		if( !wp_style_is('font-glyphicons_halflings_regular', 'queue')):
			wp_enqueue_style('font-glyphicons_halflings_regular');
		endif;
		if( !wp_style_is('font-opensans_condbold', 'queue')):
			wp_enqueue_style('font-opensans_condbold');
		endif;
		if( !wp_style_is('font-opensans_condlight', 'queue')):
			wp_enqueue_style('font-opensans_condlight');
		endif;
		if( !wp_style_is('font-genericons_regular', 'queue')):
			wp_enqueue_style('font-genericons_regular');
		endif;
		//------------------------------------------------------------------------------------ LIB

		//------------------------------------------------------------------------------------ ASSETS
		if(!wp_style_is( 'tema-style', 'queue') ):
			wp_enqueue_style( 'tema-style' );
		endif;
		if(!wp_style_is( 'tema-style-960', 'queue') ):
			wp_enqueue_style( 'tema-style-960' );
		endif;
		if(!wp_style_is( 'tema-style-ie', 'queue') ):
			wp_enqueue_style( 'tema-style-ie', array( 'tema-style' ), '20121010' );
			$wp_styles->add_data( 'tema-style-ie', 'conditional', 'lt IE 9' );
		endif;
		//------------------------------------------------------------------------------------ ASSETS

		//-- Loads the Internet Explorer specific stylesheet.
		//wp_enqueue_style( 'style-ie', TEMPLATEURL . '/css/style_ie.css', array( 'style-style' ), '20121010' );
		//$wp_styles->add_data( 'style-ie', 'conditional', 'lt IE 9' );
	}

