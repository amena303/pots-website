<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<?php
	//-- Tpl
	//$pag_tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	global $post;
?>


<div id="site-main" class="site-main page-two-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<?php
					//$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$s = get_query_var('s');
					//query_posts("s=$s&cat=-9,-14&paged=$page");


					//-- Parameters
					$pag_ppp			=	5;
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
												, 'category_name'	=> 'blog,news,resources' 
												, 'orderby'			=> 'date'  
												, 'order'			=> 'DESC' 
												, 's' 				=> $s
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
					//-- Recorrido
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
							$slug 			= 	$item->post_name;
							$enlace 		= 	get_permalink($post_id);
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

						<article id="post-<?php $post_id; ?>" <?php post_class(); ?>>
							<?php //twentyfourteen_post_thumbnail(); ?>

							<header class="entry-header">
								<h1 class="entry-title">
									<a href="<?php echo $enlace; ?>" rel="bookmark"><?php echo $titulo; ?></a>
								</h1>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
						</article>

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

					<div class="navegacion">
						<?php
							// Previous/next post navigation.
							twentyfourteen_paging_nav();
						?>
					</div>

				<?php
					endif;
				?>

			</div>
		</div>

	</div>


	<div id="secondary">
		<?php
			get_sidebar();
		?>
	</div><!-- #secondary -->

</div>

<?php
	get_footer();
?>