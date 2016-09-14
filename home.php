<?php
/**
 * Template for displaying blog index
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area <?php counter_blog_layout_class(); ?>">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', get_theme_mod( 'blog_layout' ) ); ?>

		<?php endwhile; ?>

		<?php counter_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

	</div><!-- #primary -->

	<?php
		// Display sidebar only on deafult blog layout.
		if ( 'default' == get_theme_mod( 'blog_layout', 'default' ) ) {
			get_sidebar();
		}
	?>

<?php get_footer(); ?>
