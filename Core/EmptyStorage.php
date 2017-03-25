<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Empty storage without some useful behavior
 */
final class EmptyStorage implements Storage {
	public function offsetSet($name, $value) {
	}

	public function offsetExists($name) {
		return false;
	}

	public function offsetUnset($name) {

	}

	public function offsetGet($name) {

	}

	public function archive($name): void {
	}

	public function drop(): void {
	}
}