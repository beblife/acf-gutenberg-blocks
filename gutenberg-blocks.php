<?php
/**
 * Plugin Name: ACF Gutenberg Blocks
 * Description: A plugin that provides an elegant way to register Gutenberg blocks using ACF PRO.
 * Version: 1.0
 * Author: Laurens Bultynck
 */

require "vendor/autoload.php";

add_action('acf/init', function () {
    $blocks = apply_filters('acf_gutenberg_blocks', []);

    \GutenbergBlocks\Gutenberg::register($blocks);
});
