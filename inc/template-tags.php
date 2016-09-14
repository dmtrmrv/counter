<?php
/**
 * Custom template tags for this theme
 *
 * @package Counter
 */

/**
 * Displays custom logo for the site.
 *
 * @todo Remove when 4.7 is out
 */
function counter_site_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

if ( ! function_exists( 'counter_entry_meta_header' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function counter_entry_meta_header() {

	$meta_items = get_theme_mod( 'entry_meta_items', array( 'cat-links', 'posted-on', 'byline', 'comments-link' ) );
	$is_customizer = is_customize_preview();

	if ( ( is_array( $meta_items ) && ! ! array_filter( $meta_items ) ) || $is_customizer ) :

	// Print the opening tag.
	echo '<div class="entry-meta">';

	/*
	 * Category.
	 *
	 * Translators: used between list items, there is a space after the comma.
	 */
	$categories_list = get_the_category_list( esc_html__( ', ', 'counter' ) );
	if ( $categories_list && counter_categorized_blog() && in_array( 'cat-links', $meta_items ) || $is_customizer ) {
		printf( '<span class="entry-meta-item cat-links">' . esc_html__( '%1$s', 'counter' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}

	/*
	 * Date.
	 */
	if ( in_array( 'posted-on', $meta_items ) || $is_customizer ) {
		$time_string = '<time class="entry-date published updated %3$s" datetime="%1$s" %4$s>%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf( '<span class="entry-meta-item posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',  // WPCS: XSS OK.
			esc_url( get_permalink() ),
			$time_string
		);
	}

	/*
	 * Author.
	 */
	if ( in_array( 'byline', $meta_items ) || $is_customizer ) {
		echo '<span class="entry-meta-item byline">';
			printf(
				'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			);
		echo '</span>';
	}

	/*
	 * Comments.
	 */
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) && in_array( 'comments-link', $meta_items ) || $is_customizer ) {
		echo '<span class="entry-meta-item comments-link">';
		comments_popup_link( __( 'Leave a comment', 'counter' ), __( '1 Comment', 'counter' ), __( '% Comments', 'counter' ) );
		echo '</span>';
	}

	// Print the closing tag.
	echo '</div><!-- .entry-meta -->';

	endif;
}
endif;

if ( ! function_exists( 'counter_entry_meta_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function counter_entry_meta_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( '', 'counter' ) );
		if ( $tags_list ) {
			printf( '<footer class="entry-footer"><span class="tags-links">' . esc_html__( '%1$s', 'counter' ) . '</span></footer><!-- .entry-footer -->', $tags_list ); // WPCS: XSS OK.
		}
	}
}
endif;

if ( ! function_exists( 'counter_site_title' ) ) :
/**
 * Displays site title.
 */
function counter_site_title() {
	$class = 'site-title';
	// Set the second argument to 'true' to display title by default.
	if ( ! get_theme_mod( 'display_title', true ) ) {
		$class .= ' screen-reader-text';
	}
	printf( '<h1 class="%s"><a href="%s" rel="home">%s</a></h1>',
		esc_attr( $class ),
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}
endif;

if ( ! function_exists( 'counter_site_tagline' ) ) :
/**
 * Displays site description.
 */
function counter_site_tagline() {
	$class = 'site-description';
	// Set the second argument to 'true' to display tagline by default.
	if ( ! get_theme_mod( 'display_tagline', true ) ) {
		$class .= ' screen-reader-text';
	}
	printf( '<h2 class="%s">%s</h2>', esc_attr( $class ), esc_html( get_bloginfo( 'description' ) ) );
}
endif;

if ( ! function_exists( 'counter_post_thumbnail' ) ) :
/**
 * Displays post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * view, or a div element on single view.
 */
function counter_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular( array( 'post', 'page' ) ) ) {
		echo '<div class="post-thumbnail">';
			the_post_thumbnail( 'counter-thumbnail-single' );
		echo '</div>';
	} else {
		printf( '<a class="post-thumbnail" href="%s">', esc_url( apply_filters( 'the_permalink', get_permalink() ) ) );
			the_post_thumbnail( 'counter-thumbnail' );
		echo '</a>';
	}
}
endif;

if ( ! function_exists( 'counter_grid_item_thumbnail' ) ) :
/**
 * Displays post thumbnail in a grid.
 *
 * Wraps the post thumbnail in an anchor element on index
 * view, or a div element on single view.
 */
function counter_grid_item_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	printf( '<a class="post-thumbnail" href="%s">', esc_url( apply_filters( 'the_permalink', get_permalink() ) ) );
		the_post_thumbnail( 'counter-thumbnail-grid' );
	echo '</a>';
}
endif;

if ( ! function_exists( 'counter_posts_navigation' ) ) :
/**
 * Displays Posts Navigation a.k.a Older/Newer posts links on a blog page.
 */
function counter_posts_navigation() {
	$args = array(
		'prev_text'          => __( 'Older', 'counter' ),
		'next_text'          => __( 'Newer', 'counter' ),
		'screen_reader_text' => __( 'Posts navigation', 'counter' ),
	);
	the_posts_navigation( $args );
}
endif;

if ( ! function_exists( 'counter_post_navigation' ) ) :
/**
 * Displays Post Navigation a.k.a Next/Previous Post links on a single post page.
 */
