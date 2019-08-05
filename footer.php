<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
		<div class="container-fluid pt-3 pb-3">
						<div class="container">
							<div class="row">
								<nav class="col-sm-12 col-md-4 ">
									<p class="footer-col-title">Browse <em>Profession</em></p>

									<?php
									wp_nav_menu(array(
									'theme_location'  => 'footer',
									'container'       => 'div',
									'container_id'    => 'main-nav',
									'container_class' => 'footer-nav',
									'menu_id'         => false,
									'menu_class'      => 'navbar-nav internal-nav',
									'depth'           => 3,
									'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
									'walker'          => new wp_bootstrap_navwalker()
									));
									?>

								</nav>

								<nav class="col-sm-12 col-md-4 mla-links">
									<p class="footer-col-title">More from the MLA</p>
									<?php
									wp_nav_menu(array(
									'theme_location'  => 'mla-links',
									'container'       => 'div',
									'container_id'    => 'main-nav',
									'container_class' => 'footer-nav',
									'menu_id'         => false,
									'menu_class'      => 'navbar-nav',
									'depth'           => 3,
									'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
									'walker'          => new wp_bootstrap_navwalker()
									));
									?>
								</nav>

								<div class="col-sm-12 col-md-4 footer-site-info">
									<p class="site-name"><a href="<?php echo esc_url( home_url( '/' )); ?>" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/profession-logo-inv.png" alt="Profession logo" class="footer-logo">Profession</a></p>
									<p class="site-name"><a href="https://www.mla.org"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mla-logo.png" alt="Modern Language Association" class="mla-logo"></a></p>
									<p class="site-name">
										<a href="https://facebook.com/modernlanguageassociation" target="_blank"><i class="fab fa-facebook-f"></i></a>
										<a href="https://linkedin.com/company/modern-language-association" target="_blank"><i class="fab fa-linkedin-in"></i></a>
										<a href="https://twitter.com/mlanews" target="_blank"><i class="fab fa-twitter"></i></a>
									</p>
								</div>
							</div>

							<div class="site-info col-sm-12">
	                &copy; <?php echo date('Y'); ?> <?php echo '<a href="https://www.mla.org">Modern Language Association</a>'; ?>
									<p class="priv-policy"><a href="https://www.mla.org/About-Us/About-the-MLA/Privacy-Policy">Privacy Policy</a></p>
							</div>
						</div>




		</div>
	</footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

<script>

	jQuery(document).ready(function($) {
		const navSearchForm = $('li.search form')
		const searchIcon = $('i.nav-search-icon')
		navSearchForm.hide();

		searchIcon.on('click', function() {

			navSearchForm.animate({
				width: 'toggle'
			});
			if ( $(this).hasClass('search-active') ) {

				$(this).removeClass('search-active')
			} else {
				$(this).addClass('search-active')
			}

		});


	//	$(document).mouseup(function(e) {
		//	if (!navSearchForm.is(e.target) && navSearchForm.has(e.target).length === 0 && !searchIcon.is(e.target) ) {
		//		navSearchForm.hide();
		//		$(document).unbind('click');
		//		searchIcon.removeClass('search-active')
		//	}
	//	})


	})
</script>

<!-- Mouseflow -->
<script type="text/javascript">
    window._mfq = window._mfq || [];
    (function() {
        var mf = document.createElement("script");
        mf.type = "text/javascript"; mf.async = true;
        mf.src = "//cdn.mouseflow.com/projects/8fbf472b-20d6-4d4b-b3d7-4eeb32b32f75.js";
        document.getElementsByTagName("head")[0].appendChild(mf);
    })();
</script>
</body>
</html>
