<?php
/**
 * The template used for displaying fullwidth panels on the front page
 *
 * @package Counter
 */

?>
<article id="panel-<?php echo esc_attr( $counter_panel_num ); ?>" <?php post_class( 'panel panel-fullwidth ' . counter_panel_alignment_class( $counter_panel_num ) ); ?> >
	<div class="wrap">
		<div class="panel-data">
			<?php counter_panel_title( $counter_panel_num ); ?>

			<?php counter_panel_content( $counter_panel_num ); ?>

		</div>
	</div>

	<?php counter_panel_meta( $counter_panel_num, get_theme_mod( 'panel_content_' . $counter_panel_num ) ); ?>

	<div class="panel-background" <?php counter_panel_background_image( $counter_panel_num ); ?>></div>

</article><!-- #post-## -->
