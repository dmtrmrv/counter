<?php
/**
 * The template for displaying archive pages
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area <?php counter_blog_layout_class(); ?>">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">

			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>

			<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>

		</header><!-- .page-header -->

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content' ); ?>

		<?php endwhile; ?>

		<?php counter_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

	</div><!-- #primary -->

	<?php if ( 'default' == get_theme_mod( 'blog_layout' ) ) : ?>

		<?php get_sidebar(); ?>

	<?php endif; ?>

<?php get_footer();
