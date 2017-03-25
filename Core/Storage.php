<?php
declare(strict_types = 1);
namespace Klapuch\Form;

interface Storage extends \ArrayAccess {
	/**
	 * Archive the source
	 * @param mixed $name
	 * @return void
	 */
	public function archive($name): void;

	/**
	 * Drop everything in the backup
	 * @return void
	 */
	public function drop(): void;
}