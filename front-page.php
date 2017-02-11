<?php
/**
 * The template for displaying the front page
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php
			// Hero panel goes first.
			while ( have_posts() ) { the_post();
				set_query_var( 'counter_panel_num', 0 );
				set_query_var( 'counter_panel_class', counter_panel_class( 0 ) );
				get_template_part( 'template-parts/panel' );
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
