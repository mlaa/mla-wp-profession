<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main row" role="main">

			<?php
			while ( have_posts() ) : the_post();

				if ( get_field('article_type') == 'article') {
					?>
						<div class="col-sm-12 single-post-header" style="

							<?php if (get_the_post_thumbnail_url() ): ?>
								<?php $caption = get_the_post_thumbnail_caption() ?>
								background-image: url(<?php the_post_thumbnail_url() ?>)
							<?php endif; ?>

							">
							<?php if ($caption) {
								?><p class="featured-image-caption"><?php the_post_thumbnail_caption(); ?></p><?php
							} ?>
						</div>

						<div class="col-10 offset-1 col-lg-6 col-md-8 offset-lg-3 offset-md-2">
					<?php
						get_template_part( 'template-parts/content', get_post_format() );

				} elseif ( get_field('article_type') == 'feature') {
					?>

						<?php
							get_template_part( 'template-parts/feature-content', get_post_format() );

 						?>

						<!-- Center comments below article in feature-content hack -->
						<div class="col-10 offset-1 col-lg-6 col-md-8 offset-lg-3 offset-md-2">

					<?php


				}
				?>

				<?php



				    //the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
			</div>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();
