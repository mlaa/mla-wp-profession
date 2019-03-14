<?php
/**
 * Template Name: Resources
 *
 * @package WP_Bootstrap_Starter
 */


get_header();
?>

<section id="primary" class="content-area col-sm-12">
  <main id="main" class="site-main row" role="main">
    <div class="col-sm-12 resources-hero">
      <div class="row">
        <h1 class="col-sm-12 col-lg-8 offset-lg-2"><?php the_title(); ?></h1>

      </div>
    </div>

    <?php $today = date('Ymd', strtotime("now")); ?>
    <?php

    /*
     *
     * Originally, I abstracted each resource query into the function below,
     * but it become too complicated with the complicated orderby logic, so now
     * it is four discrete queries.
     *
     */
      function get_resources_args( $resource_type ) {

        $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

        $args = array(
          'post_type'   => 'resource',
          'meta_query'          => array(
                                      'resource-type' => array(
                                        'key'     => 'resource_type',
                                        'value'   => $resource_type,
                                        'compare' => '='
                                      )
                                    ),
          //'orderby'							=> 'date',
          //'order'								=> 'DESC',
          'posts_per_page'			=> '4',
          'paged'               => $paged,
          'ignore_sticky_posts' => 1
        );


        return $args;
      }


    ?>
    <div class="col-sm-12 col-lg-6 offset-lg-3 resource-intro mt-5">
      <p>
        <?php echo get_post_field('post_content', $post->ID); ?>

        <form role="search" method="get" class="search-form row resource-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

            <label class="col-9">
                <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'wp-bootstrap-starter' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'wp-bootstrap-starter' ); ?>">
                <input type="hidden" name="post_type" value="resource" />
                <input type="hidden" name="site_section" value="resource" />
            </label>
            <input type="submit" class="search-submit btn btn-default col-3 h-100" value="<?php echo esc_attr_x( 'Search', 'submit button', 'wp-bootstrap-starter' ); ?>">
        </form>
      </p>
    </div>
    <div class="col-lg-10 offset-lg-1">
      <div class="row">
        <div class="col-12">
          <h3 class="resource-section-title block-head" id="conference"><a href="<?php echo home_url().'/conferences' ?>">Conferences and Meetings</a></h3>
          <div class="row resources">

            <?php
             $args = array(
               'post_type'   => 'resource',
               'meta_query'          => array(
                                           'resource-type' => array(
                                             'key'     => 'resource_type',
                                             'value'   => 'conference',
                                             'compare' => '='
                                           ),
                                           'sort-by-start-date' => array(
                                             'key' => 'start_date',
                                             'value' => $today,
                                             'compare' => '>='
                                           ),
                                         ),
               'orderby'							=> array(
                                           'sort-by-start-date' => 'ASC',
                                           'title' => 'ASC',
                                         ),
               'posts_per_page'			=> '4',
               //'paged'               => $paged,
               'ignore_sticky_posts' => 1
             );
              $conferences = new WP_Query( $args );

              if ($conferences->have_posts() ) {
                ?>

                  <?php
                  $max = $conferences->max_num_pages;
                  while ($conferences->have_posts() ) {
                    $conferences->the_post();

                    ?>

                      <div class="col-lg-3 col-md-6 resource-container posts">
                        <a href="<?php the_permalink() ?>">
                          <article class="single-resource h-100 conference">
                            <h4>
                              <?php the_title(); ?>
                            </h4>

                            <?php the_excerpt(); ?>
                          </article>
                        </a>
                      </div>

                    <?php
                  };
                  ?>
                </div>
                <a href="conferences" class="more-resources-link">View more meetings and conferences.</a>

                  <!--<nav class="link">
                    <?php
                      //next_posts_link( 'View more conferences and meetings', $conferences->max_num_pages );
                    ?>-->
                  </nav>
                <?php
              };
              wp_reset_postdata();
            ?>
        </div>

        <div class="col-12">
          <h3 class="resource-section-title block-head" id="award"><a href="<?php echo home_url().'/awards' ?>">Awards and Prizes</a></h3>
          <div class="row">
            <?php
            $args = array(
              'post_type'   => 'resource',
              'meta_query'          => array(
                                          'resource-type' => array(
                                            'key'     => 'resource_type',
                                            'value'   => 'award',
                                            'compare' => '='
                                          ),
                                          'sort-by-due-date' => array(
                                            'relation' => 'OR',
                                            'real-due-date-sort' => array(
                                                  'key' => 'due_date',
                                                  'value' => $today,
                                                  'compare' => '>='
                                                ),
                                            'exp-date-sort' => array(
                                                'key' => 'expiration_date',
                                                'value' => $today,
                                                'compare' => '>=',
                                            ),
                                          ),
                                        ),
              'orderby'							=> array(
                                          'real-due-date-sort'=> 'ASC',
                                          'exp-date-sort' => 'ASC',
                                          'title' => 'ASC',
                                        ),
              'posts_per_page'			=> '4',
              //'paged'               => $paged,
              'ignore_sticky_posts' => 1
            );
              $awards = new WP_Query( $args );

              if ($awards->have_posts() ) {
                while ($awards->have_posts() ) {
                  $awards->the_post();
                  ?>
                    <div class="col-lg-3 col-md-6 resource-container">
                      <a href="<?php the_permalink() ?>">
                        <article class="single-resource h-100 award">
                          <h4>
                            <?php the_title(); ?>
                          </h4>

                          <?php the_excerpt(); ?>
                        </article>
                      </a>
                    </div>

                  <?php
                };
                ?>
              </div>
              <a href="awards" class="more-resources-link">View more awards.</a>

                <!--<nav class="link">
                  <?php
                    //next_posts_link( 'View more conferences and meetings', $awards->max_num_pages );
                  ?>
                </nav>-->
                <?php
              };
              wp_reset_postdata();
             ?>
        </div>

        <div class="col-12">
          <h3 class="resource-section-title block-head" id="cfp"><a href="<?php echo home_url().'/cfps' ?>">Calls for Papers</a></h3>
          <div class="row">
            <?php
            $args = array(
              'post_type'   => 'resource',
              'meta_query'          => array(
                                          'resource-type' => array(
                                            'key'     => 'resource_type',
                                            'value'   => 'cfp',
                                            'compare' => '='
                                          ),
                                          'sort-by-due-date' => array(
                                            'relation' => 'OR',
                                            'real-due-date-sort' => array(
                                                  'key' => 'due_date',
                                                  'value' => $today,
                                                  'compare' => '>='
                                                ),
                                            'exp-date-sort' => array(
                                                'key' => 'expiration_date',
                                                'value' => $today,
                                                'compare' => '>=',
                                            ),
                                          ),
                                        ),
              'orderby'							=> array(
                                          'real-due-date-sort'=> 'ASC',
                                          'exp-date-sort' => 'ASC',
                                          'title' => 'ASC',
                                        ),
              'posts_per_page'			=> '4',
              //'paged'               => $paged,
              'ignore_sticky_posts' => 1
            );
              $cfps = new WP_Query( $args );

              if ($cfps->have_posts() ) {
                while ($cfps->have_posts() ) {
                  $cfps->the_post();
                  ?>
                    <div class="col-lg-3 col-md-6 resource-container">
                      <a href="<?php the_permalink() ?>">
                        <article class="single-resource h-100 cfp">
                          <h4>
                            <?php the_title(); ?>
                          </h4>

                          <?php the_excerpt(); ?>
                        </article>
                      </a>
                    </div>

                  <?php
                };
                ?>
              </div>

              <a href="cfps" class="more-resources-link">View more calls for papers.</a>

              <!--  <nav class="link">
                  <?php
                    //next_posts_link( 'View more conferences and meetings', $cfps->max_num_pages );
                  ?>
                </nav>-->
                <?php
              };
              wp_reset_postdata();
             ?>
        </div>

        <div class="col-12">
          <h3 class="resource-section-title block-head" id="grant"><a href="<?php echo home_url().'/grants' ?>">Grants and Fellowships</a></h3>
          <div class="row">
            <?php
            $args = array(
              'post_type'   => 'resource',
              'meta_query'          => array(
                                          'resource-type' => array(
                                            'key'     => 'resource_type',
                                            'value'   => 'grant',
                                            'compare' => '='
                                          ),
                                          array(
                                          'real-alpha-sort' => array(
                                             'key' => 'alphabetical_override',
                                            ),
                                          ),
                                        ),
              'orderby'							=> array(
                                          'real-alpha-sort' => 'ASC',
                                          'title' => 'ASC',
                                        ),
              'posts_per_page'			=> '4',
              //'paged'               => $paged,
              'ignore_sticky_posts' => 1
            );
              $grants = new WP_Query( $args );
              if ($grants->have_posts() ) {
                while ($grants->have_posts() ) {
                  $grants->the_post();
                  ?>
                    <div class="col-lg-3 col-md-6 resource-container">
                      <a href="<?php the_permalink() ?>">
                        <article class="single-resource h-100 grant">
                          <h4>
                            <?php the_title(); ?>
                          </h4>

                          <?php the_excerpt(); ?>
                        </article>
                      </a>
                    </div>

                  <?php };
                   ?>
          </div>

          <a href="grants" class="more-resources-link">View more grants and fellowships.</a>
          <?php
      };
      wp_reset_postdata();

     ?>
        </div>
      </div>

    </div>

  </main><!-- #main -->
  </section><!-- #primary -->
  <script type="text/javascript">
    jQuery(document).ready(function($) {


     $('.link a').on('click', function(e){
         e.preventDefault();
         var resourceType = $(this).attr('resource-type');
         var clickedLink = $(this).parent().prev();
         var link = jQuery(this).attr('href');
         //jQuery('.load_more').html('<span class="loader">Loading More Posts...</span>');
         $.get(link, function(data) {
             var post = $(".resource-container", data);
             clickedLink.append(post);
         });

         $(this).parent().load(link+' .link a');
     });

    });
  </script>
  <?php

  get_footer();

  ?>
