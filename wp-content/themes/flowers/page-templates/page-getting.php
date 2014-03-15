<?php
/**
 * Template Name: Page Getting
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
	$have_file		= 	get_field('have_file', $post->ID);
	$enlace_file	= 	get_field('file', $post->ID);
?>

<div id="site-main" class="site-main page-one-column <?php echo $pag_tpl; ?>">

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<div class="cab">
					<div class="back"><hr/></div>
					<div class="etiqueta">Getting started with POTS</div>
				</div>

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

				<div class="botones">
					<?php 
						if($have_file == 'Yes'):
					?>
						<a href="<?php echo $enlace_file['url']; ?>" target="_blank" class="btn btn-block btn-download btn-morado">Download our Welcome Packet</a>
					<?php
						endif;
					?>
				</div>

				<div class="linea"><hr/></div>

				<?php
					echo do_shortcode("[subscripcion]");
				?>

			</div>
		</div>

	</div>

</div>

<?php
get_footer();
