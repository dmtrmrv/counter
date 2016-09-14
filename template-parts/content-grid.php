<?php
/**
 * The default template used for displaying posts in a grid view
 *
 * @package Owner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'owner-grid-item' ); ?>>

	<?php owner_grid_item_thumbnail(); ?>

	<header class="entry-header">
		<?php owner_entry_meta_header(); ?>

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
