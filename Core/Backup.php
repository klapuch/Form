<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Backup storage for failed input fields
 */
final class Backup implements \ArrayAccess {
	private const SECTION = '_form';
	private $storage = [];

	public function __construct(array &$storage) {
		$this->storage[self::SECTION] = &$storage;
	}

	public function offsetSet($name, $value) {
		if($name === null)
			throw new \InvalidArgumentException('Offset must be named');
		$this->storage[self::SECTION][$name] = $value;
	}

	public function offsetExists($name) {
		return isset($this->storage[self::SECTION][$name]);
	}

	public function offsetUnset($name) {
		unset($this->storage[self::SECTION][$name]);
	}

	public function offsetGet($name) {
		return $this->storage[self::SECTION][$name] ?? null;
	}
}
