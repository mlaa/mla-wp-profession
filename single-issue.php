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

			<div class="col-sm-12 single-post-header main-feature" style="
						<?php if (get_the_post_thumbnail_url() ): ?>
							background-image: url(<?php the_post_thumbnail_url() ?>)
						<?php endif; ?>
					">
				<div class="col-10 col-lg-6 col-md-8 cover-story-box <?php echo check_for_thumbnail(); ?>">
					<div class="">
						<?php
						$current_issue_id = get_the_ID();
						?>
						<?php if ( get_field('issue_season', $current_issue_id) != 'Archive' ) {
							?>
							<p class="current-issue-label"><?php the_field('issue_season', $current_issue_id); ?></p>
							<?php
						};
							 the_title('<h1>','</h1>');
							?>
					</div>
				</div>
			</div>



			<div class="col-lg-6 offset-lg-3 mt-5">

				<?php if ( get_field('issue_season', $current_issue_id) == 'Archive' ) {
					?>
					<h3 class="block-head">Articles from the&nbsp;<em>Profession</em>&nbsp;Archive</h3>
					<?php
					} else {
					?>
					<h3 class="block-head">In This Issue</h3>
				<?php
				};
				?>

			</div>

			<div class="col-md-10 offset-md-1">

				<div class="row">
					<?php
					$current_issue_args =  array(
						'post_type'						=> 'post',
						'meta_query'          => array(
																				array(
																					'key'     => 'issue',
																					'value'   => '"'. $current_issue_id .'"',
																					'compare' => 'LIKE'
																				)
																			),

						'orderby'							=> 'date',
						'order'								=> 'DESC',
						'posts_per_page'			=> '-1',
						'ignore_sticky_posts' => 1
					);
					//global $post;

					$current_issue_posts = new WP_Query( $current_issue_args );

					if ($current_issue_posts->have_posts() ) {
						while ($current_issue_posts->have_posts() ) {
							$current_issue_posts->the_post();
							?>
							<article class="mt-4 current-issue-article col-md-6">
								<h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
								<p class="byline">By <?php echo full_name(get_the_ID()); ?></p>
								<?php the_excerpt(); ?>
							</article>
							<?php
						};
					};
					wp_reset_postdata();
					?>
				</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();
