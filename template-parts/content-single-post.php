<?php
/**
 * The template used for displaying post content in single.php
 *
 * @package Counter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php counter_entry_meta_header(); ?>

	</header><!-- .entry-header -->

	<?php counter_post_thumbnail(); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'counter' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

	<?php counter_entry_meta_footer(); ?>

</article><!-- #post-## -->
