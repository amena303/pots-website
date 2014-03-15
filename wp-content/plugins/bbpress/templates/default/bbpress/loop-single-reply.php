<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="respuesta-<?php bbp_reply_id(); ?>" class="bbp-respuesta">
<!-- 
	<div id="post-<?php bbp_reply_id(); ?>" class="bbp-reply-header">
		<div class="bbp-meta">
			<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>
			<?php if ( bbp_is_single_user_replies() ) : ?>
				<span class="bbp-header">
					<?php _e( 'in reply to: ', 'bbpress' ); ?>
					<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
				</span>
			<?php endif; ?>
			<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>
			<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>
			<?php bbp_reply_admin_links(); ?>
			<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
		</div>
	</div> 
-->

	<div <?php bbp_reply_class(); ?>>

		<div class="bbp-respuesta_autor">
			<div class="imagen">
				<?php 
					//printf( __( 'Started by: %1$s', 'bbpress' ), bbp_get_topic_author_link( array( 'size' => '90' ) ) ); 
					// echo bbp_get_topic_author_link( array( 'type' => 'avatar', 'size' => '90' ) ) ; 
					bbp_reply_author_link( array( 'sep' => '<br />', 'type' => 'avatar', 'size' => '90' ) );
				?>
			</div>
		</div>
		<div class="bbp-respuesta_contenido">

			<?php if ( bbp_is_user_keymaster() ) : ?>
<!-- 
				<div class="autor_titulo">
					<?php bbp_topic_title( bbp_get_reply_topic_id() ); ?>
				</div>
-->
			<?php endif; ?>

			<div class="autor_nombre">
				@<?php bbp_reply_author_link( array( 'show_role' => true, 'type' => 'name'  ) ); ?>
			</div>
			<div class="fecha">
				<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>
				<?php bbp_topic_freshness_link(); ?>
				<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>
			</div>
			<div class="texto">
				<?php do_action( 'bbp_theme_before_reply_content' ); ?>
				<?php bbp_reply_content(); ?>
				<?php do_action( 'bbp_theme_after_reply_content' ); ?>
			</div>
		</div>

<!-- 
		<div class="bbp-reply-author" style="">

			<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

			<?php bbp_reply_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

			<?php if ( bbp_is_user_keymaster() ) : ?>

				<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

				<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

				<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

			<?php endif; ?>

			<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

		</div>

		<div class="bbp-reply-content" style="">

			<?php do_action( 'bbp_theme_before_reply_content' ); ?>

			<?php bbp_reply_content(); ?>

			<?php do_action( 'bbp_theme_after_reply_content' ); ?>
		</div>
-->
	</div>

</div><!-- .respuesta -->
