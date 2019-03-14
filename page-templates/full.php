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
        <h1 class="col-sm-12"><?php the_title(); ?></h1>
      </div>
    </div>
    <?php if (have_posts() ) {
      while (have_posts()) {
        the_post();
        ?>

        <div class="col-sm-12 col-lg-6 offset-lg-3 col-md-8 offset-md-2 mt-5 page-content">
          <?php the_content(); ?>
        </div>

        <?php
      }
    } ?>

  </main>
</section>

<?php
get_footer();

?>
