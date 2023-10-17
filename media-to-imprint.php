<?php
/*
Plugin Name: FCP Media to Imprint
Description: It adds the "Source" field to the media items, and once filled it is printed via <code>[fcp-media-to-imprint]</code> shortcode, which gotta be pasted to the Imprint page.
Version: 0.0.1
Requires at least: 5.8
Tested up to: 6.3
Requires PHP: 7.4
Author: Firmcatalyst, Vadim Volkov, Aude Jamier, Melanie Nickl
Author URI: https://firmcatalyst.com/about/
License: GPL v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


defined( 'ABSPATH' ) || exit;


define( 'FCMTI_DEV', false );
define( 'FCMTI_VER', get_file_data( __FILE__, [ 'ver' => 'Version' ] )[ 'ver' ] . ( FCMTI_DEV ? time() : '' ) );

define( 'FCMTI_URL', plugin_dir_url( __FILE__ ) );
define( 'FCMTI_DIR', plugin_dir_path( __FILE__ ) );


require FCMTI_DIR . 'inc/admin-fields.php';
require FCMTI_DIR . 'inc/shortcode.php';