<?php
/**
 * Template Name: Page Home
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
	//set_time_limit(0);
	//-- 300 seconds = 5 minutes
	//ini_set('max_execution_time', 600);

	// global $post;

	// //-- Assign your post details to $post (& not any other variable name!!!!)
	// $post = $post_object;
?>

<div id="site-main" class="site-main page-one-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<?php
					//-- Parameters
					$pag_ppp			=	6;
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
												  'post_type'		=> 'post'
												, 'post_status'		=> 'publish' 
												, 'paged'			=> $pag_act 
												, 'posts_per_page'	=> $pag_ppp 
												, 'post_parent' 	=> 0 
												, 'category_name'	=> 'news' 
												, 'orderby'			=> 'date'  
												, 'order'			=> 'DESC' 
												, 'meta_key' 		=> 'type' 
												, 'meta_value' 		=> 'Slider' 
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
					<div class="featured">
						<div id="featured_slider" class="carousel slide featured_slider" data-ride="carousel">
							<div id="slider" class="carousel slide slider" data-ride="carousel">

								<!-- Indicators -->
								<ol class="carousel-indicators">
									<?php
										//-- Recorrido
										for($con=0; $con<$dat_tot; $con++):
									?>
										<li data-target="#slider" data-slide-to="<?php echo ($con); ?>" class="<?php echo ($con==0 ? 'active' : ''); ?>"></li>
									<?php
										endfor;
									?>
								</ol>

								<!-- Wrapper for slides -->
								<div class="carousel-inner">
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
											$have_file		= 	get_field('have_file', $item->ID);
											$enlace_file	= 	get_field('file', $item->ID);
											//-- Autor
											$usr_id 		= 	$item->post_author;
											$usr_name 		= 	get_the_author_meta('first_name', $usr_id);
											$usr_lastname 	= 	get_the_author_meta('last_name', $usr_id);
											$usr_email 		= 	get_the_author_meta('email', $usr_id);
											//$usr_img 		= 	get_usr_image($usr_email, '210');
											$obj 			= 	get_post_custom($item->ID);
											$image_slider 	= 	get_field('image_slider', $item->ID);
											//var_dump($image_slider['id']);

											$pag_base			= get_permalink($item->ID).'';
											$button_have		= get_field('button_have', $item->ID);
											$button_link		= get_field('button_link', $item->ID);
											$button_text		= get_field('button_text', $item->ID);

											//-- Imagen
											if($image_slider):
												// var_dump($image_slider['id']);
												// $image_id 		= get_post_thumbnail_id($image_slider['id']);
												$image_file 	= wp_get_attachment_url($image_slider['id']);
												$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=1024&h=400&zc=1';
											else:
												$image_fix 		= 'http://placehold.it/1024x400/000000/FFFFFF';
											endif;
									?>

										<div class="item <?php echo ($con==0 ? 'active' : '') ?>">
											<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
											<div class="carousel-title"><?php echo $titulo; ?></div>
											<div class="carousel-caption"><?php echo $texto; ?></div>
											<div class="actions">

												<?php 
													if($button_have == 'Yes'):
												?>
													<a class="btn btn-primary btn-sensory btn-morado" href="<?php echo $button_link; ?>">
														<?php echo $button_text; ?>
													</a> 
												<?php
													endif;
												?>

												<?php 
													if($have_file == 'Yes'):
												?>
													<a class="btn btn-primary btn-download btn-blanco" href="<?php echo $enlace_file['url']; ?>" target="_blank">
														Schedule your next appointment
													</a>
												<?php
													endif;
												?>
											</div>
										</div>

									<?php
										endfor;
									?>
								</div>

								<!-- Controls -->
								<a class="left carousel-control" href="#featured_slider" data-slide="prev">
									<!-- <span class="glyphicon glyphicon-chevron-left"></span> -->
									<span class="genericon genericon-leftarrow glyphicon-chevron-left"></span>
								</a>
								<a class="right carousel-control" href="#featured_slider" data-slide="next">
									<!-- <span class="glyphicon glyphicon-chevron-right"></span> -->
									<span class="genericon genericon-rightarrow glyphicon-chevron-right"></span>
								</a>

							</div>
						</div>
					</div>

				<?php
					endif;
				?>

				<?php 
					wp_reset_query();  // Restore global post data stomped by the_post(). 
				?>

				<?php
					//-- Parameters
					$pag_ppp			=	2;
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
												  'post_type'		=> 'post'
												, 'post_status'		=> 'publish' 
												, 'paged'			=> $pag_act 
												, 'posts_per_page'	=> $pag_ppp 
												, 'post_parent' 	=> 0 
												, 'category_name'	=> 'news' 
												, 'orderby'			=> 'date'  
												, 'order'			=> 'DESC' 
												, 'meta_key' 		=> 'type' 
												, 'meta_value' 		=> 'List' 
											);
				?>

				<?php
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

					<div class="news">
						<div class="cab">
							<div class="back"><hr/></div>
							<div class="etiqueta">POTS News</div>
						</div>
						<div class="items">
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
										$image_slider 	= 	get_field('image_slider', $item->ID);

										//-- Imagen
										if($image_slider):
											// var_dump($image_slider['id']);
											// $image_id 		= get_post_thumbnail_id($image_slider['id']);
											$image_file 	= wp_get_attachment_url($image_slider['id']);
											$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=200&h=200&zc=1';
										else:
											$image_fix 		= 'http://placehold.it/200x200/000000/FFFFFF';
										endif;
								?>

									<div class="row item">
										<div class="col-md-8 data">
											<div class="item_title"><?php echo $titulo; ?></div>
											<div class="item_text"><?php echo $texto; ?></div>
										</div>
										<div class="col-md-4 actions">
											<a href="<?php echo $enlace; ?>" class="btn btn-primary btn-block btn-sensory btn-morado">Read more...</a>
											<?php 
												if($have_file == 'Yes'):
											?>
												<a href="<?php echo $enlace_file['url']; ?>" target="_blank" class="btn btn-primary btn-block btn-download btn-blanco">Download Brochure</a>
											<?php
												endif;
											?>
										</div>
									</div>
									<div class="linea"><hr/></div>

								<?php
									endfor;
								?>

							</div>
						</div>
					</div>

				<?php
					endif;
				?>

				<?php 
					wp_reset_query();  // Restore global post data stomped by the_post(). 
				?>

				<?php
					//-- Parameters
					$pag_ppp			=	8;
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
												  'post_type'		=> 'post' 
												, 'post_status'		=> 'publish' 
												, 'paged'			=> $pag_act 
												, 'posts_per_page'	=> $pag_ppp 
												, 'category_name'	=> 'news' 
												, 'orderby'			=> 'date' 
												, 'order'			=> 'DESC' 
												, 'meta_key' 		=> 'type' 
												, 'meta_value' 		=> 'Carousel' 
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

					<div class="others">
						<div class="container">
							<div class="col-md-12">

								<div id="others_slider" class="carousel slide others_slider" data-interval="false">
									<!-- Carousel items -->
									<div class="carousel-inner">

										<?php
											//-- 
											$bnd 		= 	false;
											$bnd_inc 	= 	0;

											//var_dump($dat_tot);

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
												$image_slider 	= 	get_field('image_post', $item->ID);

												//-- Imagen
												if($image_slider):
													// var_dump($image_slider['id']);
													// $image_id 		= get_post_thumbnail_id($image_slider['id']);
													$image_file 	= wp_get_attachment_url($image_slider['id']);
													$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=200&h=200&zc=1';
												else:
													$image_fix 		= 'http://placehold.it/200x200/000000/FFFFFF';
												endif;
										?>

											<?php 
												if($bnd == false):
													$bnd 		= 	true;
													$bnd_inc	= 	0;
											?>
												<div class="item <?php echo ($con==0 ? 'active' : '') ?>">
													<div class="row">
											<?php
												endif;
											?>

														<div class="col-md-3 post">
															<a href="<?php echo $enlace; ?>" class="thumbnail">
																<div class="img">
																	<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
																</div>
															</a>
															<a href="<?php echo $enlace; ?>" class="item_title"><?php echo $titulo; ?></a>
															<div class="item_text"><?php echo $texto; ?></div>
														</div>

											<?php 
												//-- 
												$bnd_inc += 1;

												//-- 
												if($bnd_inc == 4):
													$bnd 		= 	false;
											?>
													</div><!-- row -->
												</div><!-- item -->
											<?php
												endif;
											?>

										<?php
											endfor;
										?>


										<?php 
											//var_dump($bnd);
											//-- 
											if($bnd == true):
										?>
												</div><!-- row extra -->
											</div><!-- item extra -->
										<?php
											endif;
										?>

									</div>
									<a class="left carousel-control" href="#others_slider" data-slide="prev">
										<span class="genericon genericon-leftarrow"></span>
									</a>
									<a class="right carousel-control" href="#others_slider" data-slide="next">
										<span class="genericon genericon-rightarrow"></span>
									</a>
								</div>


							</div>
						</div>
					</div>

				<?php
					endif;
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

</div><!-- #site-main -->

<?php
get_footer();
