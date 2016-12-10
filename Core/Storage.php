<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Storage for manipulation with data in input fields and their backups
 */
final class Storage implements \ArrayAccess {
	private const SECTION = '_form';
	private $backup;
	private $source;

	public function __construct(array &$backup, array $source) {
		$this->backup[self::SECTION] = &$backup;
		$this->source[self::SECTION] = $source;
	}

	public function offsetSet($name, $value) {
		if($name === null)
			throw new \InvalidArgumentException('Offset must be named');
		$this->backup[self::SECTION][$name] = $value;
	}

	public function offsetExists($name) {
		return isset($this->merge()[$name]);
	}

	public function offsetUnset($name) {
		unset($this->backup[self::SECTION][$name]);
	}

	public function offsetGet($name) {
		return $this->merge()[$name] ?? null;
	}

	/**
	 * Backup the source
	 * @param mixed $name
	 * @return void
	 */
	public function backup($name): void {
		$this->backup[self::SECTION][$name] = $this->source[self::SECTION][$name];
	}

	/**
	 * Merged source with backup
	 * @return array
	 */
	private function merge(): array {
		return $this->source[self::SECTION] + $this->backup[self::SECTION];
	}
}