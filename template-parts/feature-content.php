<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>



	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php
			if ( is_single() ) :
				?>
				<!--Begin hero/gradient section -->
				<div class="col-sm-12 single-feature-header" style="background-image: <?php echo get_the_post_thumbnail_url() ? 'url('.the_post_thumbnail_url().')' : '' ?>)">
				<?php

				the_title( '<h1 class="entry-title col-lg-8 col-12 offset-lg-2">', '</h1>' );
				?>
				<p class="post-byline">By <?php echo full_name(get_the_ID()) ?></p>

				</div> <!-- End of hero/gradient section -->
			</header><!-- .entry-header -->
			<!--Beginning of content container -->
			<div class="col-10 offset-1 col-lg-6 col-md-8 offset-lg-3 offset-md-2">
				<?php
			else :
				the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
				?>
				</header><!-- .entry-header -->
				<?php
			endif;

			if ( 'post' === get_post_type() ) : ?>
			<!--<div class="entry-meta">
				<?php wp_bootstrap_starter_posted_on(); ?>
			</div>--><!-- .entry-meta -->
			<?php
			endif; ?>

		<div class="entry-content">
			<?php
	        if ( is_single() ) :
						the_content();
						get_cc_license(get_field('license_type'));
						if ( get_field('author_bio') ) {
						?>
							<div class="bio"><?php echo get_field('author_bio') ?></div>
						<?php
					};
	        else :
	            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
	        endif;

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<!--<footer class="entry-footer">
			<?php wp_bootstrap_starter_entry_footer(); ?>
		</footer>--><!-- .entry-footer -->
	</article><!-- #post-## -->
