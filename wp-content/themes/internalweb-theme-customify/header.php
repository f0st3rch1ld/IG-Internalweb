<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package customify
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=10.0, user-scalable=yes">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>

	<!-- Font Awesome Hookup -->
	<script src="https://kit.fontawesome.com/1dca653a37.js" crossorigin="anonymous"></script>

	<!-- tablesorter plugin -->
	<!-- choose a theme file -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/tablesorter/css/theme.default.css">
	<!-- load tablesorter scripts -->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/tablesorter/js/jquery.tablesorter.js"></script>

	<!-- tablesorter widgets (optional) -->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/tablesorter/js/jquery.tablesorter.widgets.js"></script>
	<!-- /tablesorter plugin -->
</head>

<body <?php body_class(); ?>>
	<?php
	if (function_exists('wp_body_open')) {
		wp_body_open();
	}
	?>
	<div id="page" <?php customify_site_classes(); ?>>


		<!-- inserted from customizer -->
		<div class="header-top header--row layout-full-contained" id="cb-row--header-top" data-row-id="top" data-show-on="desktop">
			<div class="header--row-inner header-top-inner dark-mode">
				<div class="customify-container">
					<div class="customify-grid customify-grid-middle">
						<div class="row-v2 row-v2-top no-left no-center">
							<div class="col-v2 col-v2-right">
								<div class="item--inner builder-item--html" data-section="header_html" data-item-id="html">
									<div class="builder-header-html-item item--html">
										<div class="custom-login-link-container">
											<?php
											$current_user = wp_get_current_user();
											if (is_user_logged_in()) : ?>
												<p>Welcome <?php echo $current_user->display_name; ?> /&nbsp;</p>
												<a href="<?php echo wp_logout_url(); ?>">Log-Out</a>
											<?php else : ?>
												<a href="<?php echo wp_login_url(); ?>">Log-In</a>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /inserted from customizer -->


		<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e('Skip to content', 'customify'); ?></a>
		<?php
		do_action('customify/site-start/before');
		if (!customify_is_e_theme_location('header')) {
			/**
			 * Site start
			 *
			 * Hooked
			 *
			 * @see customify_customize_render_header - 10
			 * @see Customify_Page_Header::render - 35
			 */
			do_action('customify/site-start');
		}
		do_action('customify/site-start/after');

		/**
		 * Hook before main content
		 *
		 * @since 0.2.1
		 */
		do_action('customify/before-site-content');
		?>
		<div id="site-content" <?php customify_site_content_class(); ?>>
			<div <?php customify_site_content_container_class(); ?>>
				<div <?php customify_site_content_grid_class(); ?>>
					<main id="main" <?php customify_main_content_class(); ?>>
						<?php do_action('customify/main/before'); ?>