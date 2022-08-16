<?php

namespace Kir\ClassFinder;

use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string>
 */
class ClassFinderResult implements IteratorAggregate {
	/**
	 * @param iterable<string> $filepaths
	 */
	public function __construct(private iterable $filepaths) {}
	
	/**
	 * @return Traversable<ClassFile>
	 */
	public function getFiles() {
		foreach($this->filepaths as $filepath) {
			yield new ClassFile($filepath);
		}
	}
	
	/**
	 * @return Traversable<string>
	 */
	public function getIterator(): Traversable {
		foreach($this->filepaths as $filepath) {
			$classNamesFromFile = ClassTools::getFQClassNamesFromFile($filepath);
			foreach($classNamesFromFile as $className) {
				yield $className;
			}
		}
	}
}