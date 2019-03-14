<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>
<div class="resource-container col-lg-3 col-md-6 col-12">
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-3 h-100 single-resource resource-search-result '.get_field('resource_type') ); ?> >
	<header class="entry-header">
		<span class="resource-type-label"><?php the_field('resource_type'); ?></span>
		<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php wp_bootstrap_starter_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->


</article><!-- #post-## -->
</div>
