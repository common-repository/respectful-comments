<?php
/*
Plugin Name: Respectful Comments
Plugin URI: http://info.org.il/respect
Description: The Respectful Comments plugin replaces the text on the comments submit button.
Version: 0.41
Author: Elad Salomons
Author URI: http://elad.blogli.co.il
License: GPL2
*/

add_filter('comment_form_defaults', 'my_comment_form_defaults_filter', $defaults);
add_action('admin_menu', 'respectful_comments_menu');
add_action('admin_init', 'register_respectful_comments_settings');
add_action('wp_loaded', 'rc_options_setup');

function my_comment_form_defaults_filter($defaults)
{
	$options = get_option('comments_button_text');
	$defaults['label_submit'] = $options['rc_comments_button_text'];//__('My comment respects the blog and its readers', 'respectfulcomments');
	return $defaults;
}

function respectful_comments_menu() {
	add_options_page(__('Respectful Comments Options', 'respectful-comments'), __('Respectful Comments', 'respectful-comments'), 'manage_options', 'respectful_comments-identifier', 'respectful_comments_options');
}

function respectful_comments_options() {
?>
	<div>
	<h2><?php _e('Respectful Comments Options','respectful-comments'); ?></h2>
	<?php _e('The Respectful Comments plugin replaces the text on the comments submit button.','respectful-comments'); ?>
	<form action="options.php" method="post">
	<?php settings_fields('rc_settings_group'); ?>
	<?php do_settings_sections('rc_plugin'); ?>
	
	<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form></div>
<?php

}

function register_respectful_comments_settings() {
	register_setting( 'rc_settings_group', 'comments_button_text' );
	add_settings_section('rc_plugin_main', '', 'rc_plugin_section_text', 'rc_plugin');
	add_settings_field('rc_comments_button_text', __('Comments submit button text', 'respectful-comments'), 'rc_plugin_setting_string', 'rc_plugin', 'rc_plugin_main');
}

function rc_plugin_section_text() {
//echo '<p>Main description of this section here.</p>';
}

function rc_plugin_setting_string() {
$options = get_option('comments_button_text');
echo "<input id='plugin_text_string' name='comments_button_text[rc_comments_button_text]' size='80' type='text' value='{$options['rc_comments_button_text']}' />";
}

function rc_options_setup() {
	$def_options = array('rc_comments_button_text' => __('My comment respects the blog and its readers', 'respectful-comments'));
	$options = get_option('comments_button_text');
	if (!$options) {
		update_option( 'comments_button_text', $def_options);
	}
}

load_plugin_textdomain('respectful-comments', false, basename( dirname( __FILE__ ) ) . '/languages/' );

?>