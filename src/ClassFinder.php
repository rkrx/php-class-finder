<?php

namespace Kir\ClassFinder;

use CallbackFilterIterator;
use FilesystemIterator;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

class ClassFinder {
	/**
	 * @param string $dir
	 * @return string[]
	 */
	public static function findClassesFromDirectory(string $dir): array {
		$flags = FilesystemIterator::FOLLOW_SYMLINKS
		       | FilesystemIterator::SKIP_DOTS
		       | FilesystemIterator::KEY_AS_PATHNAME
		       | FilesystemIterator::CURRENT_AS_PATHNAME;
		
		$directory = new RecursiveDirectoryIterator($dir, $flags);
		$iterator = new RecursiveIteratorIterator($directory);
		$fileIterator = new CallbackFilterIterator($iterator, fn(string $path) => preg_match('{\\.p(hp\\d?|html)$}i', $path));

		$classNames = [];
		
		/** @var iterable<string> $fileIterator */
		foreach($fileIterator as $file) {
			$classNames = [...$classNames, ...self::findFQClassNamesInFile($file)];
		}
		return $classNames;
	}
	
	/**
	 * @param iterable<string> $files
	 * @return string[]
	 */
	public static function findClassesFromIterableFileList(iterable $files) {
		$classNames = [];
		foreach($files as $file) {
			$classNames = [...$classNames, ...self::findFQClassNamesInFile($file)];
		}
		return $classNames;
	}
	
	/**
	 * @param string $file
	 * @return string[]
	 */
	private static function findFQClassNamesInFile(string $file): array {
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
		$contents = file_get_contents($file);
		
		if($contents === false) {
			throw new RuntimeException('Invalid content type');
		}
		
		$ast = $parser->parse($contents);
		
		if($ast === null) {
			throw new RuntimeException('AST must not be null');
		}
		
		$visitor = new NodeVisitor();
		
		$traverser = new NodeTraverser();
		$traverser->addVisitor($visitor);
		$traverser->traverse($ast);
		
		return $visitor->getClassNames();
	}
}