function counter_post_navigation() {
	$args = array(
		'prev_text'          => '%title',
		'next_text'          => '%title',
		'screen_reader_text' => __( 'Post navigation', 'counter' ),
	);

	$previous = get_previous_post_link( '<div class="nav-link nav-previous"><span class="nav-pre-link">' . esc_html__( 'Prev:', 'counter' ) . ' </span>%link</div>', $args['prev_text'] );
	$next     = get_next_post_link( '<div class="nav-link nav-next"><span class="nav-pre-link">' . esc_html__( 'Next:', 'counter' ) . ' </span>%link</div>', $args['next_text'] );

	// Only add markup if there's somewhere to navigate to.
	if ( $previous || $next ) {
		echo _navigation_markup( $next . $previous, 'post-navigation', $args['screen_reader_text'] ); // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'counter_comment_navigation' ) ) :
/**
 * Displays Comment Navigation.
 */
function counter_comment_navigation() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'counter' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'counter' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'counter' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
	<?php endif;
}
endif;

if ( ! function_exists( 'counter_footer_text' ) ) :
/**
 * Displays Footer Text.
 */
function counter_footer_text() {
	if ( get_theme_mod( 'footer_text', false ) ) {
		echo wp_kses_post( str_replace( '[year]', date( 'Y' ), get_theme_mod( 'footer_text', false ) ) );
	} else {
		printf(
			esc_html__( '%1$s theme by %2$s', 'counter' ),
			'Counter',
			'<a href="' . esc_url( 'https://themepatio.com/' ) . '">ThemePatio</a>'
		);
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function counter_categorized_blog() {
	if ( false === ( $categories = get_transient( 'counter_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			'number'     => 2, // We only need to know if there is more than one.
		) );

		// Count the number of categories that are attached to the posts.
		$categories = count( $categories );

		set_transient( 'counter_categories', $categories );
	}

	if ( $categories > 1 ) {
		// This blog has more than 1 category so counter_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so counter_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in counter_categorized_blog.
 */
function counter_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'counter_categories' );
}
add_action( 'edit_category', 'counter_category_transient_flusher' );
add_action( 'save_post',     'counter_category_transient_flusher' );

/**
 * Panels on the front page.
 */
function counter_panels() {
	for ( $i = 1; $i <= 10; $i++ ) :
		if ( get_theme_mod( 'panel_' . $i ) ) :
			$post = get_post( get_theme_mod( 'panel_' . $i ) );
			setup_postdata( $post );
			set_query_var( 'counter_panel', $i );
			get_template_part( 'template-parts/content', 'front' );
			wp_reset_postdata();
		endif;
	endfor;
}

/**
 * Displays panel thumbnail.
 */
function counter_panel_thumbnail() {
	if ( post_password_required() || is_attachment() ) {
		return;
	}
	if ( has_post_thumbnail() ) {
		echo '<div class="panel-thumbnail">';
			the_post_thumbnail( 'counter-panel-half' );
		echo '</div>';
	} else {
		?>
		<div class='panel-thumbnail'>
			<svg class='panel-thumbnail-placeholder' xmlns='http://www.w3.org/2000/svg' version='1.1' viewBox="0 0 100 100" xmlns:xlink='http://www.w3.org/1999/xlink'>
				<rect class='shape' x='0' y='0' width='100%' height='100%' fill='#e5e5e5'></rect>
				<text x="50%" y="50%" font-size="3" fill-opacity="0.5" alignment-baseline="middle" text-anchor="middle"><?php esc_html_e( 'No Featured Image', 'counter' ); ?></text>
			</svg>
		</div>
		<?php
	}
}

/**
 * Displays panel title.
 *
 * @param int $num The number of the panel.
 */
function counter_panel_title( $num ) {
	// Check if we need to display title.
	if ( is_customize_preview() ) {
		if ( get_theme_mod( 'panel_title_display_' . $num, 1 ) ) {
			the_title( '<h2 class="panel-title">', '</h2>' );
		} else {
			the_title( '<h2 class="panel-title" style="display: none;">', '</h2>' );
		}
	} elseif ( get_theme_mod( 'panel_title_display_' . $num, 1 )  ) {
		// Output heading with the screen reader class or not.
		the_title( '<h2 class="panel-title">', '</h2>' );
	}
}

/**
 * Displays panel content.
 *
 * @param int $num The number of the panel.
 */
function counter_panel_content( $num ) {
	// Check if we need to display the content first.
	if ( get_the_content() ) { ?>
		<div class="panel-content">
			<?php the_content( __( 'Read more', 'counter' ) ); ?>
		</div><?php
	}
}

/**
 * Prints panel number for users who can edit the theme.
 *
 * @param string $num Panel number.
 * @param string $id  Post id.
 */
function counter_panel_meta( $num = '', $id = '' ) {
	if ( 'page' == get_post_type() && current_user_can( 'edit_pages' ) ) {
		if ( is_customize_preview() ) {
			printf( '<span class="panel-meta">#panel-%s</span>', esc_html( $num ) );
		} else {
			echo '<span class="panel-meta">';
				printf( '<span class="panel-num">#%s</span>', esc_html( $num ) );
				echo ' &middot; ';
				edit_post_link( __( 'Edit', 'counter' ), '', '', $id );
				echo ' &middot; ';
				printf( '<a href="%s" class="panel-customize-link">%s</a>', esc_url( admin_url( 'customize.php?autofocus[section]=panel_' . $num ) ), esc_html__( 'Customize', 'counter' ) );
			echo '</span>';
		}
	}
}
