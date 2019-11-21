<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

// Add search bar to nav
add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);

 function add_search_form($items, $args) {
          if( $args->theme_location == 'primary' )
          $items .= '<li class="search"><i class="material-icons nav-search-icon">search</i>
<form role="search" method="get" id="searchform" action="'.home_url( '/' ).'"><input type="text" class="search-field form-control" placeholder="Search&hellip;" name="s" id="s" /><input type="submit" class="search-submit btn btn-default" id="searchsubmit" value="'. esc_attr__('Search') .'" /></form></li>';
     return $items;
}

// Register footer nav
function register_footer_nav() {
  register_nav_menu('footer',__( 'Footer' ));
}
function register_mla_links() {
  register_nav_menu('mla-links',__( 'MLA Links' ));
}
add_action( 'init', 'register_footer_nav' );
add_action( 'init', 'register_mla_links' );


/*
*
This code splits posts into individual <p>s and then
adds pull quotes at specified points.
*
*/

add_filter( 'the_content', 'prefix_insert_first_pull_quote' );
add_filter( 'the_content', 'prefix_insert_second_pull_quote' );


function prefix_insert_first_pull_quote( $content ) {
  global $post ;
  $id = $post->ID ;
  $location = get_field('pull_quote_one_location', $id );

  if (get_field('pull_quote_one', $id )) {
    $pull_quote = '<div class="neg-offset-l-4 mr-3 pull-quote col-8">'. get_field('pull_quote_one', $id ) .'</div>';
  } else {
    $pull_quote = '';
  }
 if ( is_single() && ! is_admin() ) {
 return prefix_insert_after_paragraph( $pull_quote, $location, $content );
 }
return $content;
}

function prefix_insert_second_pull_quote( $content ) {
  global $post ;
  $id = $post->ID ;
  $location = get_field('pull_quote_two_location', $id );
  if (get_field('pull_quote_two', $id )) {
    $pull_quote = '<div class="float-right neg-offset-r-4 ml-3 pull-quote col-8">'. get_field('pull_quote_two', $id ) .'</div>';
  } else {
    $pull_quote = '';
  }
 if ( is_single() && ! is_admin() ) {
 return prefix_insert_after_paragraph( $pull_quote, $location, $content );
 }
return $content;
}

function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
 $closing_p = '</p>';
 $paragraphs = explode( $closing_p, $content );
 foreach ($paragraphs as $index => $paragraph) {
   if ( trim( $paragraph ) ) {
   $paragraphs[$index] .= $closing_p;
   }
   if ( $paragraph_id == $index + 1 ) {
   $paragraphs[$index] .= $insertion;
   }
 }

 return implode( '', $paragraphs );
}

function prefix_insert_before_end( $insertion, $content ) {
 $closing_p = '</p>';
 $paragraphs = explode( $closing_p, $content );
 foreach ($paragraphs as $index => $paragraph) {
   if ( trim( $paragraph ) ) {
   $paragraphs[$index] .= $closing_p;
   }
   if ( count($paragraphs) == $index + 26 ) {
   $paragraphs[$index] .= $insertion;
   }
 }

 return implode( '', $paragraphs );
}


/*
*
Add custom formats to TinyMCE editor
*
*/
function wpb_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

/*
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats( $init_array ) {



// Define the style_formats array for the tiny mce customization
    $style_formats = array(
/*
* Each array child is a format with it's own settings
* Notice that each array has title, block, classes, and wrapper arguments
* Title is the label which will be visible in Formats menu
* Block defines whether it is a span, div, selector, or inline style
* Classes allows you to define CSS classes
* Wrapper whether or not to add a new block-level element around any selected elements
*/
        array(
            'title' => 'Works-Cited-List Entry',
            'block' => 'span',
            'classes' => 'works-cited',
            'wrapper' => true,

        ),
        array(
            'title' => 'Note',
            'block' => 'span',
            'classes' => 'note',
            'wrapper' => true,
        ),
        array(
            'title' => 'Bulleted List',
            'selector' => 'ul',
            'classes' => 'bulleted',
            //'wrapper' => true,

        )

    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );


/**
 * Filter the except length to 10 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 10;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

/*
 *
 * Replace bracketed ellipsis in excerpt
 *
 */

 function new_excerpt_ellipsis( $more ) {
	return '&nbsp;.&nbsp;.&nbsp;.';
}
add_filter('excerpt_more', 'new_excerpt_ellipsis');


