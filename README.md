# ACF Gutenberg blocks

An elegant way for developers to register Gutenberg blocks using the Advanced Custom Fields PRO features.

* [Installation](#installation)
* [Define blocks](#define-blocks)
* [Register blocks](#register-blocks)
* [Configure fields](#configure-fields)
* [Retrieve data](#retrieve-data)
* [Define classes](#define-classes)
* [Render blocks](#render-blocks)


## Installation

You can install this package through composer:

```sh
composer require beblife/acf-gutenberg-blocks
```

## Define blocks
You can define custom blocks by creating classes that extend the base block class provided by this package.

By extending from the base block enables you to easily define custom blocks with a minimum of configuration:

```php
use GutenbergBlocks\Block;

class MyCustomBlock extends Block
{
    protected $name = "custom";

    protected $title = "My Custom block";

    protected $description = "This is a custom block!";

    public function render()
    {
        // Render the HTML
    }
}
```

The base block class configures a few things by default behind the scence for convenience but can be changed easily. The following properties are defined out of the box:

```php
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
```

## Register blocks

To enable the custom blocks you need to register them by hooking into the `acf/init` filter. This allows for a flexible way to define which blocks should be enabled.

You can enable blocks by passing an array with classes:
```php
add_filter('acf/init', function () {
    \GutenbergBlocks\Gutenberg::register([
        MyCustomBlock::class,
    ]);
});
```
To automatically register all blocks in a directory can provide the relative path in the current theme:
```php
add_filter('acf/init', function () {
    // Registers all blocks in `wp-content/themes/{current_theme}/blocks`
    \GutenbergBlocks\Gutenberg::register('blocks');
});
```

> It's important to note that subdirectories of the provided directory will not be registered!

## Configure fields

Fields can be added to a custom block by defining a `fields()` method on the class and make it return an array of fields to add.

This package includes [wordplate/extended-acf](https://github.com/wordplate/extended-acf) to define fields for a block in an easy and elegant way. Make sure to read the documentation to see which field types are available.

Below you can find an example of how you can define fields using this package:

```php
public function fields()
{
    return [
        Text::make('Title')
            ->required(),

        Text::make('Body'),

        Url::make('Link', 'url')
            ->required()
            ->instructions('The url that should be displayed.'),
    ];
}
```

## Retrieve data

To retrieve the data from the defined fields you have a few options.

```php
// Retrieve all fields as an array
$data = $this->data();

// Retrieve only the title
$title = $this->get('title');

// Retrieve the body and provide a default value as fallback
$body = $this->get('body', 'Hello world!');

// ...
```

## Define classes

By default a few classes are added to the wrapper HTML-element to be able to add general styles and specific styles for blocks and respect the alignment and other input from the Gutenberg editor.

You can override or extend the classes that are added by defining your own `classes` method:

```php
// Override the default classes
protected function classes($block)
{
    return 'my-custom-css-class';
}

// Extend the default classes
protected function classes($block)
{
    $classes = parent::classes($block);

    $classes .= ' my-custom-css-class';

    return $classes;
}
```

> Please note that when overriding the default classes some Gutenberg behaviour will no longer work and will have to be added from the `$block` parameter to prevent this from happening!

## Render blocks

All blocks require a `render()` method to be implemented. The way you render a block is up to you, an example with  Wordpress' `get_template_part()` is given below:

```php
public function render()
{
    // Make the data available in our template
    set_query_var('data', $this->data());

    return get_template_part('path-to-my-block-template');
}
```

## License

[MIT](LICENSE) © [Laurens Bultynck](https://laurensbultynck.me/)
