<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-10 offset-1 col-sm-12 col-lg-3 article-block__right-col mt-5" role="complementary">

	<h3 class="">
		More Opportunities
	</h3>
	<?php
		$resources_args = array(
			'post_type'        => 'opportunity',
			//'post__not_in'		 =>	$resources,
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
</aside><!-- #secondary -->
