<?php

namespace Kir\ClassFinder;

use CallbackFilterIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ClassFinder {
	/**
	 * @param string $dir
	 * @return ClassFinderResult
	 */
	public static function findClassesFromDirectory(string $dir): iterable {
		$flags = FilesystemIterator::FOLLOW_SYMLINKS
		       | FilesystemIterator::SKIP_DOTS
		       | FilesystemIterator::KEY_AS_PATHNAME
		       | FilesystemIterator::CURRENT_AS_PATHNAME;
		
		$directory = new RecursiveDirectoryIterator($dir, $flags);
		$iterator = new RecursiveIteratorIterator($directory);
		$fileIterator = new CallbackFilterIterator($iterator, fn(string $path) => preg_match('{\\.p(hp\\d?|html)$}i', $path));
		
		/** @var iterable<string> $fileIterator */
		return new ClassFinderResult($fileIterator);
	}
	
	/**
	 * @param iterable<string> $files
	 * @return ClassFinderResult
	 */
	public static function findClassesFromIterableFileList(iterable $files): iterable {
		$_files = [];
		foreach($files as $file) {
			$_files[] = $file;
		}
		return new ClassFinderResult($_files);
	}
}