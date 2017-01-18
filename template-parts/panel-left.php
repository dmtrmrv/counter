<?php
/**
 * The template used for displaying panels with featured image on the left
 *
 * @package Counter
 */

?>
<article id="panel-<?php echo esc_attr( $counter_panel_num ); ?>" <?php post_class( 'panel panel-left ' ); ?>>
	<?php counter_panel_thumbnail(); ?>

	<div class="panel-data">
		<?php counter_panel_title( $counter_panel_num ); ?>

		<?php counter_panel_content( $counter_panel_num ); ?>
	</div>

	<?php counter_panel_meta( $counter_panel_num, get_theme_mod( 'panel_content_' . $counter_panel_num ) ); ?>

	<div class="panel-background" <?php counter_panel_background( $counter_panel_num ); ?>></div>

</article><!-- #post-## -->
