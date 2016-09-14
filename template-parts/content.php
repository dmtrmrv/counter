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
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Read more %s', 'counter' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
