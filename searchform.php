<?php
/**
 * The template for displaying the searchform
 *
 * Since the theme uses dynamic colors it is beter to utilize the color classes
 * instead of generating many inline CSS rules to color the button.
 *
 * @package Counter
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'counter' ) ?></span>
		<input type="search" class="search-field"
			placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'counter' ) ?>"
			value="<?php echo get_search_query() ?>" name="s"
			title="<?php echo esc_attr_x( 'Search for:', 'label', 'counter' ) ?>" />
	</label>
	<input type="submit" class="search-submit btn btn-accent"
		value="<?php echo esc_attr_x( 'Search', 'submit button', 'counter' ) ?>" />
</form>
