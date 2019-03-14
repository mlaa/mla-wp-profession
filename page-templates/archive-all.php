<?php
/**
 * Template Name: Archive All
 *
 * @package WP_Bootstrap_Starter
 */


get_header();
?>

<section id="primary" class="content-area col-sm-12">
  <main id="main" class="site-main row" role="main">
    <div class="col-sm-12 resource-type-hero">
      <div class="row">
        <h1 class="col-sm-12 col-lg-8 offset-lg-2"><?php the_title(); ?></h1>
      </div>
    </div>

    <?php

    $current_issue_array =  array(
      'post_type'           => 'issue',
      'meta_query' 					=> array(
          array(
            'key'							=> 'issuenum',
            'compare'					=> '=',
            'value'						=> 0

          )
        ),
      'posts_per_page'      => 1,
      'meta_key'            => 'issuenum',
      //'suppress_filters' => true,
      //'meta_type'           => 'NUMERIC',
      'orderby'              => 'meta_value',
      'order'               => 'DESC'
    );

    $current_issue = new WP_Query( $current_issue_array );

    if ( $current_issue->have_posts() ) {
      while( $current_issue->have_posts() ) {
        $current_issue->the_post();
        $current_issue_id = get_the_ID();
        $current_issue_title = $post->post_title;
      };
    };

    wp_reset_query();


      $args = array(
        'post_type'       => 'post',
        //'post__in'        => get_option('sticky_posts'),
        'meta_query'      => array(
                                array(
                                  'key'     => 'issue',
                                  'value'   => '"'. $current_issue_id .'"',
                                  'compare' => 'LIKE'
                                )
                              ),
        'posts_per_page'  => '-1',
        'orderby'         => 'date',
        'order'           => 'DESC'
      );


      $archive_posts = new WP_Query($args);

      if ($archive_posts->have_posts()) {
        while ($archive_posts->have_posts()) {
          $archive_posts->the_post();
          ?>
          <div class="col-8 offset-2">
            <article class="mt-5">
              <h3><?php the_title(); ?></h3>

              <p>AUTHOR: <?php echo full_name(get_the_ID()); ?></p>
              <p>EXCERPT: <?php the_excerpt(); ?></p>
              <p>FEATURED IMAGE: <br><?php the_post_thumbnail('medium'); ?></p>
              <p><?php echo edit_post_link(); ?></p>
            </article>
          </div>

          <?php
        };
      };


     ?>
  </main>
</section>

<?php
get_footer();

?>
