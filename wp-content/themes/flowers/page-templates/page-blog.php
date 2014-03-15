<?php
/**
 * Template Name: Page Blog
 *
 * @package pliskin
 * @subpackage Flowers
 * @since Flowers 1.0
 */

get_header(); ?>

<?php
	//-- Tpl
	//$pag_tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	global $post;
	$pag_tpl = get_page_template_slug( $post->ID );
	$pag_tpl = str_replace(array('page-templates/', '.php'), array('',''), $pag_tpl);
	$pag_title			= get_the_title();
	$pag_content		= $post->post_content;
?>

<?php
	//-- Parameters
	$pag_ppp			=	4;
	$pag_act 			= 	is_null(get_query_var('page')) ? 1 : get_query_var('page');
	//$pag_act 			= 	1;

	//-- Pagination
	$pag_ran			=	4;
	$pag_base			=	get_permalink(0).'';
	$pag_parent			=	get_the_ID();
	//$pag_parent			=	get_ID_by_slug( 'workshops' );

	//-- Data
	$qry 				= 	null;
	$dat 				= 	array();
	$arg 				=  	
							array(
								  'post_type'		=> 'post'
								, 'post_status'		=> 'publish' 
								, 'paged'			=> 	$pag_act 
								, 'posts_per_page'	=> 	$pag_ppp 
								, 'category_name'	=> 'blog' 
								, 'orderby'			=> 'date'  
								, 'order'			=> 'DESC' 
							);
	//-- Respuesta
	$dat_tot 			= 	0;
	$pag_tot 			= 	0;

	//-- Llamada
	$qry 				= 	new WP_Query($arg);
	if($qry->have_posts()):
		$dat 			= 	$qry->get_posts();
		$dat_tot 		= 	count($dat);
		$pag_tot 		= 	$qry->max_num_pages;
	endif;
?>

<div id="site-main" class="site-main page-two-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<?php
					//-- Recorrido
					if($dat_tot > 0):
				?>

					<div class="posts">

						<div class="container">

							<?php
								//-- Recorrido
								for($con=0; $con<$dat_tot; $con++):

									//-- Articulo
									$item 			= $dat[$con];

									//-- 
									setup_postdata($item);

									//-- Data
									$post_id 		= 	$item->ID;
									$titulo 		= 	$item->post_title;
									$slug 			= 	$item->post_name;
									//$texto 			= 	$item->post_content;
									$texto 			= 	empty($item->post_excerpt)==false ? $item->post_excerpt : get_the_excerpt();
									$enlace 		= 	get_permalink($item->ID);
									$have_file		= 	get_field('have_file', $item->ID);
									$enlace_file	= 	get_field('file', $item->ID);
									//-- Autor
									$usr_id 		= 	$item->post_author;
									$usr_name 		= 	get_the_author_meta('first_name', $usr_id);
									$usr_lastname 	= 	get_the_author_meta('last_name', $usr_id);
									$usr_email 		= 	get_the_author_meta('email', $usr_id);
									//$usr_img 		= 	get_usr_image($usr_email, '210');
									$obj 			= 	get_post_custom($item->ID);
									$image 			= 	get_field('image', $item->ID);
									$fecha_1		= 	get_the_time('M', $item->ID);
									$fecha_2		= 	get_the_time('d', $item->ID);

									//-- Imagen
									if($image):
										// var_dump($image_slider['id']);
										// $image_id 		= get_post_thumbnail_id($image_slider['id']);
										$image_file 	= wp_get_attachment_url($image['id']);
										$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=650&h=400&zc=1';
									else:
										$image_fix 		= 'http://placehold.it/650x400/000000/FFFFFF';
									endif;
							?>

								<div class="row item" id="<?php echo ($slug); ?>">
									<div class="col-md-2">
										<div class="fecha">
											<?php echo $fecha_1; ?><br/>
											<?php echo $fecha_2; ?>
										</div>
									</div>
									<div class="col-md-10">
										<a class="thumbnail" href="<?php echo ($enlace); ?>">
											<div class="img">
												<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
											</div>
										</a>
										<a class="item_title" href="<?php echo ($enlace); ?>"><?php echo $titulo; ?></a>
										<div class="item_meta"><?php echo $usr_name. ' ' .$usr_lastname; ?></div>
										<div class="item_text"><?php echo $texto; ?></div>
										<div class="botones">
											<a href="<?php echo $enlace; ?>" class="btn btn-block btn-readmore btn-morado">Read More...</a>
										</div>
									</div>
								</div>

								<?php
									if($con < $dat_tot-1):
								?>
									<div class="linea"><hr/></div>
								<?php
									endif;
								?>

							<?php
								endfor;
							?>

						</div>

					</div>


				<?php
					endif;
				?>

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
										$paginacion	=  paginacion($pag_act, $pag_tot, $pag_ran, $pag_parent, $pag_base);
										echo $paginacion;
									?>
								</div>
							</div>
						</div>
					</div>
				<?php
					endif;
				?>

				<?php 
					wp_reset_query();  // Restore global post data stomped by the_post(). 
				?>
<!-- 
				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();
				?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="entry-content">
							<?php the_content(); ?>
						</div>

					</article>

				<?php
						// // If comments are open or we have at least one comment, load up the comment template.
						// if ( comments_open() || get_comments_number() ) {
						// 	//comments_template();
						// }
					endwhile;
				?>
 -->
			</div>
		</div>

	</div>


	<div id="secondary">
		<aside class="widget widget_text about">
			<h1 class="widget-title">About the <?php echo $pag_title; ?></h1>
			<div class="textwidget"><?php echo $pag_content; ?></div>
		</aside>
		<?php
			get_sidebar();
		?>
	</div><!-- #secondary -->

</div>

<?php
	get_footer();
?>