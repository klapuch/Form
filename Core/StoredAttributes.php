<?php
declare(strict_types = 1);
namespace Klapuch\Form;

final class StoredAttributes implements Attributes {
	private $attributes;
	private $storage;

	public function __construct(array $attributes, Storage $storage) {
		$this->attributes = $attributes;
		$this->storage = $storage;
	}

	public function pairs(): array {
		$name = $this['name'] ?? null;
		if (isset($this->storage[$name]))
			$this['value'] = $this->storage[$name];
		unset($this->storage[$name]);
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
			if (!isset($this['disabled']) && !isset($this->storage[$this['name']])) {
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