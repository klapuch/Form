<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Fake
 */
final class FakeStorage implements Storage {
	private $values;

	public function __construct(array $values) {
		$this->values = $values;
	}

	public function offsetExists($offset): bool {
		return isset($this->values[$offset]);
	}

	/**
	 * @return mixed
	 */
	public function offsetGet($offset) {
		return $this->values[$offset];
	}

	public function offsetSet($offset, $value): void {
	}

	public function offsetUnset($offset): void {
	}

	public function archive($name): void {
	}

	public function drop(): void {
	}
}