<?php
/*
Plugin Name: Underskeleton Content Blocks
Description: Create reusable content blocks you can display anywhere in your site using shortcodes. Build a page or post with different sections, re-use each block separatelly in other pages and posts.
Plugin URI: http://getunderskeleton.com/plugins/content-blocks
Author: Diego Versiani
Author URI: http://diegoversiani.me
Version: 1.0.0
License: GPL2
Text Domain: underskeleton_ctb
Domain Path: /languages

Copyright (C) 2017 Underskeleton Content Blocks

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}



define( 'UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_URL', plugin_dir_url(__FILE__) );
define( 'UNDERSKELETON_CONTENT_BLOCKS_THEME_TEMPLATES_FOLDER', 'plugins/underskeleton-content-blocks/templates/' );
define( 'UNDERSKELETON_CONTENT_BLOCKS_TEMPLATES_FOLDER',  UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_PATH . 'templates/' );



/**
 * Load classes
 */
require plugin_dir_path( __FILE__ ) . '/inc/classes/class.underskeleton-content-blocks.php';

/**
 * Load plugin functions file
 */
require plugin_dir_path( __FILE__ ) . '/plugin-functions.php';

/**
 * Load plugin register scripts and styles
 */
require plugin_dir_path( __FILE__ ) . '/inc/enqueue.php';

/**
 * Load custom post types
 */
require plugin_dir_path( __FILE__ ) . '/inc/custom-post-types/custom-post-type-content-block.php';

/**
 * Load shortcodes
 */
require plugin_dir_path( __FILE__ ) . '/inc/shortcodes/shortcode-content-block.php';

/**
 * Load register templates
 */
require plugin_dir_path( __FILE__ ) . '/inc/shortcodes/content-block/register-template-custom.php';
