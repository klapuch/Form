<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Storage for manipulation with data in input fields and their backups
 */
final class Backup implements Storage {
	private const IGNORED_BACKUPS = ['password'];
	private const SECTION = '_form';
	private $storage;
	private $source;

	public function __construct(array &$storage, array $source) {
		$this->storage[self::SECTION] = &$storage;
		$this->source[self::SECTION] = $source;
	}

	public function offsetSet($name, $value) {
		if($name && !in_array($name, self::IGNORED_BACKUPS, true))
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
		$this[$name] = $this[$name];
	}

	/**
	 * Drop everything in the backup
	 * @return void
	 */
	public function drop(): void {
		foreach(array_keys($this->source[self::SECTION]) as $name)
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