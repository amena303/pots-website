<?php
/**
 * Template Name: Page Services
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
	$button_have		= get_field('button_have', $post->ID);
	$button_link		= get_field('button_link', $post->ID);
	$button_header		= get_field('button_header', $post->ID);
	$button_text		= get_field('button_text', $post->ID);
?>

<div id="site-main" class="site-main page-one-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<?php
					//-- Parameters
					$pag_ppp			=	8;
					//$pag_act 			= 	empty(get_query_var('page')) ? 1 : get_query_var('page');
					$pag_act 			= 	1;

					//-- Pagination
					$pag_ran			=	4;
					$pag_base			=	get_permalink(0).'';
					//$pag_parent			=	get_the_ID();
					$pag_parent			=	get_ID_by_slug( 'services' );

					//-- Data
					$qry 				= 	null;
					$dat 				= 	array();
					$arg 				=  	
											array(
												  'post_type'		=> 'page'
												, 'post_status'		=> 'publish' 
												, 'paged'			=> 	$pag_act 
												, 'posts_per_page'	=> 	$pag_ppp 
												, 'post_parent' 	=>  $pag_parent 
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

					<div class="services">

						<div class="cab">
							<div class="back"><hr/></div>
							<div class="etiqueta">Scroll to discover our services</div>
						</div>

						<div class="container">
							<div class="col-md-12">

								<div id="services_slider" class="carousel slide services_slider" data-interval="false">
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
															<!-- <a href="#<?php echo $enlace; ?>" class="thumbnail"> -->
															<a href="<?php echo $enlace; ?>" class="thumbnail">
																<div class="img">
																	<!-- <img src="http://placehold.it/200x200" alt="Image" class="img-responsive"/> -->
																	<div class="text"><span><?php echo $titulo; ?></span></div>
																</div>
															</a>
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

									<?php
										if($dat_tot > 4):
									?>
										<a class="left carousel-control" href="#services_slider" data-slide="prev">
											<span class="genericon genericon-leftarrow"></span>
										</a>
										<a class="right carousel-control" href="#services_slider" data-slide="next">
											<span class="genericon genericon-rightarrow"></span>
										</a>
									<?php
										endif;
									?>

								</div>
							</div>
						</div>

					</div>

				<?php
					endif;
				?>

				<?php
					//-- Parameters
					$pag_ppp			=	7;
					//$pag_act 			= 	empty(get_query_var('page')) ? 1 : get_query_var('page');
					$pag_act 			= 	1;

					//-- Pagination
					$pag_ran			=	4;
					$pag_base			=	get_permalink(0).'';
					//$pag_parent			=	get_the_ID();
					$pag_parent			=	get_ID_by_slug( 'offices' );


					//-- Data
					$qry 				= 	null;
					$dat 				= 	array();
					$arg 				=  	
											array(
												  'post_type'		=> 'page'
												, 'post_status'		=> 'publish' 
												, 'paged'			=> 	$pag_act 
												, 'posts_per_page'	=> 	$pag_ppp 
												, 'post_parent' 	=>  $pag_parent 
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
					<div class="offices">
						<div class="cab">
							<div class="back"><hr/></div>
							<div class="etiqueta">Explore our offices</div>
						</div>
						<div id="offices_slider" class="carousel slide offices_slider" data-ride="carousel">

							<!-- Indicators -->
							<ol class="carousel-indicators">
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
								?>
									<li data-target="#offices_slider" data-slide-to="<?php echo ($con); ?>" class="<?php echo ($con==0 ? 'active' : ''); ?>">
										<span><?php echo $titulo; ?></span>
									</li>
								<?php
									endfor;
								?>
							</ol>

							<!-- Wrapper for slides -->
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
										$slug 			= 	$item->post_name;
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
										$type			= 	get_field('type', $item->ID);


										//-- Imagen
										switch ($type):
											case 'Image':
												$image_slider 	= get_field('image_office', $item->ID);
												if($image_slider):
													$image_file = wp_get_attachment_url($image_slider['id']);
													$image_fix 	= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=1024&h=400&zc=1';
												else:
													$image_fix 	= 'http://placehold.it/1024x400/000000/FFFFFF';
												endif;
								?>

												<div class="item <?php echo ($con==0 ? 'active' : '') ?>">
													<div class="carousel-image">
														<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
													</div>
													<div class="carousel-title"><?php echo $titulo; ?></div>
													<div class="carousel-caption"><?php echo $texto; ?></div>
												</div>

								<?php
											break;
											case 'Video':
												$video_slider 	= get_field('video_office', $item->ID);
												//parse_str( parse_url( $url, PHP_URL_QUERY ), $video_id );
												$video_id 		= get_youtube_id_from_url($video_slider);
												// var_dump($video_slider);
												// var_dump($video_id);
								?>

												<div class="item <?php echo ($con==0 ? 'active' : '') ?>">
													<div class="carousel-image">
														<div id="dom_<?php echo $slug; ?>">You need Flash player 8+ and JavaScript enabled to view this video.</div>
														<script type="text/javascript">
															var params = { allowScriptAccess: "always" };
															var atts = { id: "ytb_<?php echo $slug; ?>" };
															swfobject.embedSWF("http://www.youtube.com/v/<?php echo $video_id; ?>?enablejsapi=1&playerapiid=ytplayer&version=3&controls=0&showinfo=0", "dom_<?php echo $slug; ?>", "1024", "400", "8", "<?php echo get_bloginfo('template_directory') . '/lib/js/expressInstall.swf'; ?>", null, params, atts);
														</script>
													</div>
													<div class="carousel-title"><?php echo $titulo; ?></div>
													<div class="carousel-caption"><?php echo $texto; ?></div>
												</div>

								<?php
											break;
											default:
											break;
										endswitch;
								?>

								<?php
									endfor;
								?>

							</div>


							<?php
								if($dat_tot > 1):
							?>
								<!-- Controls -->
								<a class="left carousel-control" href="#offices_slider" data-slide="prev">
									<!-- <span class="glyphicon glyphicon-chevron-left"></span> -->
									<span class="genericon genericon-leftarrow glyphicon-chevron-left"></span>
								</a>
								<a class="right carousel-control" href="#offices_slider" data-slide="next">
									<!-- <span class="glyphicon glyphicon-chevron-right"></span> -->
									<span class="genericon genericon-rightarrow glyphicon-chevron-right"></span>
								</a>
							<?php
								endif;
							?>
						</div>

					</div>

				<?php
					endif;
				?>

				<?php
					//-- Parameters
					$pag_ppp			=	4;
					//$pag_act 			= 	empty(get_query_var('page')) ? 1 : get_query_var('page');
					$pag_act 			= 	1;

					//-- Pagination
					$pag_ran			=	4;
					$pag_base			=	get_permalink(0).'';
					//$pag_parent			=	get_the_ID();
					$pag_parent			=	get_ID_by_slug( 'testimonials' );

					//-- Data
					$qry 				= 	null;
					$dat 				= 	array();
					$arg 				=  	
											array(
												  'post_type'		=> 'page'
												, 'post_status'		=> 'publish' 
												, 'paged'			=> 	$pag_act 
												, 'posts_per_page'	=> 	$pag_ppp 
												, 'post_parent' 	=>  $pag_parent 
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

					<div class="testimonials">
						<div class="cab">
							<div class="back"><hr/></div>
							<div class="etiqueta">Testimonials</div>
						</div>
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
											$image 			= 	get_field('image', $item->ID);

											//-- Imagen
											if($image):
												// var_dump($image_slider['id']);
												// $image_id 		= get_post_thumbnail_id($image_slider['id']);
												$image_file 	= wp_get_attachment_url($image['id']);
												$image_fix 		= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=145&h=145&zc=1';
											else:
												$image_fix 		= 'http://placehold.it/145x145/000000/FFFFFF';
											endif;
									?>

										<div class="col-md-6 item">
											<div class="imagen">
												<a href="#" class="thumbnail">
													<div class="img">
														<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
													</div>
												</a>
											</div><div class="info">
												<div class="item_title" href="#"><?php echo $texto; ?></div>
												<div class="item_text"><?php echo $titulo; ?></div>
											</div>
										</div>

									<?php
										endfor;
									?>

								</div>
							</div>
						</div>
					</div>


					<div class="linea"><hr/></div>

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

				<div class="nota">
					<div class="cabecera">
						<?php echo $button_header; ?>	
					</div>
					<div class="botones">
						<?php 
							if($button_have == 'Yes'):
						?>
							<a href="<?php echo $button_link; ?>" target="_self" class="btn btn-block btn-download btn-morado"><?php echo $button_text; ?></a>
						<?php
							endif;
						?>
					</div>
				</div>

			</div>
		</div>

	</div>

</div>

<?php
get_footer();
?>