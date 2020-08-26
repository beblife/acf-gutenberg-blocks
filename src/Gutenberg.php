<?php

namespace GutenbergBlocks;

class Gutenberg
{
    public static function register($blocks)
    {
        foreach ($blocks as $block) {
            new $block();
        }
    }
}
