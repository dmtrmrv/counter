<?php
/**
 * The template used for displaying panels on the front page
 *
 * @package Counter
 */

?>

<article id="panel-<?php echo esc_attr( $counter_panel_num ); ?>" <?php post_class( 'panel ' . esc_attr( $counter_panel_class ) ); ?>>

	<?php counter_panel_thumbnail(); ?>

	<div class="wrap">

		<div class="panel-data">

			<?php the_title( '<h2 class="panel-title">', '</h2>' ); ?>

			<?php counter_panel_content(); ?>

		</div>

	</div>

	<?php counter_panel_meta( $counter_panel_num, get_theme_mod( 'panel_content_' . $counter_panel_num ) ); ?>

	<div class="panel-background" <?php counter_panel_background( $counter_panel_num ); ?>></div>

</article><!-- #post-## -->
