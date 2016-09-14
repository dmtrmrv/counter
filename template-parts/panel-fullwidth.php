<?php
/**
 * The template used for displaying fullwidth panels on the front page
 *
 * @package Owner
 */

?>
<article id="panel-<?php echo esc_attr( $owner_panel_num ); ?>" <?php post_class( 'panel panel-fullwidth ' . owner_panel_alignment_class( $owner_panel_num ) ); ?> >
	<div class="wrap">
		<div class="panel-data">
			<?php owner_panel_title( $owner_panel_num ); ?>

			<?php owner_panel_content( $owner_panel_num ); ?>

		</div>
	</div>

	<?php owner_panel_meta( $owner_panel_num, get_theme_mod( 'panel_content_' . $owner_panel_num ) ); ?>

	<div class="panel-background" <?php owner_panel_background_image( $owner_panel_num ); ?>></div>

</article><!-- #post-## -->
