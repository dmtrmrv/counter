<?php
/**
 * The template used for displaying split panels with images on the right
 *
 * @package Counter
 */

?>
<article id="panel-<?php echo esc_attr( $counter_panel_num ); ?>" <?php post_class( 'panel panel-right ' . counter_panel_alignment_class( $counter_panel_num ) ); ?>>
	<?php counter_panel_thumbnail(); ?>

	<div class="panel-data">
		<?php counter_panel_title( $counter_panel_num ); ?>

		<?php counter_panel_content( $counter_panel_num ); ?>
	</div>

	<?php counter_panel_meta( $counter_panel_num, get_theme_mod( 'panel_content_' . $counter_panel_num ) ); ?>

	<div class="panel-background" <?php counter_panel_background_image( $counter_panel_num ); ?>></div>

</article><!-- #post-## -->
