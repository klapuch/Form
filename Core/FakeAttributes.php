<?php
declare(strict_types = 1);
namespace Klapuch\Form;

final class FakeAttributes implements Attributes {
	private $attributes;

	public function __construct(array $attributes) {
		$this->attributes = $attributes;
	}

	public function pairs(): array {
		return $this->attributes;
	}

	public function offsetExists($offset): bool {
	}

	/**
	 * @return mixed
	 */
	public function offsetGet($offset) {
		return $this->attributes[$offset];
	}

	public function offsetSet($offset, $value): void {
	}

	public function offsetUnset($offset): void {
	}
}