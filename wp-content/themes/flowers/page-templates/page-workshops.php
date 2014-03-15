<?php
/**
 * Template Name: Page Workshops
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
	//--
	$promotional_header		= 	get_field('promotional_header', $post->ID);
	$promotional_body 		= 	get_field('promotional_body', $post->ID);
	$promotional_facebook	= 	get_field('promotional_facebook', $post->ID);
?>

<!-- Modal -->
<div class="modal fade modal_rsvp" id="modal-rsvp" tabindex="-1" role="dialog" aria-labelledby="modal_rsvp-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<div class="modal-title" id="modal_<?php echo ($slug); ?>-label"><?php echo ($promotional_header); ?></div>
			</div>
			<div class="modal-body scroll-pane">
				<div class="description"><?php echo ($promotional_body); ?></div>
			</div>
			<div class="modal-footer">
				<div class="pie">
					<div class="etiqueta">
						<a target="_blank" href="<?php echo ($promotional_facebook); ?>">Visit our Fan Page</a>
					</div><div class="facebook_boton">
						<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo ($promotional_facebook); ?>&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=80&amp;appId=199144080285323" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>
					</div>
				</div>
<!-- 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
-->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
	//-- Parameters
	$pag_ppp			=	6;
	//$pag_act 			= 	empty(get_query_var('page')) ? 1 : get_query_var('page');
	$pag_act 			= 	1;

	//-- Pagination
	$pag_ran			=	4;
	$pag_base			=	get_permalink(0).'';
	//$pag_parent			=	get_the_ID();
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
								, 'category_name'	=> 'workshop' 
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
			//-- Desactivado
			break;

			//-- Articulo
			$item 			= $dat[$con];

			//-- 
			setup_postdata($item);

			//-- Data
			$post_id 				= 	$item->ID;
			$titulo 				= 	$item->post_title;
			$slug 					= 	$item->post_name;
			//--
			$promotional_header		= 	get_field('promotional_header', $item->ID);
			$promotional_body 		= 	get_field('promotional_body', $item->ID);
			$promotional_facebook	= 	get_field('promotional_facebook', $item->ID);
	?>
		<!-- Modal -->
		<div class="modal fade modal_rsvp" id="modal-<?php echo ($slug); ?>" tabindex="-1" role="dialog" aria-labelledby="modal_<?php echo ($slug); ?>-label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<div class="modal-title" id="modal_<?php echo ($slug); ?>-label"><?php echo ($promotional_header); ?></div>
					</div>
					<div class="modal-body scroll-pane">
						<div class="description"><?php echo ($promotional_body); ?></div>
					</div>
					<div class="modal-footer">
						<div class="pie">
							<div class="etiqueta">
								<a target="_blank" href="<?php echo ($promotional_facebook); ?>">Visit our Fan Page</a>
							</div><div class="facebook_boton">
								<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo ($promotional_facebook); ?>&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=80&amp;appId=199144080285323" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>
							</div>
						</div>
		<!-- 
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
		-->
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	<?php
		endfor;
	?>

<?php
	endif;
?>


<div id="site-main" class="site-main page-one-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<?php
					//-- Recorrido
					if($dat_tot > 0):
				?>

					<div class="workshops">

						<div class="cab">
							<div class="back"><hr/></div>
							<div class="etiqueta">Workshops by POTS</div>
						</div>

						<div class="container">

							<div class="indicadores">
								<ol>
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
									?><li><a href="#workshop-<?php echo $slug; ?>"><span><?php echo $titulo; ?></span></a></li><?php
										endfor;
									?>
								</ol>
							</div>

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
									$slug 			= 	$item->post_name;
									//$texto 			= 	empty($item->post_excerpt)==false ? $item->post_excerpt : get_the_excerpt();
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
									$place 			= 	get_field('place', $item->ID);
									$date 			= 	get_field('date', $item->ID);
									$price 			= 	get_field('price', $item->ID);

									$pag_base		= get_permalink($item->ID).'';
									$button_have	= get_field('button_have', $item->ID);
									$button_link	= get_field('button_link', $item->ID);
									$button_text	= get_field('button_text', $item->ID);

									//-- Extract Y,M,D
									$y = substr($date, 0, 4);
									$m = substr($date, 4, 2);
									$d = substr($date, 6, 2);
									 
									//-- Create UNIX
									$time = strtotime("{$d}-{$m}-{$y}");
									 
									//-- Format date (23/11/1988)
									//echo date('d/m/Y', $time);
									 
									//-- Format date (November 11th 1988)
									//echo date('F n Y', $time);

									//-- Imagen
									if($image):
										// var_dump($image_slider['id']);
										// $image_id 		= get_post_thumbnail_id($image_slider['id']);
										$image_file 	= wp_get_attachment_url($image['id']);
										$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=200&h=200&zc=1';
									else:
										$image_fix 		= 'http://placehold.it/200x200/000000/FFFFFF';
									endif;
							?>

								<div class="row item" id="workshop-<?php echo $slug; ?>">
									<div class="col-md-3">
										<!-- <a href="#" class="thumbnail" data-toggle="modal" data-target="#modal-<?php echo ($slug); ?>"> -->
										<div class="thumbnail">
											<div class="img">
												<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
											</div>
										</div>
									</div>
									<div class="col-md-9">
										<!-- <a href="#" data-toggle="modal" data-target="#modal-<?php echo ($slug); ?>" class="item_title"><?php echo $titulo; ?></a> -->
										<div class="item_title"><?php echo $titulo; ?></div>
										<div class="item_text"><?php echo ($texto); ?></div>
										<div class="item_data">
											<div class="dato">
												<div class="etiqueta">Place: </div><div class="informacion"><?php echo ($place); ?></div>
											</div>
											<div class="dato">
												<div class="etiqueta">Date: </div><div class="informacion"><?php echo date('F n, Y', $time); ?></div>
											</div>
											<div class="dato">
												<div class="etiqueta">Price: </div><div class="informacion">$<?php echo ($price); ?></div>
											</div>
										</div>
										<div class="botones">
											<!-- <a href="#" class="btn btn-block btn-rsvp btn-morado" data-toggle="modal" data-target="#modal-<?php echo ($slug); ?>">RSVP Online</a> -->
<!-- 
											<div class="btn btn-block btn-rsvp btn-morado">RSVP Online</div>
-->

											<?php 
												if($button_have == 'Yes'):
											?>
												<a href="<?php echo $button_link; ?>" target="_self" class="btn btn-block btn-rsvp btn-morado"><?php echo $button_text; ?></a>
											<?php
												endif;
											?>
											<?php 
												if($have_file == 'Yes'):
											?>
												<a href="<?php echo $enlace_file['url']; ?>" target="_blank" class="btn btn-block btn-download btn-blanco">Download Brochure</a>
											<?php
												endif;
											?>
										</div>
									</div>
								</div>

							<?php
								endfor;
							?>

						</div>

					</div>

				<?php
					endif;
				?>

				<?php 
					wp_reset_query();  // Restore global post data stomped by the_post(). 
				?>

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
					echo do_shortcode("[subscripcion]");
				?>

			</div>
		</div>

	</div>

</div>


<script>
	$( document ).ready(function() {
		$('.modal_rsvp').modal({
			keyboard: false
		}).modal('show');
	});
</script>

<?php
get_footer();
