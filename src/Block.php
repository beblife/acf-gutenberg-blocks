<?php

namespace GutenbergBlocks;

use WordPlate\Acf\Location;

abstract class Block
{
    protected $name;

    protected $title;

    protected $description;

    protected $keywords = [];

    protected $category;

    protected $icon;

    protected $mode = 'preview';

    protected $default_align = '';

    protected $align = ['wide', 'full'];

    protected $allow_mode_switch = true;

    protected $allow_multiple = true;

    abstract public function render();

    public function fields()
    {
        return [];
    }

    public function get($key, $default = null)
    {
        return get_field($key) ?: $default;
    }

    public function data()
    {
        return get_fields();
    }

    public function location()
    {
        return [
            Location::if('block', 'acf/' . $this->name),
        ];
    }

    protected function register_fields()
    {
        register_extended_field_group([
            'title' => $this->title,
            'key' => 'field_group_block_' . $this->name,
            'location' => $this->location(),
            'fields' => $this->fields(),
        ]);
    }

    protected function register_block()
    {
        acf_register_block_type([
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'category' => $this->category,
            'icon' => $this->icon,
            'align' => $this->default_align,
            'mode' => $this->mode,
            'supports' => [
                'align' => $this->align,
                'mode' => $this->allow_mode_switch,
                'multiple' => $this->allow_multiple,
            ],
            'render_callback' => function ($block) {
                echo '<div class="'. $this->classes($block) .'">';
                echo $this->render();
                echo '</div>';
            },
        ]);
    }

    protected function classes($block)
    {
        return trim(implode(' ', [
            'wp-blocks-block',
            'wp-block-' .$this->name,
            $block['className'] ?: '',
            $block['align'] ? 'align' . $block['align'] : '',
        ]));
    }

    private function register()
    {
        $this->register_block();
        $this->register_fields();
    }

    public function __destruct()
    {
        $this->register();
    }
}
