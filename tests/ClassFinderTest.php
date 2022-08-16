<?php

namespace Kir\ClassFinder;

use PHPUnit\Framework\TestCase;

class ClassFinderTest extends TestCase {
	public function testClassWONamespace(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([__DIR__.'/test-files/ClassWONamespace.php']);
		self::assertEquals(['TextClass1', 'TextClass2'], iterator_to_array($classNames));
	}
	
	public function testClassWithOneNamespace(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([__DIR__.'/test-files/ClassesWithOneNamespace.php']);
		self::assertEquals(['Test\\Namespace\\ClassWithOneNamespace', 'Test\\Namespace\\AnotherClassWithOneNamespace'], iterator_to_array($classNames));
	}
	
	public function testClassWithANestedNamespace(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([__DIR__.'/test-files/ClassesWithANestedNamespace.php']);
		self::assertEquals(['Test\\NestedNamespace\\ClassWithANestedNamespace', 'Test\\NestedNamespace\\AnotherClassWithANestedNamespace'], iterator_to_array($classNames));
	}
	
	public function testMultipleFiles(): void {
		$classNames = ClassFinder::findClassesFromIterableFileList([
			__DIR__.'/test-files/ClassWONamespace.php',
			__DIR__.'/test-files/ClassesWithOneNamespace.php',
			__DIR__.'/test-files/ClassesWithANestedNamespace.php',
		]);
		self::assertCount(6, iterator_to_array($classNames));
	}
}
