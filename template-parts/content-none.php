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
			<?php if ( is_404() ) : ?>
				<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'counter' ); ?>
			<?php else : ?>
				<?php esc_html_e( 'Nothing Found', 'counter' ); ?>
			<?php endif; ?>
		</h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php esc_html_e( 'Ready to publish your first post?', 'counter' ); ?>
				<?php printf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Get started here &rarr;', 'counter' ) ); ?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'counter' ); ?></p>

			<?php get_search_form(); ?>

		<?php elseif ( is_404() ) : ?>

			<p><?php esc_html_e( 'Looks like the page you are looking for has been moved or does not exist. Click on the site logo to go to the homepage or try searching.', 'counter' ); ?></p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'counter' ); ?></p>

			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
