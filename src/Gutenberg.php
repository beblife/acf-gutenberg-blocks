<?php

namespace GutenbergBlocks;

class Gutenberg
{
    public static function register($blocksOrPath)
    {
        $blocks = [];

        if (is_array($blocksOrPath)) {
            $blocks = $blocksOrPath;
        }

        if (is_string($blocksOrPath)) {
            $blocksDir = trailingslashit(get_stylesheet_directory());
            $blocksDir = trailingslashit($blocksDir . $blocksOrPath);

            foreach (glob($blocksDir . '*.php') as $file) {
                require_once $file;

                if (class_exists($class = basename($file, '.php'))) {
                    $blocks[] = $class;
                }
            }
        }

        foreach ($blocks as $block) {
            new $block();
        }
    }
}
