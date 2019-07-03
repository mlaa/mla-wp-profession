<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-10 offset-1 col-lg-5 offset-lg-2">
		<main id="main" class="site-main row" role="main">
			<?php
			while ( have_posts() ) {
				the_post();

			?>
			<div class="mt-5 single-resource-post">

				<?php
				// Get field label and value for class name and span content
				$resource_type_field = get_field_object('resource_type');
				$resource_type_value = $resource_type_field['value'];
				?>

				<span class="resource-type <?php echo $resource_type_value ?>"><?php the_field('resource_type'); ?></span>

				<?php the_title('<h1>','</h1>'); ?>

				<h3>
					<?php
						echo get_field('due_date') ? 'Due Date: '.date('m-d-Y', strtotime(get_field('due_date')) ).'<br>' : '' ;
						echo get_field('start_date') ? 'Starts: '.date('m-d-Y', strtotime(get_field('start_date')) ).'<br>' : '';
						echo get_field('end_date') ? 'Ends: '.date('m-d-Y', strtotime(get_field('end_date')) ) : '';
					?>
				</h3>
				<?php echo the_content(); ?>
			</div>
			<?php
			}
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar('resources');
get_footer();
