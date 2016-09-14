<?php
/**
 * The template for displaying front page
 *
 * Template Name: Front Page
 *
 * @package Owner
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php
			// IDs of the pages that serve as panels.
			$owner_panel_ids = array();
			for ( $i = 1; $i <= owner_get_panel_count(); $i++ ) {
				if ( get_theme_mod( 'panel_content_' . $i ) ) {
					$owner_panel_ids[ $i ] = get_theme_mod( 'panel_content_' . $i );
				}
			}

			// Panels Query.
			$owner_panels_query = new WP_Query( array(
				'post_type'      => 'page',
				'post__in'       => $owner_panel_ids,
				'orderby'        => 'post__in',
				'posts_per_page' => owner_get_panel_count(),
				'no_found_rows'  => true, // See http://flavio.tordini.org/speed-up-wordpress-get_posts-and-query_posts-functions for details.
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
			if ( $owner_panels_query->have_posts() ) {

				// Array that holds post objects for panels.
				$owner_panels = array();

				// Loop through each panel.
				while ( $owner_panels_query->have_posts() ) : $owner_panels_query->the_post();
					$owner_panels[ get_the_ID() ] = get_post();
				endwhile;

				// Reset the whole thing.
				wp_reset_postdata();

				foreach ( $owner_panel_ids as $k => $v ) {
					// Temporarily setup post data to current panel.
					$post = $owner_panels[ $v ];
					setup_postdata( $post );

					// Get the layout for the current panel.
					$layout = get_theme_mod( 'panel_layout_' . $k, 'center' );

					// Set the variables that will be available within template part.
					set_query_var( 'owner_panel_num', $k );
					set_query_var( 'owner_panel_layout', $layout );

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

<?php get_footer(); ?>
