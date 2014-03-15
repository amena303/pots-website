<?php
/**
 * Template Name: Page About
 *
 * @package pliskin
 * @subpackage Flowers
 * @since Flowers 1.0
 */

get_header(); ?>

<?php
	//-- Tpl
	//$pag_tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	$pag_tpl = get_page_template_slug( $post->ID );
	$pag_tpl = str_replace(array('page-templates/', '.php'), array('',''), $pag_tpl);
?>

<?php
	//-- Parameters
	$pag_ppp			=	-1;
	//$pag_act 			= 	empty(get_query_var('page')) ? 1 : get_query_var('page');
	$pag_act 			= 	1;

	//-- Pagination
	$pag_ran			=	4;
	$pag_base			=	get_permalink(0).'';
	$pag_parent			=	get_the_ID();

	//-- Data
	$qry 				= 	null;
	$dat 				= 	array();
	$arg 				=  	
							array(
								  'post_type'		=> 'page'
								, 'post_status'		=> 'publish' 
								, 'paged'			=> 	$pag_act 
								, 'posts_per_page'	=> 	$pag_ppp 
								, 'post_parent' 	=>  get_the_ID() 
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

<?php
	if($dat_tot > 0):
?>
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
			$texto 			= 	$item->post_content;
			//$texto 			= 	empty($item->post_excerpt)==false ? $item->post_excerpt : get_the_excerpt();
			$enlace 		= 	get_permalink($item->ID);
			$enlace_file	= 	get_field('file', $item->ID);
			//-- Autor
			$usr_id 		= 	$item->post_author;
			$usr_name 		= 	get_the_author_meta('first_name', $usr_id);
			$usr_lastname 	= 	get_the_author_meta('last_name', $usr_id);
			$usr_email 		= 	get_the_author_meta('email', $usr_id);
			//$usr_img 		= 	get_usr_image($usr_email, '210');
			$obj 			= 	get_post_custom($item->ID);
			$image_slider 	= 	get_field('image', $item->ID);
			$description 	= 	get_field('description', $item->ID);
			$email 	= 	get_field('email', $item->ID);

			//-- Imagen
			if($image_slider):
				// var_dump($image_slider['id']);
				// $image_id 		= get_post_thumbnail_id($image_slider['id']);
				$image_file 	= wp_get_attachment_url($image_slider['id']);
				$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=150&h=150&zc=1';
			else:
				$image_fix 		= 'http://placehold.it/150x150/000000/FFFFFF';
			endif;
	?>

		<!-- Modal -->
		<div class="modal fade modal_team" id="modal_<?php echo ($con); ?>" tabindex="-1" role="dialog" aria-labelledby="modal_<?php echo ($con); ?>-label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<div class="modal-title" id="modal_<?php echo ($con); ?>-label">
							<div class="avatar"><img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." /></div>
							<div class="info">
								<h4 class="name"><?php echo $titulo; ?></h4>
								<h4 class="position"><?php echo $description; ?></h4>
								<span class="email"><?php echo $email; ?></span>
							</div>
						</div>
					</div>
					<div class="modal-body scroll-pane">
						<div class="description"><?php echo $texto; ?></div>
					</div>
					<!-- 
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
					-->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	<?php
		endfor;
	?>

<?php
	endif;
?>

<?php 
	wp_reset_query();  // Restore global post data stomped by the_post(). 
?>

<div id="site-main" class="site-main page-one-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

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

				<div class="linea"><hr/></div>

				<?php
					if($dat_tot > 0):
				?>
					<h2>Our Team</h2>

					<div class="team">
						<div class="container">
							<div class="col-md-12">
								<div class="row">

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
											//$texto 			= 	$item->post_content;
											$texto 			= 	empty($item->post_excerpt)==false ? $item->post_excerpt : get_the_excerpt();
											$enlace 		= 	get_permalink($item->ID);
											$enlace_file	= 	get_field('file', $item->ID);
											//-- Autor
											$usr_id 		= 	$item->post_author;
											$usr_name 		= 	get_the_author_meta('first_name', $usr_id);
											$usr_lastname 	= 	get_the_author_meta('last_name', $usr_id);
											$usr_email 		= 	get_the_author_meta('email', $usr_id);
											//$usr_img 		= 	get_usr_image($usr_email, '210');
											$obj 			= 	get_post_custom($item->ID);
											$image_slider 	= 	get_field('image', $item->ID);
											$description 	= 	get_field('description', $item->ID);

											//-- Imagen
											if($image_slider):
												// var_dump($image_slider['id']);
												// $image_id 		= get_post_thumbnail_id($image_slider['id']);
												$image_file 	= wp_get_attachment_url($image_slider['id']);
												$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=200&h=200&zc=1';
											else:
												$image_fix 		= 'http://placehold.it/200x200/000000/FFFFFF';
											endif;
									?><div class="col-md-3 item">
											<a href="#<?php echo $enlace; ?>" data-toggle="modal" data-target="#modal_<?php echo ($con); ?>" class="thumbnail">
												<div class="img">
													<img class="img-responsive grayscale" src="<?php echo $image_fix.'&f=2'; ?>" alt ="..." />
													<img class="img-responsive color" src="<?php echo $image_fix; ?>" alt ="..." />
												</div>
											</a>
											<a class="item_title" href="#"><?php echo $titulo; ?></a>
											<div class="item_text"><?php echo $description; ?></div>
										</div><?php
										endfor;
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


			</div>
		</div>

	</div>

</div>

<?php
get_footer();
