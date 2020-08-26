<?php
/**
 * Plugin Name: ACF Gutenberg Blocks
 * Description: Provides an elegant way for developers to register Gutenberg blocks using the Advanced Custom Fields PRO blocks feature.
 * Version: 1.0.0
 * Author: Laurens Bultynck
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require "vendor/autoload.php";

add_action('acf/init', function () {
    $blocks = apply_filters('acf_gutenberg_blocks', []);

    \GutenbergBlocks\Gutenberg::register($blocks);
});
