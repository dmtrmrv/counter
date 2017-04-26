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

			<?php get_template_part( 'template-parts/content' ); ?>

		<?php endwhile; ?>

		<?php counter_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

	</div><!-- #primary -->

	<?php if ( 'default' == get_theme_mod( 'blog_layout', 'default' ) ) : ?>

		<?php get_sidebar(); ?>

	<?php endif; ?>

<?php get_footer();
