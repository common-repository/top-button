<?php
/*
Plugin Name: Top But(ton)
Description: Show responsive button scroll top on site
Version: 1.0
Author: Andrew Smerdov
Author URI: https://vodrems.github.io
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

wp_register_style( 'vs-top_btn', plugins_url( 'assets/styles/main.css', __FILE__ )  );
wp_enqueue_style( 'vs-top_btn' );

add_action( 'wp_footer', 'vs_top_btn' );

// Default Values

$options = get_option('vs_set');

if ($options['vs_set_color_id'] === NULL) {
	$options['vs_set_color_id'] = 'blue';
	update_option('vs_set', $options);
}

if ($options['vs_set_scroll_distance'] === NULL) {
	$options['vs_set_scroll_distance'] = 200;
	update_option('vs_set', $options);
}

function vs_top_btn() {

	$options = get_option('vs_set');

	echo '<div class="top_but top_but--'.$options['vs_set_color_id'].'"></div>';

	wp_register_script( 'vs-top_btn-script', plugins_url( 'assets/js/main.js', __FILE__ ), array('jquery') );
	wp_enqueue_script( 'vs-top_btn-script' );


	wp_localize_script('vs-top_btn-script', 'vs_top_but', array('scroll_distance' => $options['vs_set_scroll_distance']));
}

// Page of settings

add_action( 'admin_menu', 'vs_option_page' );
add_action( 'admin_init', 'vs_settings' );

function vs_option_page() {
	add_options_page( 'Top But(ton)', 'Top_But(ton)', 'manage_options', 'vs_top_but', 'vs_top_but_cb' );
}

function vs_settings() {
	register_setting( 'vs_set_group', 'vs_set' );

	add_settings_section( 'vs_set_section_id', '', '', __FILE__ );

	add_settings_field( 'vs_set_color_id', 'Color sheme', 'vs_set_color_cb', __FILE__, 'vs_set_section_id', array('label_for' => 'vs_set_color_id') );
	add_settings_field( 'vs_set_scroll_distance_id', 'Scroll Distance', 'vs_set_scroll_distance_cb', __FILE__, 'vs_set_section_id', array('label_for' => 'vs_set_scroll_distance_id') );

}

function vs_top_but_cb() {
?>
<div class="wrap">
	<h2>Top_but(ton) Options</h2>
	<form action="options.php" method="post">
		<?php settings_fields( 'vs_set_group' ); ?>
		<?php do_settings_sections( __FILE__ ); ?>
		<?php submit_button(); ?>
	</form>
</div>
<?
}

function vs_set_color_cb() {
	$options = get_option('vs_set');
	$colorsValues = ['red' => 'Red', 'blue' => 'Blue', 'green' => 'Green', 'pure' => 'Pure'];
	?>
    <select id='vs_set_color_id' class='post_form' name="vs_set[vs_set_color_id]">
		<?php
		foreach ($colorsValues as $key => $value) {
			$checked = ($key == $options['vs_set_color_id']) ? 'selected' : '';
			echo '<option value="'.$key.'" '.$checked.'>'.$value.'</option>';
		}
		?>
    </select>
<?
}

function vs_set_scroll_distance_cb() {
	$options = get_option('vs_set');
	$currentValue = $options['vs_set_scroll_distance'];
	if ($currentValue === NULL) {
		$options['vs_set_scroll_distance'] = 200;
		update_option('vs_set', $options);
    }
?>
    <input type="number" name="vs_set[vs_set_scroll_distance]" id="vs_set_scroll_distance_id" class="regular-text" value="<?=$options['vs_set_scroll_distance']?>">
    <p class="description">Distance from top in pixels for show element. Default value "200".</p>
<?
}


?>