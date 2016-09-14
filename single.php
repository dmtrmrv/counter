<?php
/**
 * The template for displaying all single posts
 *
 * @package Owner
 */

get_header(); ?>

	<div id="primary" class="content-area">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'template-parts/content-single', get_post_type() ); ?>

		<?php owner_post_navigation(); ?>

		<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>

	<?php endwhile; ?>

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
