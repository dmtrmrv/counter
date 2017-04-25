<?php
/**
 * The template for displaying pages
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>

				<?php comments_template(); ?>

			<?php endif; ?>

		<?php endwhile; ?>

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer();
