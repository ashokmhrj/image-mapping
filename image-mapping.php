<?php
/*
Plugin Name: Image Mapping
Plugin URI: 
Description: Able map the image and give the mapped area with link to another page or website.
Version: 1.0
Author: ashokmhrj
Author URI: 
License: GPLv2 or later
Text Domain: image-mapping
*/

/*Make sure we don't expose any info if called directly*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

/*Define Constants for this plugin*/
define( 'IMAGE_MAP_VERSION', '1.0' );
define( 'IMAGE_MAP_PATH', plugin_dir_path( __FILE__ ) );
define( 'IMAGE_MAP_URL', plugin_dir_url( __FILE__ ) );

/*Now lets init the custom post type of this plugin*/ 
require_once( IMAGE_MAP_PATH."/inc/register_cpt.php" );
// backend
require_once( IMAGE_MAP_PATH."/inc/add_image_upload.php" );
// front end
require_once( IMAGE_MAP_PATH."/front.php" );