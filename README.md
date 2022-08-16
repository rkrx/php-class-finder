# PHP class finder

You have to provide a list of file paths in which a php-class is to be searched for. Behind the scenes, [`nikic/php-parser`](https://packagist.org/packages/nikic/php-parser) is used to interpret the files. This means that the PHP files are not interpreted directly. This is much slower, than the approach, that [`haydenpierce/class-finder`](https://packagist.org/packages/haydenpierce/class-finder) is using.

`composer require rkr/class-finder`

## Examples

### `ClassFinder::findClassesFromDirectory`

```php
use Kir\ClassFinder\ClassFinder;

$startDir = __DIR__ . '/src';
$classNames = ClassFinder::findClassesFromDirectory($startDir);

print_r(iterator_to_array($classNames));
// Kir\ClassFinder\NodeVisitor
// Kir\ClassFinder\ClassFinder
// Kir\ClassFinder\ClassTools
// Kir\ClassFinder\ClassFinderResult
// Kir\ClassFinder\ClassFile
```

### `ClassFinder::findClassesFromIterableFileList`

```php
use Kir\ClassFinder\ClassFinder;

//region Gather the files
$startDir = __DIR__ . '/src';
$directory = new RecursiveDirectoryIterator($startDir, FilesystemIterator::FOLLOW_SYMLINKS | FilesystemIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_PATHNAME);
$iterator = new RecursiveIteratorIterator($directory);
$files = new CallbackFilterIterator($iterator, fn(string $path) => preg_match('{\\.p(hp\\d?|html)$}i', $path));
//endregion

$classNames = ClassFinder::findClassesFromIterableFileList($files);

print_r(iterator_to_array($classNames));
// Kir\ClassFinder\NodeVisitor
// Kir\ClassFinder\ClassFinder
// Kir\ClassFinder\ClassTools
// Kir\ClassFinder\ClassFinderResult
// Kir\ClassFinder\ClassFile
```
