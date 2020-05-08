# Izzle Translation Lib

> Simple Translation Lib

## Installation

> Using npm:
 ```shell
 $ composer require izzle/translation
 ```

## Usage

```php
use Izzle\Translation\Services\Translation;

// Init and load translation file
Translation::load('paht_to_file.json');

// Translate
// Ex. { "global": { "hello": "Hello {0}" } }"
echo Translation::translate('global.hello', ['World']);
```

### Output
```
Hello World
```

## License

Copyright (c) 2020-present Izzle

[MIT License](http://en.wikipedia.org/wiki/MIT_License)
