<?php
/*
Plugin Name: SubSolar Alona Shortcodes
Description: A shortcodes plugin for Alona theme. Requires Twitter Bootstrap.
Version: 1.0
Author: SubSolar Designs
Author URI: http://www.subsolardesigns.com
*/

add_action( 'wp_enqueue_scripts', 'sdesigns_load_jquery_script' );

if (!function_exists('sdesigns_load_jquery_script')) {
	function sdesigns_load_jquery_script() {

		wp_register_script( 'custom-plugin', plugin_dir_url( __FILE__ ) . 'js/custom.js', 'jquery', '1.0', true );
		wp_enqueue_script('custom-plugin');

	}
}

add_action( 'init', 'sdesigns_load_shortcodes' );

if (!function_exists('sdesigns_load_shortcodes')) {
	function sdesigns_load_shortcodes() {

		require_once( plugin_dir_path( __FILE__ ) .'shortcodes.php' );
	}
}

if (!function_exists('sdesigns_attribute_map')) {
	function sdesigns_attribute_map($str, $att = null) {
		$res = array();
		$return = array();
		$reg = get_shortcode_regex();
		preg_match_all('~'.$reg.'~',$str, $matches);
		foreach($matches[2] as $key => $name) {
			$parsed = shortcode_parse_atts($matches[3][$key]);
			$parsed = is_array($parsed) ? $parsed : array();

			$res[$name] = $parsed;
			$return[] = $res;
		}
		return $return;
	}

}


?>