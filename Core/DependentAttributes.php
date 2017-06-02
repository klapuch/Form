<?php
declare(strict_types = 1);
namespace Klapuch\Form;

final class DependentAttributes implements Attributes {
	private $attributes;
	private $storage;
	private $dependent;

	public function __construct(array $attributes, Storage $storage, string $dependent) {
		$this->attributes = $attributes;
		$this->storage = $storage;
		$this->dependent = $dependent;
	}

	public function pairs(): array {
		if (isset($this->storage[$this->dependent]) && $this->storage[$this->dependent] === $this->attributes['value']) {
			$this['selected'] = 'selected';
			unset($this->storage[$this->dependent]);
		}
		return $this->attributes;
	}

	public function offsetExists($offset): bool {
		return isset($this->attributes[$offset]);
	}

	/**
	 * @return mixed
	 */
	public function offsetGet($offset) {
		if ($offset === 'value') {
			$this->storage->archive($this['name']);
			if (!isset($this->storage[$this['name']])) {
				throw new \UnexpectedValueException(
					sprintf('Field "%s" is missing in sent data', $this['name'])
				);
			}
			return $this->storage[$this['name']];
		}
		return $this->attributes[$offset];
	}

	public function offsetSet($offset, $value): void {
		$this->attributes[$offset] = $value;
	}

	public function offsetUnset($offset): void {
		unset($this->attributes[$offset]);
	}
}