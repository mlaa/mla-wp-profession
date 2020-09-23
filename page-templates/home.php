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

                    <?php if (get_field('author_name') || get_field('author_last_name')) {
                    ?>
                      <p>By <?php echo implode(' ', array(get_field('author_name'), get_field('author_last_name') ) ) ?></p>
                    <?php 
                    }; ?>


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
            <h3 class="block-head"><span>In Practice</span></h3>

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
             <a href="in-practice" class="btn pl-4 pr-4">View All</a>
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
                'post_type'        => 'opportunity',
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
            <a class="btn" href="opportunities">View More Opportunities</a>
            <!-- Resources block - end -->

            <!-- Subscribe form - start -->
            <h3 class="block-head pt-4"><span>Subscribe to <em>Profession</em></span></h3>

            <div class="col-sm-12">
              <!-- FORM: HEAD SECTION -->

              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                      <script type="text/javascript">
                  document.addEventListener("DOMContentLoaded", function(){
                      const FORM_TIME_START = Math.floor((new Date).getTime()/1000);
                      let formElement = document.getElementById("tfa_0");
                      if (null === formElement) {
                          formElement = document.getElementById("0");
                      }
                      let appendJsTimerElement = function(){
                          let formTimeDiff = Math.floor((new Date).getTime()/1000) - FORM_TIME_START;
                          let cumulatedTimeElement = document.getElementById("tfa_dbCumulatedTime");
                          if (null !== cumulatedTimeElement) {
                              let cumulatedTime = parseInt(cumulatedTimeElement.value);
                              if (null !== cumulatedTime && cumulatedTime > 0) {
                                  formTimeDiff += cumulatedTime;
                              }
                          }
                          let jsTimeInput = document.createElement("input");
                          jsTimeInput.setAttribute("type", "hidden");
                          jsTimeInput.setAttribute("value", formTimeDiff.toString());
                          jsTimeInput.setAttribute("name", "tfa_dbElapsedJsTime");
                          jsTimeInput.setAttribute("id", "tfa_dbElapsedJsTime");
                          jsTimeInput.setAttribute("autocomplete", "off");
                          if (null !== formElement) {
                              formElement.appendChild(jsTimeInput);
                          }
                      };
                      if (null !== formElement) {
                          if(formElement.addEventListener){
                              formElement.addEventListener('submit', appendJsTimerElement, false);
                          } else if(formElement.attachEvent){
                              formElement.attachEvent('onsubmit', appendJsTimerElement);
                          }
                      }
                  });
              </script>

              <link href="https://www.tfaforms.com/dist/form-builder/5.0.0/wforms-layout.css?v=0246591584232a6325b1af88966a271ab79612dc" rel="stylesheet" type="text/css" />

              <link href="https://www.tfaforms.com/uploads/themes/theme-52691.css" rel="stylesheet" type="text/css" />
              <link href="https://www.tfaforms.com/dist/form-builder/5.0.0/wforms-jsonly.css?v=0246591584232a6325b1af88966a271ab79612dc" rel="alternate stylesheet" title="This stylesheet activated by javascript" type="text/css" />
              <script type="text/javascript" src="https://www.tfaforms.com/wForms/3.11/js/wforms.js?v=0246591584232a6325b1af88966a271ab79612dc"></script>
              <script type="text/javascript">
                  wFORMS.behaviors.prefill.skip = false;
              </script>
                  <script type="text/javascript" src="https://www.tfaforms.com/wForms/3.11/js/localization-en_US.js?v=0246591584232a6325b1af88966a271ab79612dc"></script>

          <!-- FORM: BODY SECTION -->
          <div class="wFormContainer" >
              <div class="wFormHeader"></div>
              <style type="text/css"></style><div class=""><div class="wForm" id="4696002-WRPR" dir="ltr">
          <div class="codesection" id="code-4696002"><style>
            .wFormContainer .wForm .primaryAction {
            color: #ffffff; 
            }
            
            .wFormContainer .wForm {
              background: none;
              
            }
            
          </style></div>
          <h3 class="wFormTitle" id="4696002-T">Subscribe to <i>Profession</i></h3>
          <form method="post" action="https://www.tfaforms.com/responses/processor" class="hintsBelow labelsAbove" id="4696002" role="form">
          <div class="oneField field-container-D    " id="tfa_1-D">
          <label id="tfa_1-L" class="label preField " for="tfa_1">First name</label><br><div class="inputWrapper"><input type="text" id="tfa_1" name="tfa_1" value="" title="First name" class=""></div>
          </div>
          <div class="oneField field-container-D    " id="tfa_2-D">
          <label id="tfa_2-L" class="label preField " for="tfa_2">Last name</label><br><div class="inputWrapper"><input type="text" id="tfa_2" name="tfa_2" value="" title="Last name" class=""></div>
          </div>
          <div class="oneField field-container-D    " id="tfa_4-D">
          <label id="tfa_4-L" class="label preField reqMark" for="tfa_4">E-mail address</label><br><div class="inputWrapper"><input type="text" id="tfa_4" name="tfa_4" value="" aria-required="true" title="E-mail address" class="required"></div>
          </div>
          <div class="oneField field-container-D     wf-acl-hidden" id="tfa_5-D">
          <label id="tfa_5-L" class="label preField " for="tfa_5">If you are a human and can see this, leave it blank. Do not fill it out.</label><br><div class="inputWrapper"><input type="text" id="tfa_5" name="tfa_5" value="" title="If you are a human and can see this, leave it blank. Do not fill it out." class=""></div>
          </div>
          <div class="actions" id="4696002-A"><input type="submit" data-label="Subscribe" class="primaryAction" id="submit_button" value="Subscribe"></div>
          <div style="clear:both"></div>
          <input type="hidden" value="4696002" name="tfa_dbFormId" id="tfa_dbFormId"><input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId"><input type="hidden" value="8c33fbcdef371b8dd0689249f16a22c9" name="tfa_dbControl" id="tfa_dbControl"><input type="hidden" value="7" name="tfa_dbVersionId" id="tfa_dbVersionId"><input type="hidden" value="" name="tfa_switchedoff" id="tfa_switchedoff">
          </form>
          </div></div><div class="wFormFooter"><p class="supportInfo"><br></p></div>
            <p class="supportInfo" >
                </p>
          </div>


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
