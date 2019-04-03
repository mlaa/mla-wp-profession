<?php
/**
 * Template Name: All Features
 *
 * @package WP_Bootstrap_Starter
 */


get_header();
?>

<section id="primary" class="content-area col-sm-12">
  <main id="main" class="site-main row" role="main">


    <div class="col-sm-12 resource-type-hero single-feature-header">
      <div class="row">
        <h1 class="col-sm-12"><?php the_title(); ?></h1>
      </div>
    </div>


    <div class="col-lg-8 offset-lg-2 mt-5 row">

        <?php
          $features_args = array(
            'post_type'       => 'post',
            'meta_query'      => array(
                                  array(
                                    'key'     => 'article_type',
                                    'value'   => 'feature',
                                    'compare' => 'LIKE'
                                  )
                                ),
            'orderby'         => 'DATE',
            'order'           => 'DESC',
            'posts_per_page'  => '-1',
            'ignore_sticky_posts' => 1
          );

          $all_features = new WP_Query($features_args);
          if ($all_features->have_posts()) {
            while ($all_features->have_posts()) {
              $all_features->the_post();

                get_template_part( 'template-parts/content', 'search' );
              ?>


              <!--<article class="col-sm-12 col-lg-4">
                <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                <?php the_excerpt(); ?>
              </article>-->

              <?php
            };
          };
          wp_reset_query();
        ?>

    </div>

  </main>
</section>

<?php
get_footer();

?>
