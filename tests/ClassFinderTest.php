<?php

namespace Kir\ClassFinder;

use CallbackFilterIterator;
use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ClassFinderTest extends TestCase {
	public function testClassWONamespace(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([__DIR__.'/test-files/ClassWONamespace.php']);
		self::assertEquals(['TextClass1', 'TextClass2'], $classNames);
	}
	
	public function testClassWithOneNamespace(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([__DIR__.'/test-files/ClassesWithOneNamespace.php']);
		self::assertEquals(['Test\\Namespace\\ClassWithOneNamespace', 'Test\\Namespace\\AnotherClassWithOneNamespace'], $classNames);
	}
	
	public function testClassWithANestedNamespace(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([__DIR__.'/test-files/ClassesWithANestedNamespace.php']);
		self::assertEquals(['Test\\NestedNamespace\\ClassWithANestedNamespace', 'Test\\NestedNamespace\\AnotherClassWithANestedNamespace'], $classNames);
	}
	
	public function testMultipleFiles(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([
			__DIR__.'/test-files/ClassWONamespace.php',
			__DIR__.'/test-files/ClassesWithOneNamespace.php',
			__DIR__.'/test-files/ClassesWithANestedNamespace.php',
		]);
		self::assertCount(6, $classNames);
	}
	
	public function testVendorFolder(): void {
		$startDir = __DIR__ . '/../vendor/';
		
		$classNames = ClassFinder::findClassesFromDirectory($startDir);
		foreach($classNames as $className) {
			printf("%s\n", $className);
		}
	}
}
