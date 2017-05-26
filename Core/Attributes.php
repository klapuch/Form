<?php
declare(strict_types = 1);
namespace Klapuch\Form;

interface Attributes extends \ArrayAccess {
	/**
	 * All the name-value attribute pairs
	 * @return array
	 */
	public function pairs(): array;
}