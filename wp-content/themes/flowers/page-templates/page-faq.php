<?php
/**
 * Template Name: Page FAQ
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
<div id="site-main" class="site-main page-two-column <?php echo $pag_tpl; ?>">

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

	<div id="secondary">
		<div class="notice">
			<div class="legend">
				Have a question of your own? Post it on our interactive forum!
			</div>
			<div class="actions">
				<a class="btn btn-primary btn-sensory btn-linear" href="<?php echo get_bloginfo('wpurl'); ?>/forum/interactive-forum/">Visit Interactive Forum</a>
			</div>
		</div>
	</div>

</div>


<script type="text/javascript">
	(function ($){
		//$("#demo").backstretch("http://dl.dropbox.com/u/515046/www/garfield-interior.jpg");
		//$('.notice').waypoint('sticky', { stuckClass: 'noticeFix' });
		//$('.notice').waypoint('sticky', { stuckClass: 'noticeFix' });
		$('.notice').waypoint('sticky', {
			wrapper: '<div class="sticky-wrapper" />',
			stuckClass: 'noticeFix'
		});
		// $('.my-sticky-element').waypoint('sticky');
	})(jQuery);
</script>

<?php
get_footer();
?>