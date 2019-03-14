<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<?php
	$issue_number = get_field('issue');
	//$issue_class = get_field('issuenum', $issue_number[0]);
	//print_r($issue_class);

	$issue = get_field('issue');
	$issue_class = get_field('issue_season', $issue[0]);


?>


	<article id="post-<?php the_ID(); ?>" <?php post_class(strtolower($issue_class.' '.check_for_thumbnail()) ); ?>>

		<header class="entry-header">
			<?php
			if ( is_single() ) :
				?>
				<p class="issue-number">
					<?php
						echo $issue_class
					?>
				</p>

				<?php

				if ( get_field('thematic', false, false) == true ) {
					?>
						<p class="issue-theme">
							<span><?php echo get_the_title($issue[0]) ?></span>
						</p>
					<?php
				};
				?>

				<?php
				the_title( '<h1 class="entry-title">', '</h1>' );
				?>
				<p class="post-byline">By <?php echo full_name(get_the_ID()) ?></p>
				<?php
			else :
				the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
			<!--<div class="entry-meta">
				<?php wp_bootstrap_starter_posted_on(); ?>
			</div>--><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
	        if ( is_single() ) :
						the_content();
						get_cc_license(get_field_object('license_type'));

						?>

							<?php if (get_field('author_bio') ) {
								?><div class="bio"><?php echo get_field('author_bio') ?></div><?php
							} ?>
						<?php
	        else :
	            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
	        endif;

					if ( $issue_class == 'Archive' ) :
						?>
						<p class="mt-5 archive-post-date">Posted <?php echo the_time('F Y'); ?></p>
						<?php
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
