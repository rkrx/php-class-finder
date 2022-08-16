<?php

namespace Kir\ClassFinder;

use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string>
 */
class ClassFile implements IteratorAggregate {
	public function __construct(private string $filepath) {}
	
	/**
	 * @return string
	 */
	public function getFilepath(): string {
		return $this->filepath;
	}
	
	/**
	 * @return array<string>
	 */
	public function getClassNames(): iterable {
		return ClassTools::getFQClassNamesFromFile($this->filepath);
	}
	
	/**
	 * @return Traversable<string>
	 */
	public function getIterator(): Traversable {
		yield from $this->getClassNames();
	}
}