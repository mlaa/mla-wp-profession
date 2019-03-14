<?php
/**
 * Template Name: Home
 *
 * @package WP_Bootstrap_Starter
 */


get_header();
?>

<section id="primary" class="content-area col-sm-12">
  <main id="main" class="site-main row" role="main">

      <div class="col-sm-12 col-md-4 order-md-1 order-2 issue-contents">
        <h3>In This Issue</h3>

        <?php

              $current_issue_array =  array(
                'post_type'           => 'issue',
                'meta_query' 					=> array(
										array(
											'key'							=> 'issuenum',
											'compare'					=> '>',
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
              //global $post;

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
                'post_type'						=> 'post',
                'meta_query'          => array(
                                            'issue-number' => array(
                                              'key'     => 'issue',
                                              'value'   => '"'. $current_issue_id .'"',
                                              'compare' => 'LIKE'
                                            ),
                                            'author-last' => array(
                                              'key'     => 'author_last_name',
                                              'compare' => 'EXISTS'
                                            ),
                                            'theme-content' => array(
                                              'key'     => 'thematic'

                                            ),
                                            'priority-note' => array(
                                              'key'     => 'priority'

                                            )
                                          ),
                //'meta_key'						=> 'thematic',
                'orderby'							=> array(
                  'priority-note'=> 'DESC',
                  'theme-content'=> 'DESC',
                  'author-last'  => 'ASC',


                ),
                //'order'								=> 'DESC',
                'posts_per_page'			=> '-1',
                'ignore_sticky_posts' => 1
              );
              //global $post;
              $current_issue_posts = new WP_Query( $args );

              if ( $current_issue_posts->have_posts() ) {
                while( $current_issue_posts->have_posts() ) {
                  $current_issue_posts->the_post();

                  ?>
                  <article class="current-article <?php echo get_field('thematic') ? 'thematic' : 'non-thematic' ?>">
                    <a href="<?php the_permalink() ?>">
                      <h4><?php the_title() ?></h4>
                    </a>
                    <p>By <?php echo implode(' ', array(get_field('author_name'), get_field('author_last_name') ) ) ?></p>


                  </article>
                  <?php

                };
              };

              wp_reset_query();
        ?>
      </div>

      <?php /* grab the url for the current issue's featured image */
        $featured_img_url = get_the_post_thumbnail_url($current_issue_id,'full'); ?>

      <div class="col-sm-12 col-md-8 order-md-2 order-1 main-feature" style="background-image: url(<?php echo $featured_img_url ?>)">

        <div class="cover-story-box">
          <p class="current-issue-label"><?php the_field('issue_season', $current_issue_id); ?></p>
          <h2><a href="<?php echo get_permalink( $current_issue_id ) ?>"><?php echo $current_issue_title; ?></a></h2>


          <?php
          // Get title of cover story of current issue (it's the first element of the array returned by get_field() )
          $cover_story = get_field('cover_story', $current_issue_id)[0];

            if ( $cover_story ) {
              ?>
              <p class="cover-story-title">
                <a href="<?php echo the_permalink($cover_story); ?>"><?php echo get_the_title($cover_story); ?></a>
              </p>
              <p class="cover-story-author">By <?php echo full_name($cover_story) ?></p>
              <?php
            }?>

        </div>
      </div>

      <div class="col-sm-12 site-summary order-3">
        <?php the_content(); ?>
      </div>

      <!-- Features, Links, Archive, Resources - start -->
      <div class="container order-4 pt-5">
        <div class="row">
          <div class="article-block__left-col col-sm-12 col-md-6 col-lg-8">

            <!-- Lastest Features - start -->
            <h3 class="block-head"><span>The Latest Features</span></h3>

            <div class="row">
              <?php
                //Get 4 most recent features
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
                  'posts_per_page'  => '3',
                  'ignore_sticky_posts' => 1
                );

                $latest_features = new WP_Query( $features_args );

                if ($latest_features->have_posts()) {
                  while ($latest_features->have_posts()) {
                    $latest_features->the_post();
                    ?>

                    <article class="col-sm-12 col-lg-4">
                      <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                      <?php the_excerpt(); ?>
                    </article>

                    <?php
                  };
                };
                wp_reset_query();
              ?>
            </div>
            <!-- Latest features - end -->

            <!-- Link block - start -->
            <h3 class="block-head"><span>From Around the Web</span></h3>

            <div class="row">
              <?php
                // Get 3 most recent links
                $link_args = array(
                  'post_type'       => 'link',
                  'orderby'         => 'date',
                  'order'           => 'DESC',
                  'posts_per_page'  => '3'
                );

                $latest_links = new WP_Query( $link_args );
                if ( $latest_links->have_posts() ) {
                  while ( $latest_links->have_posts() ) {
                    $latest_links->the_post();
                    ?>

                    <article class="col-sm-12 col-lg-4 link">
                      <a href="<?php the_field('address') ?>" target="_blank">
                        <?php the_post_thumbnail(); ?>
                        <?php the_title('<h6>', '</h6>'); ?>
                        <?php the_excerpt(); ?>
                      </a>
                    </article>

                    <?php
                  };
                };
                wp_reset_query();
              ?>

            </div>
            <!-- Link block - end -->

            <!-- Archive block - start -->
            <h3 class="block-head"><span>From the Archive</span></h3>

            <div class="row">
              <?php
                $archive_args = array (
                  'post_type'       => 'post',
                  'post__in'        => get_option('sticky_posts'),
                  'meta_query'      => array(
                                          array(
                                            'key'     => 'issue',
                                            'value'   => '"'. $current_issue_id .'"',
                                            'compare' => 'NOT LIKE'
                                          )
                                        ),
                  'posts_per_page'  => '6',
                  'orderby'         => 'date',
                  'order'           => 'DESC'
                );

                $archive_stories = new WP_Query( $archive_args );
                if ( $archive_stories->have_posts() ) {
                  while ( $archive_stories->have_posts() ) {
                    $archive_stories->the_post();
                    ?>
                      <article class="archive-story col-sm-12 col-lg-6">
                        <a href="<?php the_permalink(); ?>"><?php the_title('<h6>','</h6>'); ?></a>
                        <p class="byline">By <?php echo full_name(get_the_ID()); ?></p>
                        <?php the_excerpt(); ?>
                      </article>
                    <?php
                  };
                };
                wp_reset_query();
              ?>
            </div>
            <!-- Archive block - end -->

          </div>

          <div class="article-block__right-col col-sm-12 col-md-6 col-lg-4">

            <!-- Resources block - start -->
            <h3 class="block-head"><span>Calls, Prizes, &amp; Grants</span></h3>

            <?php
              $resources_args = array(
                'post_type'        => 'resource',
                'posts_per_page'   => '12',
                'orderby'          => 'date',
                'order'            => 'DESC'
              );

              $resources_posts = new WP_Query( $resources_args );
              if ($resources_posts->have_posts() ) {
                while ( $resources_posts->have_posts() ) {
                  $resources_posts->the_post();
                  ?>

                  <article class="resource-post">
                    <a href="<?php the_permalink(); ?>"><?php the_title('<h6>','</h6>') ?></a>

                    <?php
                    // Get field label and value for class name and span content
                    $resource_type_field = get_field_object('resource_type');
                    $resource_type_value = $resource_type_field['value'];
                    $resource_type_label = $resource_type_field['choices'][$resource_type_value];
                    ?>
                    <a class="<?php echo $resource_type_value ?> resource-type" href="<?php echo $resource_type_value.'s' ?>"><?php echo $resource_type_label ?></a>
                  </article>

                  <?php
                };
              };
            ?>
            <a class="btn" href="resources">View More Resources</a>
            <!-- Resources block - end -->

            <!-- Subscribe form - start -->
            <h3 class="block-head pt-4"><span>Subscribe to <em>Profession</em></span></h3>

            <div class="col-sm-12">
              <?php echo do_shortcode("[formassembly formid=4696002]"); ?>

            </div>
            <!-- Subscribe form - end -->

          </div>
        </div>
      </div>
      <!-- Features, Links, Archive, Resources - end -->



  </main><!-- #main -->
</section><!-- #primary -->

<?php

get_footer();

?>
