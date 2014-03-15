<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */




	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);
	global $page, $paged, $post;

	//--
	//$template = get_post_meta( $post->ID, '_wp_page_template', FALSE);
	//var_dump($template);

	//-- Tpl
	//$pag_tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	$pag_tpl = get_page_template_slug( $post->ID );
	$pag_tpl = str_replace(array('page-templates/', '.php'), array('',''), $pag_tpl);

	//-- Titulo Superior
	$titulo_superior = get_bloginfo( 'name' );

	//-- Titulo Sitio
	$titulo_sitio = get_bloginfo( 'name' );

	//-- Pagina nombre
	$titulo_pagina = $post->post_title;
	//-- Pagina nombre
	$titulo_name = $post->post_name;

	//-- Agregar la descripcion para home/front page
	$descripcion_fb = get_bloginfo( 'description', 'display' );
	$descripcion = get_bloginfo( 'description', 'display' );

	//-- Tipo
	$tipo = "article";

	//-- Imagen
	$imagen_fb = get_bloginfo('wpurl')."/logo-230.png";

	//-- Enlace
	$enlace = get_permalink();

	//-- Usuario
	$usr_name = '';

	//-- 
	$autor_dev = "pliskin";

	//-- Página
	if ((is_home() || is_front_page()) ) :
		$titulo_superior = $titulo_superior;
		$titulo_pagina = get_bloginfo( 'name' );
		$tipo = "article";
		$imagen_fb = get_bloginfo('wpurl')."/logo-230.png";
		$autor = $autor_dev;
		$descripcion_fb = get_bloginfo( 'description', 'display' );
		$descripcion = get_bloginfo( 'description', 'display' );
		//$enlace = get_permalink();
	else:
		if(is_page()):
			$titulo_superior = $titulo_pagina.' | '.$titulo_superior;
			$tipo = "article";
			$imagen_fb = get_bloginfo('wpurl')."/logo-230.png";
			$autor = $autor_dev;

			$descripcion_fb = get_the_excerpt();
			$descripcion_fb = $descripcion_fb == '' ? get_bloginfo( 'description', 'display' ) : $descripcion_fb;

			$descripcion = get_the_excerpt();
			$descripcion = $descripcion == '' ? get_bloginfo( 'description', 'display' ) : $descripcion;
			//$enlace = get_permalink();

		else:
			if(is_single()):
				$titulo_superior = $titulo_pagina.' | '.$titulo_superior;
				$tipo = "article";
				$imagen_fb = get_bloginfo('wpurl')."/logo-230.png";
				$autor = $autor_dev;
				$descripcion_fb = get_the_excerpt();
				$descripcion = get_the_excerpt();
				//$enlace = get_permalink();

				switch($post->post_type) :

					// case 'staff':
					// 	$descripcion_fb = get_the_excerpt();
					// 	$descripcion_fb = $descripcion_fb == '' ? get_bloginfo( 'description', 'display' ) : $descripcion_fb;

					// 	$descripcion = get_the_excerpt();
					// 	$descripcion = $descripcion == '' ? get_bloginfo( 'description', 'display' ) : $descripcion;

					// 	$imagen_fb = image_destacada( $post->ID );
					// 	if(!$imagen_fb):
					// 		$imagen_fb = get_bloginfo('wpurl')."/logo230.png";
					// 	endif;

					// 	//if (has_post_thumbnail( $post->ID )) :
					// 	//	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
					// 	//	$imagen_fix = get_bloginfo('template_directory').'/inc/tmb/?src='.$image[0].'&w=200&h=200&zc=1';
					// 	//	$imagen_fb = $imagen_fix;
					// 	//endif;
					// break;

					// case 'programa':
					// 	$descripcion_fb = get_the_excerpt();
					// 	$descripcion_fb = $descripcion_fb == '' ? get_bloginfo( 'description', 'display' ) : $descripcion_fb;

					// 	$descripcion = get_the_excerpt();
					// 	$descripcion = $descripcion == '' ? get_bloginfo( 'description', 'display' ) : $descripcion;

					// 	$imagen_fb = image_destacada( $post->ID );
					// 	if(!$imagen_fb):
					// 		$imagen_fb = get_bloginfo('wpurl')."/logo230.png";
					// 	endif;

					// 	//if (has_post_thumbnail( $post->ID )) :
					// 	//	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
					// 	//	$imagen_fix = get_bloginfo('template_directory').'/inc/tmb/?src='.$image[0].'&w=200&h=200&zc=1';
					// 	//	$imagen_fb = $imagen_fix;
					// 	//endif;
					// break;

					// case 'noticia':
					// 	$pid		= $post->ID;
					// 	$obj		= get_post_custom($pid);
					// 	$enlace_feed= $obj["syndication_permalink"][0];
					// 	$enlace_feed= $enlace_feed."/feed/?withoutcomments=1";

					// 	//-- Import rss feed
					// 	if(function_exists('fetch_feed') && $enlace_feed) :
					// 		//-- ...
					// 		add_filter( 'wp_feed_cache_transient_lifetime' , 'refresco_corto' );

					// 		//-- Fetch feed items
					// 		$rss = fetch_feed($enlace_feed);

					// 		//-- ...
					// 		remove_filter( 'wp_feed_cache_transient_lifetime' , 'refresco_corto' );

					// 		//--
					// 		if(!is_wp_error($rss)) : // error check
					// 			//-- Figure out how many total items there are, but limit it to 5.
					// 			$maxitems = $rss->get_item_quantity(1); // number of items
					// 			//-- Build an array of all the items, starting with element 0 (first element).
					// 			$rss_items = $rss->get_items(0, $maxitems);
					// 		endif;

					// 		if ($maxitems == 0) :
					// 			$res = "";
					// 		else :
					// 			$encontrado += 1;
					// 			//$res	=	"";
					// 			//$res	.=	"<li>";
					// 			foreach ($rss_items as $rss) :
					// 				//-- Titulo
					// 				$rss_titulo = $rss->get_title();
					// 				//-- Texto
					// 				$rss_texto = $rss->get_description();
					// 				$rss_texto = preg_replace("/<img[^>]+\>/i", "", $rss_texto);
					// 				$rss_texto = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $rss_texto);
					// 				//-- Imagen
					// 				$rss_img_nod	= $rss->get_item_tags('','image');
					// 				$rss_img_arc	= $rss_img_nod[0];
					// 				$rss_img_min	= get_bloginfo('template_directory').'/inc/tmb/?src='.(trim($rss_img_arc['data'])).'&w=200&h=200&zc=1';

					// 				//-- Facebook
					// 				$imagen_fb = $rss_img_min;
					// 				if(!$imagen_fb):
					// 					$imagen_fb = get_bloginfo('wpurl')."/logo230.png";
					// 				endif;
					// 				$descripcion_fb = $rss_texto;
					// 				$descripcion_fb = $descripcion_fb == '' ? get_bloginfo( 'description', 'display' ) : $descripcion_fb;

					// 				$descripcion = $rss_texto;
					// 				$descripcion = $descripcion == '' ? get_bloginfo( 'description', 'display' ) : $descripcion;
					// 			endforeach;

					// 			//$res_total	.= $res;
					// 		endif;
					// 	endif;
					// break;

					default:
					break;
				endswitch;

				//echo "<span style='display:none;'>...".$post->post_type."</span>";
			endif;
		endif;
	endif;

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php echo $titulo_superior; ?><?php //wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta property="og:title" content="<?php echo $titulo_pagina; ?>" />
	<meta property="og:type" content="<?php echo $tipo; ?>" />
	<meta property="og:url" content="<?php echo $enlace; ?>"/>
	<meta property="og:image" content="<?php echo $imagen_fb; ?>" />
	<meta property="og:site_name" content="<?php echo $titulo_sitio; ?>" />
	<meta property="og:description" content="<?php echo $descripcion_fb; ?>"/>

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site glob-<?php echo $pag_tpl; ?>">

	<header id="site-header" class="site-header" role="banner">
		<div class="header-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo TEMPLATEURL.'/assets/img/img-960/miscelaneo/logo.png'; ?>" width="118" height="128" alt="" />
			</a>
		</div>
		<div class="header-main">
			<div class="sup">
				<span class="etiqueta">Follow Us!</span>
				<nav id="social-navigation" class="social-navigation" role="navigation">
					<?php
						//-- 
						$menu = '';
						$menu =
						wp_nav_menu(array(
							'theme_location' 	=> 'primary',
							'container' 		=> 'ul',
							//'container_id' 		=> 'menusuperior',
							//'container_class' 	=> 'menusuperior',
							'menu_class' 		=> 'nav-menu',
							'echo'				=> false,
							'before'			=> '',
							'after'				=> '',
							'link_before'		=> '',
							'link_after'		=> '',
							'sort_column' 		=> 'menu_order'
						));

						//-- 
						$menu = str_replace("\n", "\0", $menu);
						$menu = str_replace("\r", "\0", $menu);
						$menu = str_replace("\t", "\0", $menu);
						$menu = str_replace("\"", "'", $menu);
						//$menu = str_replace("<li id='nav-disclaimer'><a href='http://chevrolet.com.sv/disclaimer/'>Disclaimer</a></li>", "", $menu);
						//$menu = str_replace("<li id='nav-disclaimer' class='activo'><a href='http://chevrolet.com.sv/disclaimer/'>Disclaimer</a></li>", "", $menu);
						echo $menu;
					?>
				</nav>
			</div>
			<div class="inf">
				<nav id="site-navigation" class="site-navigation" role="navigation">
					<?php
						//-- 
						$menu = '';
						$menu =
						wp_nav_menu(array(
							'theme_location' 	=> 'secondary',
							'container' 		=> 'ul',
							//'container_id' 		=> 'menusuperior',
							//'container_class' 	=> 'menusuperior',
							'menu_class' 		=> 'nav-menu',
							'echo'				=> false,
							'before'			=> '',
							'after'				=> '',
							'link_before'		=> '',
							'link_after'		=> '',
							'sort_column' 		=> 'menu_order'
						));

						$menu = str_replace("\n", "\0", $menu);
						$menu = str_replace("\r", "\0", $menu);
						$menu = str_replace("\t", "\0", $menu);
						$menu = str_replace("\"", "'", $menu);
						//$menu = str_replace("<li id='nav-disclaimer'><a href='http://chevrolet.com.sv/disclaimer/'>Disclaimer</a></li>", "", $menu);
						//$menu = str_replace("<li id='nav-disclaimer' class='activo'><a href='http://chevrolet.com.sv/disclaimer/'>Disclaimer</a></li>", "", $menu);
						echo $menu;
					?>
				</nav>
			</div>
		</div>
	</header>

	<?php 
		if(is_front_page() == false):
	?>
		<div id="site-titular" class="site-titular" style="background-image: url('<?php header_image(); ?>')">
			<?php if ( get_header_image() ) : ?>
				<h1 class="titulo">
					<?php 
					if (is_page()):
						if (!empty($post->post_parent)):
							// echo $extradata->post_title;
							// $extradata = $wpdb->get_row("select post_title from wp_posts where ID = " . $post->post_parent);
							echo get_the_title($post->post_parent);
						else:
							// echo $post->post_title;
							echo get_the_title();
						endif;
					else:
						if( is_search() ):
							echo 'Results for:' . get_search_query();
						else:
							if(is_single()):
								$categories = get_the_category($post->ID);
								if($categories):
									foreach($categories as $category):
										// $category->term_id ;
										// $category->name;
										// $category->cat_name;
										if( $category->slug == "blog" ):
											echo "Our Blog";
										endif;
										if( $category->slug == "resources" ):
											echo "Our Resources";
										endif;

										break;
									endforeach;
									//var_dump($category);
								endif;
							else:
								echo get_the_title();								
							endif;
						endif;
						// echo $post->post_title;
					endif;
					?>
				</h1>
				<span class="texto"><?php echo get_field('description'); ?></span>
				<!-- <img src="" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt=""> -->
			<?php endif; ?>
		</div>
	<?php
		endif;
	?>