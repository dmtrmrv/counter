<?php
/**
 * The main template file
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content' ); ?>

		<?php endwhile; ?>

		<?php counter_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer();
