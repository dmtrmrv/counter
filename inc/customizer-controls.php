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
class Counter_Message_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'message';

	/**
	 * Link URL.
	 *
	 * @access public
	 * @var string
	 */
	public $link_url = '';

	/**
	 * Link text.
	 *
	 * @access public
	 * @var string
	 */
	public $link_text = '';

	/**
	 * Render the content.
	 */
	public function render_content() {

		// Title.
		if ( $this->label ) {
			printf(
				'<span class="customize-control-title">%s</span>',
				esc_html( $this->label )
			);
		}

		// Description.
		if ( $this->description ) {
			printf(
				'<p class="customize-control-paragraph">%s</p>',
				esc_html( $this->description )
			);
		}

		// Link.
		if ( $this->link_url && $this->link_text ) {
			printf(
				'<p class="customize-control-paragraph"><a href="%1$s" target="_blank" class="button button-secondary">%2$s</a></p>',
				esc_html( $this->link_url ),
				esc_html( $this->link_text )
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
