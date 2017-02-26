<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Storage for manipulation with data in input fields and their backups
 */
final class Backup implements \ArrayAccess {
	private const SECTION = '_form';
	private $storage;
	private $source;

	public function __construct(array &$storage, array $source) {
		$this->storage[self::SECTION] = &$storage;
		$this->source[self::SECTION] = $source;
	}

	public function offsetSet($name, $value) {
		if($name === null)
			throw new \InvalidArgumentException('Offset must be named');
		$this->storage[self::SECTION][$name] = $value;
	}

	public function offsetExists($name) {
		return isset($this->merge()[$name]);
	}

	public function offsetUnset($name) {
		unset($this->storage[self::SECTION][$name]);
	}

	public function offsetGet($name) {
		return $this->merge()[$name] ?? null;
	}

	/**
	 * Archive the source
	 * @param mixed $name
	 * @return void
	 */
	public function archive($name): void {
		$this->storage[self::SECTION][$name] = $this[$name];
	}

	/**
	 * Drop everything in the backup
	 * @return void
	 */
	public function drop(): void {
		foreach(array_keys($this->storage[self::SECTION]) as $name)
			unset($this[$name]);
	}

	/**
	 * Merged source with backup
	 * @return array
	 */
	private function merge(): array {
		return $this->source[self::SECTION] + $this->storage[self::SECTION];
	}
}