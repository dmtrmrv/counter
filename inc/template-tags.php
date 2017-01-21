<?php
/**
 * Custom template tags for this theme
 *
 * @package Counter
 */

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
	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list && counter_categorized_blog() ) {
		printf( '<div class="entry-meta-item cat-links">%s</div>', $categories_list ); // WPCS: XSS OK.
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
		$tags_list = get_the_tag_list( '', '' );
		if ( $tags_list ) {
			printf( '<footer class="entry-footer"><span class="tags-links">%s</span></footer><!-- .entry-footer -->', $tags_list ); // WPCS: XSS OK.
		}
	}
}
endif;

if ( ! function_exists( 'counter_site_title_tagline' ) ) :
/**
 * Displays site title and tagline.
 */
function counter_site_title_tagline() {
	$title = get_bloginfo( 'name' );
	$tagline = get_bloginfo( 'description', 'display' );

	if ( $title || is_customize_preview() ) {
		printf(
			'<%1$s class="site-title"><a href="%2$s">%3$s</a></%1$s>',
			is_front_page() ? 'h1' : 'p',
			esc_url( home_url( '/' ) ),
			esc_html( $title )
		);
	}

	if ( $tagline || is_customize_preview() ) {
		printf(
			'<p class="site-description">%s</p>',
			esc_html( $tagline )
		);
	}
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
			the_post_thumbnail( '936x0' );
		echo '</div>';
	} else {
		printf( '<a class="post-thumbnail" href="%s">', esc_url( apply_filters( 'the_permalink', get_permalink() ) ) );
			the_post_thumbnail( '612x0' );
		echo '</a>';
	}
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

/**
 * Displays Footer Text.
 */
function counter_footer_text() {
	printf(
		esc_html__( '%1$s theme by %2$s', 'counter' ),
		'Counter',
		'<a href="' . esc_url( 'https://themepatio.com/' ) . '">ThemePatio</a>'
	);
}

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
 * Displays panel thumbnail.
 */
function counter_panel_thumbnail() {
	if ( post_password_required() || is_attachment() ) {
		return;
	}
	if ( has_post_thumbnail() ) {
		echo '<div class="panel-thumbnail">';
			the_post_thumbnail( '720x0' );
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
 * Displays panel content.
 */
function counter_panel_content() {
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

/**
 * Displays the template part for panels on the frontpage.
 *
 * Also used as a render callback to update the panel content, layout, or
 * background image from the Customizer.
 *
 * Keep in mind that it is used to render the hero panel as well as other panels
 * in the Customizer. It looks like it's not being executed from within the
 * loop, so we have to explicitly check what page is used as a front page.
 * Otherwise the_content() doesn't work in Customizer.
 *
 * It would be an overkill to call this function from the front-page.php to
 * display the hero panel because the_content() does work there. That's why
 * front-page.php uses this funciton to only display secondary panels.
 *
 * @param  object  $partial The partial object.
 * @param  integer $i       Number of the panel.
 */
function counter_panel( $partial = null, $i = 0 ) {

	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
		$i = preg_replace( '/panel_(content|layout|bg_image)_/', '', $partial->id );
	}

	// Get the layout for the current panel.
	$layout = get_theme_mod( 'panel_layout_' . $i, 'center' );

	// Temporarily modify the post object.
	global $post;

	if ( 0 == $i ) {
		// Get the page on front.
		$post = get_post( get_option( 'page_on_front' ) ); // wpcs: override ok.
		setup_postdata( $post );

		set_query_var( 'counter_panel_num', $i );
		set_query_var( 'counter_panel_layout', $layout );
		set_query_var( 'counter_panel_has_background', get_theme_mod( 'panel_bg_image_' . $i, false ) ? ' has-background' : '' );

		// Display panel content.
		get_template_part( 'template-parts/panel', $layout );

	} elseif ( get_theme_mod( 'panel_content_' . $i ) ) {
		$post = get_post( get_theme_mod( 'panel_content_' . $i ) ); // wpcs: override ok.
		setup_postdata( $post );

		// Set the variables that will be available within template part.
		set_query_var( 'counter_panel_num', $i );
		set_query_var( 'counter_panel_layout', $layout );
		set_query_var( 'counter_panel_has_background', get_theme_mod( 'panel_bg_image_' . $i, false ) ? ' has-background' : '' );

		// Display panel content.
		get_template_part( 'template-parts/panel', $layout );

	}

	// Reset the whole thing.
	wp_reset_postdata();
}
