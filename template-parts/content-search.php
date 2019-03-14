<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-3, col-12'); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<p class="entry-meta--byline">
				By <?php echo full_name(get_the_ID()) ?>
				<?php ?>
				<?php if (get_field('article_type') === 'article' ) : ?>
					<?php $issue = get_field('issue'); ?>
					| <a href="<?php echo get_permalink( $issue[0] ) ?>"><?php echo get_the_title($issue[0]) ?></a> 
				<?php endif; ?>
			</p>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->


</article><!-- #post-## -->
