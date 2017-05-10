<?php
/**
 * The default template used for displaying post content in index.php
 *
 * @package Counter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php counter_post_thumbnail(); ?>

	<header class="entry-header">

		<?php counter_entry_meta_header(); ?>

		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
			/* Translators: %s: title of the post. */
			the_content( sprintf( __( 'Continue reading %s', 'counter' ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'counter' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
