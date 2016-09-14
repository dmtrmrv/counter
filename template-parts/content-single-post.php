<?php
/**
 * The template used for displaying post content in single.php
 *
 * @package Owner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php owner_entry_meta_header(); ?>

	</header><!-- .entry-header -->

	<?php owner_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'owner' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php owner_entry_meta_footer(); ?>

</article><!-- #post-## -->

