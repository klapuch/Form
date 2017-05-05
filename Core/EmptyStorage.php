<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Empty storage without some useful behavior
 */
final class EmptyStorage implements Storage {
	public function offsetSet($name, $value): void {
	}

	public function offsetExists($name): bool {
		return false;
	}

	public function offsetUnset($name): void {
	}

	/**
	 * @param mixed $name
	 * @return mixed
	 */
	public function offsetGet($name) {
	}

	public function archive($name): void {
	}

	public function drop(): void {
	}
}