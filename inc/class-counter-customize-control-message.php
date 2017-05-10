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
class Counter_Customize_Control_Message extends WP_Customize_Control {

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
	 * Link class.
	 *
	 * @access public
	 * @var string
	 */
	public $link_class = '';

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
				'<p class="customize-control-paragraph"><a href="%1$s" target="_blank" class="%3$s">%2$s</a></p>',
				esc_url( $this->link_url ),
				esc_html( $this->link_text ),
				esc_attr( $this->link_class )
			);
		}
	}
}
