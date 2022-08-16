<?php

namespace Kir\ClassFinder;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * @internal
 */
class NodeVisitor extends NodeVisitorAbstract {
	/** @var string[] */
	private array $classNames = [];
	/** @var array<int, array<int, string>> */
	private array $currentNamespaceStack = [];
	
	public function enterNode(Node $node) {
		if($node instanceof Node\Stmt\Namespace_) {
			$latestNamespace = $this->currentNamespaceStack[count($this->currentNamespaceStack) - 1] ?? [];
			$this->currentNamespaceStack[] = [...$latestNamespace, ...explode('\\', (string) $node->name)];
		}
		
		if($node instanceof Node\Stmt\Class_) {
			$latestNamespace = $this->currentNamespaceStack[count($this->currentNamespaceStack) - 1] ?? [];
			$this->classNames[] = implode('\\', [...$latestNamespace, (string) $node->name]);
		}
		
		return null;
	}
	
	public function leaveNode(Node $node) {
		if($node instanceof Node\Stmt\Namespace_) {
			array_pop($this->currentNamespaceStack);
		}
		
		return null;
	}
	
	/**
	 * @return string[]
	 */
	public function getClassNames(): array {
		return $this->classNames;
	}
}
