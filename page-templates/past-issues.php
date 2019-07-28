<?php
/**
 * Template Name: Past Issues
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main row" role="main">

			<div class="col-sm-12 single-post-header main-feature" style="">
				<div class="col-10 col-lg-6 col-md-8 cover-story-box no-thumbnail">
					<div class="">
						<h1>Past Issues</h1>
					</div>
				</div>
			</div>



			<div class="col-md-10 offset-md-1 mt-5">

				<?php

					$issues_args = array(
						'post_type' => 'issue',
						'orderby'		=> 'date'
					);

					$all_issues = new WP_Query($issues_args);

					if ($all_issues->have_posts()) {
						while ($all_issues->have_posts()) {
							$all_issues->the_post();

							?>

							<?php
								$issue_num = get_the_ID();
							?>

								<h3 class="block-head col-md-6 mt-5">
									<a href="<?php the_permalink(); ?>">
										<?php if (get_field('issue_number', $issue_num) != 0) {
											?><span class="issue-number mb-1 mt-1 d-block"><?php echo get_field('issue_season', $issue_num); ?></span>
											<?php
										} ?>

										<?php the_title(); ?>
									</a>
								</h3>

								<div class="row">


									<?php
										$post_args = array(
											'post_type'						=> 'post',
											'meta_query'          => array(
																									array(
																										'key'     => 'issue',
																										'value'   => '"'. $issue_num .'"',
																										'compare' => 'LIKE'
																									)
																								),

											'orderby'							=> 'date',
											'order'								=> 'DESC',
											'posts_per_page'			=> '6',
											'ignore_sticky_posts' => 1
										);

										$posts_in_issue = new WP_Query($post_args);
										if ($posts_in_issue->have_posts()) {
											while ($posts_in_issue->have_posts()) {
												$posts_in_issue->the_post();
													?>
													<article class="mt-4 current-issue-article col-md-6">
														<h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
														<?php if (get_field('author_name') || get_field('author_last_name')) {
                    									?>
														<p class="byline">By <?php echo full_name(get_the_ID()); ?></p>
													<?php }; the_excerpt(); ?>
													</article>
													<?php
											}

											$count = $posts_in_issue->max_num_pages;


											if ($count > 1) {
												?><a class="more-resources-link col-md-12" href="<?php echo get_permalink($issue_num); ?>">View more articles.</a>	<?php
											}


										}
										?>
									</div> <!-- End row -->

								<?php
						}
					}

				?>

			</div>



		</main><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();
