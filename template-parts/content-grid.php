<?php
/**
 * The default template used for displaying posts in a grid view
 *
 * @package Counter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'counter-grid-item' ); ?>>

	<?php counter_grid_item_thumbnail(); ?>

	<header class="entry-header">
		<?php counter_entry_meta_header(); ?>

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
