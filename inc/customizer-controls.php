<?php
/**
 * Counter Theme Customizer Custom Controls
 *
 * @package Counter
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Displays custom message with a call to action link.
 */
class Counter_Panel_Number_Control extends WP_Customize_Control {

	/**
	 * Button attributes.
	 *
	 * @access public
	 * @var array
	 */
	public $button_attrs = array();

	/**
	 * Render the custom attributes for the control's link element.
	 *
	 * Codesniffer picks the $attr as an XSS issue. Even though the core
	 * input_attrs() don't escape it, I guess wrapping it with esc_attr()
	 * won't hurt.
	 *
	 * @since 4.0.0
	 * @access public
	 */
	public function button_attrs() {
		foreach ( $this->button_attrs as $attr => $value ) {
			echo esc_attr( $attr ) . '="' . esc_attr( $value ) . '" ';
		}
	}

	/**
	 * Render the content.
	 */
	public function render_content() {

		// Title.
		if ( isset( $this->label ) ) {
			printf(
				'<span class="customize-control-title">%s</span>',
				esc_html( $this->label )
			);
		}

		// Display input and button within a paragraph. ?>
		<p class='customize-control-paragraph'>
			<input <?php $this->input_attrs(); ?> value='<?php echo esc_attr( $this->value() ); ?>' <?php $this->link(); ?> />
			<input <?php $this->button_attrs(); ?> />
		</p> <?php

		// Description.
		if ( isset( $this->description ) ) {
			printf(
				'<p class="customize-control-paragraph">%s</p>',
				wp_kses_post( $this->description )
			);
		}

	}
}

/**
 * Displays custom message with a call to action link.
 */
class Counter_Message_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'message';

	/**
	 * Render the content.
	 */
	public function render_content() {

		// Title.
		if ( isset( $this->label ) ) {
			printf(
				'<span class="customize-control-title">%s</span>',
				esc_html( $this->label )
			);
		}

		// Description.
		if ( isset( $this->description ) ) {
			printf(
				'<p class="customize-control-paragraph">%s</p>',
				wp_kses_post( $this->description )
			);
		}

	}
}

/**
 * Multiple checkbox customize control class.
 *
 * @access public
 */
class Counter_Multicheck_Control extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'multicheck';

	/**
	 * Displays the control content.
	 *
	 * @access public
	 * @return void
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		// Title.
		if ( ! empty( $this->label ) ) {
			printf(
				'<span class="customize-control-title">%s</span>',
				esc_html( $this->label )
			);
		}

		// Description.
		if ( ! empty( $this->description ) ) {
			printf(
				'<p class="customize-control-paragraph">%s</p>',
				wp_kses_post( $this->description )
			);
		}

		$values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

		<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>

				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $values ) ); ?> />
						<?php echo esc_html( $label ); ?>
					</label>
				</li>

			<?php endforeach; ?>
		</ul>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $values ) ); ?>" /> <?php
	}
}

/**
 * Displays divider.
 */
class Counter_Divider_Control extends WP_Customize_Control {

	/**
	 * Render the content.
	 */
	public function render_content() {
		echo '<hr class="customize-control-divider" />';
	}
}