/*
 *
 * CC widget:
 * Find correct license and insert badge/link at end of story
 *
 */

 function get_cc_license( $license ) {
   //$license_field = get_field_object($license);
   $license_field_value = $license['value'];
   if ($license_field_value == 'cc-by-4.0') {
     echo '<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/80x15.png" /></a><span class="license-type">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.</span>';
   } elseif ($license_field_value == 'cc-by-nc-4.0') {
     echo '<a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/80x15.png" /></a><span class="license-type">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.</span>';
   } elseif ($license_field_value == 'cc-by-nd-4.0') {
     echo '<a rel="license" href="http://creativecommons.org/licenses/by-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nd/4.0/80x15.png" /></a><span class="license-type">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nd/4.0/">Creative Commons Attribution-NoDerivatives 4.0 International License</a>.</span>';
   } elseif ($license_field_value == 'cc-by-nc-nd-4.0') {
     echo '<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png" /></a><span class="license-type">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License</a>.</span>';
   } elseif ($license_field_value == 'cc-by-sa-4.0') {
     echo '<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/80x15.png" /></a><span class="license-type">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.</span>';
   } elseif ($license_field_value == 'cc-by-nc-sa-4.0') {
     echo '<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png" /></a><span class="license-type">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.</span>';
   } else {

   };
 }

 function full_name($post_id) {
   return implode(' ', array(get_field('author_name', $post_id), get_field('author_last_name', $post_id) ) );
 }


/*
 *  Code snippet adapted from https://alex.blog/2011/09/20/code-snippet-add-a-link-to-latest-post-to-wordpress-nav-menu/
 * to display link to most recent issue
 *
 */

 // Front end only, don't hack on the settings page
if ( ! is_admin() ) {
    // Hook in early to modify the menu
    // This is before the CSS "selected" classes are calculated
    add_filter( 'wp_get_nav_menu_items', 'replace_placeholder_nav_menu_item_with_latest_post', 10, 3 );
}

// Replaces a custom URL placeholder with the URL to the latest post
function replace_placeholder_nav_menu_item_with_latest_post( $items, $menu, $args ) {

    // Loop through the menu items looking for placeholder(s)
    foreach ( $items as $item ) {

        // Is this the placeholder we're looking for?
        if ( '#latestissue' != $item->url )
            continue;

        // Get the latest post
        $latestissue = get_posts( array(
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
        )
      );

        if ( empty( $latestissue ) )
            continue;

        // Replace the placeholder with the real URL
        $item->url = get_permalink( $latestissue[0]->ID );
    }

    // Return the modified (or maybe unmodified) menu items array
    return $items;
}


/*
 *
 * Remove admin bar and CSS
 *
 */

 add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}



/* Detect if there's a post thumbnail */
function check_for_thumbnail() {
  if (get_the_post_thumbnail_url() ) {
    return 'thumbnail';
  } else {
    return 'no-thumbnail';
  }
}






function wp_bootstrap_starter_comment( $comment, $args, $depth ) {
   // $GLOBALS['comment'] = $comment;

    if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
        <div class="comment-body">
            <?php _e( 'Pingback:', 'wp-bootstrap-starter' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'wp-bootstrap-starter' ), '<span class="edit-link">', '</span>' ); ?>
        </div>

    <?php else : ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
            <a class="pull-left" href="#">
                <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            </a>

            <div class="media-body">
                <div class="media-body-wrap card">

                    <div class="card-header">
                        <h5 class="mt-0"><?php printf( __( '%s <span class="says">says:</span>', 'wp-bootstrap-starter' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h5>
                        <div class="comment-meta">
                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                <time datetime="<?php comment_time( 'c' ); ?>">
                                    <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'wp-bootstrap-starter' ), get_comment_date(), get_comment_time() ); ?>
                                </time>
                            </a>
                            <?php edit_comment_link( __( '<span style="margin-left: 5px;" class="glyphicon glyphicon-edit"></span> Edit', 'wp-bootstrap-starter' ), '<span class="edit-link">', '</span>' ); ?>
                        </div>
                    </div>

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wp-bootstrap-starter' ); ?></p>
                    <?php endif; ?>

                    <div class="comment-content card-block">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->

                    <?php //comment_reply_link(
                      //  array_merge(
                      //      $args, array(
                      //          'add_below' => 'div-comment',
                      //          'depth' 	=> $depth,
                      //          'max_depth' => $args['max_depth'],
                      //          'before' 	=> '<footer class="reply comment-reply card-footer">',
                      //          'after' 	=> '</footer><!-- .reply -->'
                      //      )
                      //)
                  //  ); ?>

                </div>
            </div><!-- .media-body -->

        </article><!-- .comment-body -->

        <?php
    endif;
}



// Change results per page in search results page
function wp_search_size($query) {
    if ( $query->is_search ) // Make sure it is a search page
        $query->query_vars['posts_per_page'] = 12; // Change 10 to the number of posts you would like to show

    return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'wp_search_size'); // Hook our custom function onto the request filter



add_filter( 'comment_form_defaults', function ( $args ) {
	// i.e. different themes may have different form structures.
	// 15 zine uses comment-form which is not using hte hook system so not affected.
	$args['comment_notes_before'] = "<p class=\"comment-notes\"><span id=\"email-notes\">Your e-mail address will not be published.</span> Required fields are marked <span class=\"required\">*</span>.</p>";

	return $args;
} );

add_filter( 'comment_form_default_fields', 'profession_comment_form_fields' );

function profession_comment_form_fields( $fields ) {

	$fields['email']  = '<p class="comment-form-email"><label for="email">' . __( 'E-mail' ) . '<span class="required">*</span></label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30" /></p>';

	return $fields;
}
