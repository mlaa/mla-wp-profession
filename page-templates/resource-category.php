<?php
/**
 * Template Name: Resource Category
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


    /*
     * This reallllly needs to be refactored because it's using the url parameter to build the query,
     * and right now, it's hardcoded and super brittle.
     *
     */

     // This gets the route and uses it for the dynamic query
    global $wp;
    $url = home_url( $wp->request );
    //$end_route = end(explode('/', rtrim($url, 's/')));
    $end_route = rtrim(explode('/', $url)[3], 's/');

    //print_r($end_route);


        $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

        $args = array(
          'post_type'           => 'resource',
          'meta_query'          => array(
                                      'resource-type' => array(
                                        'key'     => 'resource_type',
                                        'value'   => $end_route,
                                        'compare' => '='
                                      ),

                                    ),


          //'orderby'							=> $orderby_condition,
          //'order'								=> 'DESC',
          'posts_per_page'			=> '12',
          'paged'               => $paged,
          'ignore_sticky_posts' => 1
        );

        // Get today's date to only show posts where due date is in future or no due_date is given
        $today = date('Ymd', strtotime("now"));
        //$alt_today = new DateTime($today);
        //$posted_today = new DateTime($today);
      //  $posted_today->format('Y-m-d');
        //$three_months_ago = $posted_today->sub(new DateInterval('P3M'));
        //$three_months_ago->format('Y-m-d');


        if ($end_route == 'cfp' || $end_route == 'award') {
          $args['meta_query']['sort-by-due-date'] = array(
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
                                                    );



          $args['orderby'] = array(
                              'real-due-date-sort'=> 'ASC',
                              'exp-date-sort' => 'ASC',
                              'title'  => 'ASC',
                            );
        } elseif ($end_route == 'grant') {
          // To do: Add alphabetical override
          //$args['meta_key'] = 'alphabetical_override';

          $args['meta_query']['alphabetical-sort'] = array(
                                                      //'relation' => 'OR',
                                                      'real-alpha-sort' => array(
                                                         'key' => 'alphabetical_override',

                                                      ),

                                                      //'title-alpha-sort' => array(
                                                      //     'key' => 'title',
                                                           //'value' => NULL,
                                                           //'compare' => 'EXISTS'
                                                      //   )


                                                     );
          $args['orderby'] = array(
                              //'title-alpha-sort' => 'ASC',
                              'real-alpha-sort' => 'ASC',
                              'title' => 'ASC',
                             );


        } elseif ($end_route == 'conference') {
          // TO DO: Order by end date, only show meetings in future
          $args['meta_query']['sort-by-start-date'] = array(
                                                      'key' => 'start_date',
                                                      'value' => $today,
                                                      'compare' => '>='
                                                    );
          $args['orderby'] = array(
                              'sort-by-start-date' => 'ASC',
                              'title' => 'ASC',
                             );
        } else {
          $orderby_condition = 'date';
        };



    ?>


    <div class="col-lg-7 offset-lg-1 mt-5">

      <div class="resource-intro">
        <?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)); ?>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row resources">

            <?php
              $resources = new WP_Query( $args );

              if ($resources->have_posts() ) {
                ?>

                  <?php
                  $max = $resources->max_num_pages;
                  while ($resources->have_posts() ) {
                    $resources->the_post();

                    // This makes sure posts are not duplicated in the sidebar
                    $exclude_posts[] = $post->ID;
                    ?>

                      <div class="col-lg-4 col-md-6 resource-container posts">
                        <a href="<?php the_permalink() ?>">
                          <article class="single-resource h-100 <?php echo $end_route ?>">
                            <h4>
                              <?php the_title(); ?>
                            </h4>

                            <?php
                              // We need to strip these tags or else <a> tags will break the link to the single view.
                              echo '<p>'.strip_tags( get_the_excerpt(), '<i><b><em><strong>' ).'</p>';
                            ?>
                            <span class="resource-type-label"> <?php echo get_field('due_date') ? 'Due date: '.date('m-d-Y', strtotime(get_field('due_date')) ) : ''; ?></span>
                          </article>
                        </a>
                      </div>

                    <?php
                  };
                  ?>
                </div>

                <?php
                  //global $wp_query;

                  //print_r($resources->query_vars);

                  if ( $resources->max_num_pages > 1 ) {

                    //echo '<div class="load-more-link">Load more resources.</div>';
                    // next_posts_link() usage with max_num_pages
                    //next_posts_link( 'View more resources.', $resources->max_num_pages );
                    //previous_posts_link( 'Go to previous page.' );

                    $big = 999999999; // need an unlikely integer

                    echo paginate_links( array(
                    	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    	'format' => '?paged=%#%',
                    	'current' => max( 1, get_query_var('paged') ),
                    	'total' => $resources->max_num_pages
                    ) );
                  }

                ?>


                <?php
              };
             ?>


             <?php
             wp_reset_postdata();
             ?>
        </div>



        </div>


      </div>

      <!-- Sidebar start -->
      <aside id="secondary" class="widget-area col-sm-12 col-lg-3 mt-5 article-block__right-col" role="complementary">

      	<h3 class="mb-3">
      		Other Recent Resources
      	</h3>
      	<?php
      		$resources_args = array(
      			'post_type'        => 'resource',
      			'post__not_in'		 =>	$exclude_posts,
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
      					<a class="<?php echo $resource_type_value ?> resource-type" href="<?php echo home_url().'/'.$resource_type_value.'s' ?>"><?php echo $resource_type_label ?></a>
      				</article>

      				<?php
      			};
      		};
      	?>
      </aside>
      <!-- Sidebar end -->



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
