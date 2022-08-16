# PHP class finder

You have to provide a list of file paths in which a php-class is to be searched for. Behind the scenes, [https://packagist.org/packages/nikic/php-parser](`nikic/php-parser`) is used to interpret the files. This means that the PHP files are not interpreted directly. This is much slower, than the approach, that [https://packagist.org/packages/haydenpierce/class-finder](`haydenpierce/class-finder`) is using.

`composer require rkr/class-finder`

## Example

```php
use Kir\ClassFinder\ClassFinder;

$startDir = __DIR__ . '/src';
$classNames = ClassFinder::findClassesFromDirectory($startDir);

print_r($classNames);
// Kir\ClassFinder\NodeVisitor
// Kir\ClassFinder\ClassFinder
```

```php
use Kir\ClassFinder\ClassFinder;

//region Gather the files
$startDir = __DIR__ . '/src';
$directory = new RecursiveDirectoryIterator($startDir, FilesystemIterator::FOLLOW_SYMLINKS | FilesystemIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_PATHNAME);
$iterator = new RecursiveIteratorIterator($directory);
$files = new CallbackFilterIterator($iterator, fn(string $path) => preg_match('{\\.p(hp\\d?|html)$}i', $path));
//endregion
		
$classNames = ClassFinder::findClassesFromIterableFileList($files);

print_r($classNames);
// Kir\ClassFinder\NodeVisitor
// Kir\ClassFinder\ClassFinder
```

## MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
