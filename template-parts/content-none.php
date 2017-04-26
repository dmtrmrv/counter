<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package Counter
 */

?>

<section class="no-results not-found">

	<header class="page-header">

		<h1 class="page-title">

			<?php esc_html_e( 'Nothing Found', 'counter' ); ?>

		</h1>

	</header><!-- .page-header -->

	<div class="page-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<?php printf( '<p>%s</p>', esc_html__( 'Looks like you don\'t have any posts published yet.', 'counter' ) ); ?>

			<?php printf( '<p><a class="btn btn-accent" href="%1$s">%2$s</a></p>', esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Publish New Post', 'counter' ) ); ?>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Nothing found. Try again with different keywords.', 'counter' ); ?></p>

			<?php get_search_form(); ?>

		<?php elseif ( is_404() ) : ?>

			<p><?php esc_html_e( 'The page you are looking for has been moved or does not exist. Click on the site logo to go to the homepage or try searching.', 'counter' ); ?></p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'Nothing found. Click on the site logo to go to the homepage or try searching.', 'counter' ); ?></p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page-content -->

</section><!-- .no-results -->
