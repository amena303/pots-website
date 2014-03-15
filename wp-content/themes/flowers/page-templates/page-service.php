<?php
/**
 * Template Name: Page Service
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

	<div class=" top_controls">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div onclick="goBack()" class="button_back">Back</div>
				</div>
				<div class="col-md-6">
					
				</div>
			</div>
		</div>
	</div>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">


			<?php
				//-- Respuesta
				$dat_tot 			= 	0;
				$pag_tot 			= 	0;

				//-- Llamada
				$dat 				= 	get_field('gallery', $post->ID);
				if($dat):
					$dat_tot 		= 	count($dat);
				endif;
			?>
			<?php
				if($dat_tot > 0 ):
			?>
				<div class="gallery">
					<div class="cab">
						<div class="back"><hr/></div>
						<div class="etiqueta"><?php echo $post->post_title; ?></div>
					</div>
					<div id="gallery_slider" class="carousel slide gallery_slider" data-ride="carousel">

						<!-- Indicators -->
						<ol class="carousel-indicators">
							<?php
								//-- Recorrido
								for($con=0; $con<$dat_tot; $con++):

									//-- Articulo
									$item 			= $dat[$con];

									//-- Data
									$post_id 		= 	$item['id'];
									$titulo 		= 	$item['title'];
							?>
								<li data-target="#gallery_slider" data-slide-to="<?php echo ($con); ?>" class="<?php echo ($con==0 ? 'active' : ''); ?>"></li>
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

									//-- Data
									$post_id 		= $item['id'];
									$titulo 		= $item['title'];
									$alterno 		= $item['alt'];
									$subtitulo 		= $item['caption'];
									$descripcion 	= $item['description'];
									$file 			= $item['url'];
									if($file):
										// $image_file = wp_get_attachment_url($file);
										$image_file = $file;
										$image_fix 	= get_bloginfo('template_directory').'/inc/tmb/?src='.$image_file.'&w=1024&h=450&zc=1';
									else:
										$image_fix 	= 'http://placehold.it/1024x450/000000/FFFFFF';
									endif;
							?>

								<div class="item <?php echo ($con==0 ? 'active' : '') ?>">
									<div class="carousel-image">
										<img class="img-responsive" src="<?php echo $image_fix; ?>" alt ="..." />
									</div>
									<div class="carousel-title"><?php echo $titulo; ?></div>
									<div class="carousel-caption"><span><?php echo $subtitulo; ?></span></div>
								</div>

							<?php
								endfor;
							?>

						</div>


						<?php
							if($dat_tot > 1):
						?>
							<!-- Controls -->
							<a class="left carousel-control" href="#gallery_slider" data-slide="prev">
								<!-- <span class="glyphicon glyphicon-chevron-left"></span> -->
								<span class="genericon genericon-leftarrow glyphicon-chevron-left"></span>
							</a>
							<a class="right carousel-control" href="#gallery_slider" data-slide="next">
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


			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-content">
					<?php
						// Start the Loop.
						while ( have_posts() ) : 
							the_post();

							//-- 
							the_content();

							// //-- If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ):
							 	//comments_template();
							endif;
						endwhile;
					?>
				</div>

				<?php
					//-- Previous/next post navigation.
					//post_nav();
				?>
			</article>

			<hr/>

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

		</div><!-- #content -->
	</div><!-- #primary -->

</div>

<?php
get_footer();
?>