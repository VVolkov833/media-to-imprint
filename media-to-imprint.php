<?php
/*
Plugin Name: Media to Imprint
Description: This plugin enables you to store media source information within the media meta field. Simply add the shortcode <code>[media_sources_list]</code> to your Imprint page to display all the source values in one list.
Version: 1.0.0
Requires at least: 5.8
Tested up to: 6.3
Requires PHP: 7.4
Author: Firmcatalyst: Vadim Volkov, Melanie Nickl, Aude Jamier
Author URI: https://firmcatalyst.com/about/
License: GPL v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


defined( 'ABSPATH' ) || exit;

define( 'FCMTI_DIR', plugin_dir_path( __FILE__ ) );

require FCMTI_DIR . 'inc/admin-fields.php';
require FCMTI_DIR . 'inc/shortcode.php';