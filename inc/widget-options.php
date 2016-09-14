<?php
/**
 * Adds a checkbox to a widget screen.
 *
 * If the checkbox is checked, the class .widget-center is added to a widget.
 *
 * @package Owner
 */

/**
 * Adds checkbox to all widgets.
 *
 * @param  object $widget   The widget instance, passed by reference.
 * @param  null   $return   Null if new fields are added.
 * @param  array  $instance Array of the widget’s settings.
 */
function owner_widget_align_form( $widget, $return, $instance ) {
	$id    = $widget->get_field_id( 'align' );
	$value = isset( $instance['align'] ) ? owner_widget_align_sanitize( $instance['align'] ) : 'left';
	$name  = $widget->get_field_name( 'align' );
	?>
		<p>
			<label for='<?php echo esc_attr( $id ); ?>'>
				<?php esc_html_e( 'Text Alignment', 'owner' ); ?>
			</label>
			<select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" style="width: 100%;">
				<option value="left" <?php selected( $value, 'left' );?>><?php echo esc_html_x( 'Left', 'Text Alignment', 'owner' ); ?></option>
				<option value="center" <?php selected( $value, 'center' );?>><?php echo esc_html_x( 'Center', 'Text Alignment', 'owner' ); ?></option>
				<option value="right" <?php selected( $value, 'right' );?>><?php echo esc_html_x( 'Right', 'Text Alignment', 'owner' ); ?></option>
			</select>
		</p>
	<?php
}
add_action( 'in_widget_form', 'owner_widget_align_form', 5, 3 );

/**
 * Filter widget settings before saving.
 *
 * @param  array $instance     The current widget instance's settings.
 * @param  array $new_instance Array of new widget settings.
 * @return array               Filtered array of new widget settings.
 */
function owner_widget_align_update( $instance, $new_instance ) {
	if ( ! empty( $new_instance['align'] ) ) {
		$new_instance['align'] = owner_widget_align_sanitize( $new_instance['align'] );
	} else {
		$new_instance['align'] = 'left';
	}
	return $new_instance;
}
add_filter( 'widget_update_callback', 'owner_widget_align_update', 5, 3 );

/**
 * Filter the parameters passed to a widget’s display callback.
 *
 * @param  array $params Widget parameters.
 * @return array         Filtered widget parameters.
 */
function owner_widget_align_class( $params ) {
	// All registered widgets.
	global $wp_registered_widgets;

	// Widget id.
	$id  = $params[0]['widget_id'];

	// Widget number.
	$num = $params[1]['number'];

	// Current widget object.
	$widget = $wp_registered_widgets[ $id ];

	// Database entry that holds data of all widgets of current widget type.
	$option = get_option( $widget['callback'][0]->option_name );

	// Check if alignment is defined.
	if ( isset( $option[ $num ]['align'] ) ) {
		// Create a class literal.
		$align_class = sprintf( 'widget-%s ', owner_widget_align_sanitize( $option[ $num ]['align'] ) );

		// Add the class to the widget.
		$params[0]['before_widget'] = preg_replace(
			'/class="/',
			'class="' . esc_attr( $align_class ),
			$params[0]['before_widget'],
			1
		);
	}

	return $params;
}
add_filter( 'dynamic_sidebar_params', 'owner_widget_align_class' );

/**
 * Sanitizes text alignment options
 *
 * @param  string $input String with a potentially harmful data.
 * @return string        Safe to output string.
 */
function owner_widget_align_sanitize( $input ) {
	$output = 'left';
	if ( 'center' == $input || 'right' == $input ) {
		$output = $input;
	}
	return $output;
}
