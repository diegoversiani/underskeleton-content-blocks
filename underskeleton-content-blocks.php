<?php
/*
Plugin Name: Underskeleton Content Blocks
Description: Create blocks of content you can display anywhere in your site using shortcodes. Use them to create many different sections in one page and show a clickable index of the sections.
Plugin URI: http://getunderskeleton.com/plugins/content-blocks
Author: Diego Versiani
Author URI: http://diegoversiani.me
Version: 1.0
License: GPL2
Text Domain: underskeleton_ctb
Domain Path: /languages
*/

/*

    Copyright (C) 2017 Diego Versiani diegoversiani@gmail.com

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

/**
 * Load plugin functions file
 */
require plugin_dir_path( __FILE__ ) . '/plugin-functions.php';

/**
 * Load custom post types
 */
require plugin_dir_path( __FILE__ ) . '/inc/custom-post-types/custom-post-type-content-block.php';

/**
 * Load shortcodes
 */
require plugin_dir_path( __FILE__ ) . '/inc/shortcodes/shortcode-content-block-index.php';
require plugin_dir_path( __FILE__ ) . '/inc/shortcodes/shortcode-content-block.php';
