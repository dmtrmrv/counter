<?php
/**
 * The template for displaying front page
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php
			// Hero panel goes first.
			while ( have_posts() ) { the_post();
				$counter_hero_layout = get_theme_mod( 'panel_layout_0', 'center' );
				set_query_var( 'counter_panel_num', 0 );
				set_query_var( 'counter_panel_layout', $counter_hero_layout );
				set_query_var( 'counter_panel_has_background', get_theme_mod( 'panel_bg_image_0', false ) ? ' has-background' : '' );
				get_template_part( 'template-parts/panel', $counter_hero_layout );
			}

			// Then the rest of panels.
			if ( 0 !== counter_get_panel_count() || is_customize_preview() ) { // If we have pages to show.
				// Create a setting and control for each of the sections available in the theme.
				for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
					counter_panel( null, $i );
				}
			}
		?>
	</div><!-- #primary -->

<?php get_footer();
