# TheFramework Helpers

[![Latest Stable Version](https://poser.pugx.org/theframework/helpers/v/stable)](https://packagist.org/packages/theframework/helpers)
[![Total Downloads](https://poser.pugx.org/theframework/helpers/downloads)](https://packagist.org/packages/theframework/helpers)
[![License](https://poser.pugx.org/theframework/helpers/license)](https://packagist.org/packages/theframework/helpers)
[![PHP Version Require](https://poser.pugx.org/theframework/helpers/require/php)](https://packagist.org/packages/theframework/helpers)

PHP library for creating HTML elements using Object-Oriented Programming. Build forms, tables, buttons, scripts and more with a clean, fluent API.

## Features

- Object-oriented HTML element generation
- Form helpers (Input, Select, Textarea, Radio, Checkbox)
- Table helpers with thead/tbody/tfoot support
- Script and Link tag helpers
- Button helpers
- Fluent interface for chaining methods
- PSR-4 autoloading
- PHP 8.1+ with strict typing

## Requirements

- PHP 8.1 or higher

## Installation

Install via Composer:

```bash
composer require theframework/helpers
```

## Quick Start

```php
<?php

require_once 'vendor/autoload.php';

use TheFramework\Helpers\Form\Input\Text;
use TheFramework\Helpers\Html\Button;
use TheFramework\Helpers\Form\Select;

// Create a text input
$input = new Text(
    id: 'username',
    name: 'username',
    value: '',
    placeholder: 'Enter your username'
);
$input->setRequired();
$input->addClass('form-control');
echo $input->getHtml();

// Create a button
$button = new Button(
    innerHtml: 'Submit',
    type: 'submit',
    id: 'btn-submit'
);
$button->addClass('btn btn-primary');
echo $button->getHtml();

// Create a select dropdown
$options = [
    '' => 'Select an option',
    '1' => 'Option 1',
    '2' => 'Option 2',
    '3' => 'Option 3'
];
$select = new Select(
    options: $options,
    id: 'my-select',
    name: 'my_select'
);
echo $select->getHtml();
```

## Available Helpers

### Form Elements
- `Form\Input\Text` - Text input fields
- `Form\Input\Radio` - Radio button groups
- `Form\Select` - Dropdown select boxes
- `Form\Textarea` - Text areas
- `Form\Label` - Form labels

### HTML Elements
- `Html\Button` - Button elements
- `Html\Link` - CSS link tags
- `Html\Script` - JavaScript script tags
- `Html\Table\Table` - HTML tables with thead/tbody/tfoot

### Enums
The library includes several enum classes for type-safe HTML attribute values:
- `Enums\HtmlTypeEnum` - HTML tag names
- `Enums\InputTypeEnum` - Input type attributes
- `Enums\ButtonTypeEnum` - Button type attributes
- `Enums\HtmlAttrEnum` - Common HTML attributes

## Documentation

For detailed examples, see [EXAMPLES.md](theframework/helpers/EXAMPLES.md).

## Testing

```bash
composer test
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

**Eduardo Acevedo Farje**
- Website: [eduardoaf.com](https://eduardoaf.com)
- GitHub: [@eacevedof](https://github.com/eacevedof)
