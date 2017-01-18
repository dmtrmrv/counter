<?php
/**
 * The template used for displaying panels with featured image on the left
 *
 * @package Counter
 */

?>
<article id="panel-<?php echo esc_attr( $counter_panel_num ); ?>" <?php post_class( 'panel panel-left' . $counter_panel_has_background ); ?>>
	<?php counter_panel_thumbnail(); ?>

	<div class="panel-data">
		<?php the_title( '<h2 class="panel-title">', '</h2>' ); ?>

		<?php counter_panel_content(); ?>
	</div>

	<?php counter_panel_meta( $counter_panel_num, get_theme_mod( 'panel_content_' . $counter_panel_num ) ); ?>

	<div class="panel-background" <?php counter_panel_background( $counter_panel_num ); ?>></div>

</article><!-- #post-## -->
