<?php
/**
 * Counter Theme Customizer Custom Sections
 *
 * @package Counter
 */

/**
 * Frontpage Visibility Section Class.
 *
 * @see WP_Customize_Section
 */
class Counter_Frontpage_Visibility_Section extends WP_Customize_Section {

	/**
	 * Section type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'frontpage-visibility';

	/**
	 * Render the section, and the controls that have been added to it.
	 *
	 * @access protected
	 */
	protected function render() {
		?>
		<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="accordion-section-frontpage-visibility">
			<ul class="frontpage-visibility-section-content"></ul>
		</li>
		<?php
	}
}
