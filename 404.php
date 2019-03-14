



<?php
/**
 * Template Name: Full
 *
 * @package WP_Bootstrap_Starter
 */


get_header();
?>

<section id="primary" class="content-area col-sm-12">
  <main id="main" class="site-main row" role="main">
    <div class="col-sm-12 resource-type-hero">
      <div class="row">
        <h1 class="col-sm-12 col-lg-8 offset-lg-2">That page cannot be found.</h1>
      </div>
    </div>

        <div class="col-sm-12 col-lg-6 offset-lg-3 col-md-8 offset-md-2 mt-5 mb-5 page-content page-404">
					<p class="mb-5 mt-5"><?php esc_html_e( 'It looks like nothing was found at this location. Try one of the links above or search below.', 'wp-bootstrap-starter' ); ?></p>

					<?php
						get_search_form();


					?>
        </div>


  </main>
</section>

<?php
get_footer();

?>
