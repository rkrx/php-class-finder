<?php

namespace Kir\ClassFinder;

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use RuntimeException;

class ClassTools {
	/**
	 * @param string $filepath
	 * @return string[]
	 */
	public static function getFQClassNamesFromFile(string $filepath) {
		$contents = file_get_contents($filepath);
		
		if($contents === false) {
			throw new RuntimeException('Invalid content type');
		}
		
		return self::getFQClassNamesFromString($contents);
	}
	
	/**
	 * @param string $source
	 * @return string[]
	 */
	public static function getFQClassNamesFromString(string $source): array {
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
		$ast = $parser->parse($source);
		
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