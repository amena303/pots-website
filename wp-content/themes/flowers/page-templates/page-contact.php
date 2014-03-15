<?php
/**
 * Template Name: Page Contact
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
								, 'category_name'	=> 'glossary' 
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

			</div>
		</div>

	</div>

</div>

<?php
	//get_sidebar();
	get_footer();
?>
