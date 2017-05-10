<?php
/**
 * The template for displaying search results page
 *
 * @package Counter
 */

get_header(); ?>

	<div id="primary" class="content-area">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">

			<h1 class="page-title">

				<?php
					/* Translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'counter' ), '<span>' . get_search_query() . '</span>' );
				?>

			</h1>

		</header><!-- .page-header -->

		<?php get_search_form(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'search' ); ?>

		<?php endwhile; ?>

		<?php the_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

	</div><!-- #primary -->

<?php get_footer();
