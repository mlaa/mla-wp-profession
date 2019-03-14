<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Bootstrap_Starter
 *
 *
 *
 */


get_header(); ?>

<?php
// Return what type of search, i.e. resources or generic search
$search_type = $_GET["site_section"];

 ?>
	<section id="primary" class="content-area col-sm-12 ">
		<main id="main" class="site-main row" role="main">

			<div class="col-sm-12 resource-type-hero">
	      <div class="row">
	        <h1 class="col-sm-12 col-lg-8 offset-lg-2">
						<?php
						if ($search_type == 'resource') {
							echo 'Resources related to '.get_search_query();
						} else {
							printf( esc_html__( 'Search Results for %s', 'wp-bootstrap-starter' ), '<span>' . get_search_query() . '</span>' );
						}
						?>
					</h1>

	      </div>
	    </div>

			<div class="col-lg-8 offset-lg-2 mt-5 row">
				<?php



				if ( have_posts() ) : ?>

				<!--	<header class="page-header">
						<h1 class="page-title"><?php printf( esc_html__( 'Search Results for %s', 'wp-bootstrap-starter' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header>--><!-- .page-header -->

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Run the loop for the search to output the results
						 */
						if ($search_type == 'resource') {

							get_template_part( 'template-parts/content', 'resources-search' );
						} else {
							get_template_part( 'template-parts/content', 'search' );
						};

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
