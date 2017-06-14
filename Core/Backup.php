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
		$this->storage = &$storage;
		$this->source = $source;
	}

	public function offsetSet($name, $value): void {
		if ($name && !in_array($name, self::IGNORED_BACKUPS, true))
			$this->storage[self::SECTION][$name] = $value;
	}

	public function offsetExists($name): bool {
		return isset($this->merge()[$name]);
	}

	public function offsetUnset($name): void {
		unset($this->storage[self::SECTION][$name]);
	}

	/**
	 * @param mixed $name
	 * @return mixed
	 */
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
		foreach (array_keys($this->source) as $name)
			unset($this[$name]);
	}

	/**
	 * Merged source with backup
	 * @return array
	 */
	private function merge(): array {
		return $this->source + ($this->storage[self::SECTION] ?? []);
	}
}