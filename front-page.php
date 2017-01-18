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
			while ( have_posts() ) {
				the_post();
				$hero_layout = get_theme_mod( 'panel_layout_0', 'center' );
				set_query_var( 'counter_panel_num', 0 );
				set_query_var( 'counter_panel_layout', $hero_layout );
				set_query_var( 'counter_panel_has_background', get_theme_mod( 'panel_bg_image_0', false ) ? ' has-background' : '' );
				get_template_part( 'template-parts/panel', $hero_layout );
			}

			// IDs of the pages that serve as panels.
			$counter_panel_ids = array();
			for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
				if ( get_theme_mod( 'panel_content_' . $i ) ) {
					$counter_panel_ids[ $i ] = get_theme_mod( 'panel_content_' . $i );
				}
			}

			// Panels Query.
			$counter_panels_query = new WP_Query( array(
				'post_type'      => 'page',
				'post__in'       => $counter_panel_ids,
				'orderby'        => 'post__in',
				'posts_per_page' => counter_get_panel_count(),
				'no_found_rows'  => true, // See http://bit.ly/2dqU8jJ for details.
			) );

			/*
			 * Same front page panel can be displayed multiple times, think
			 * email subscription, or a call to action of some sort.
			 * Because of that we can't use regular while loop.
			 *
			 * To display a panel multiple times, we first create an array
			 * that holds all post objects, and then loop through all post
			 * IDs to retrieve the post object from that array.
			 *
			 * Pretty neat. No extra queries.
			 */
			if ( $counter_panels_query->have_posts() ) {

				// Array that holds post objects for panels.
				$counter_panels = array();

				// Loop through each panel.
				while ( $counter_panels_query->have_posts() ) : $counter_panels_query->the_post();
					$counter_panels[ get_the_ID() ] = get_post();
				endwhile;

				// Reset the whole thing.
				wp_reset_postdata();

				foreach ( $counter_panel_ids as $k => $v ) {
					// Temporarily setup post data to current panel.
					$post = $counter_panels[ $v ];
					setup_postdata( $post );

					// Get the layout for the current panel.
					$layout = get_theme_mod( 'panel_layout_' . $k, 'center' );

					// Set the variables that will be available within template part.
					set_query_var( 'counter_panel_num', $k );
					set_query_var( 'counter_panel_layout', $layout );
					set_query_var( 'counter_panel_has_background', get_theme_mod( 'panel_bg_image_' . $k, false ) ? ' has-background' : '' );

					// Display panel content.
					get_template_part( 'template-parts/panel', $layout );

					// Reset the whole thing.
					wp_reset_postdata();
				}
			} else {
				get_template_part( 'template-parts/panel', 'none' );
			}
		?>
	</div><!-- #primary -->

<?php get_footer();
