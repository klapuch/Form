<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Static attribute
 */
final class StaticAttribute implements Attribute {
	private $name;
	private $value;

	public function __construct(string $name, string $value) {
		$this->name = $name;
		$this->value = $value;
	}

	public function name(): string {
		return $this->name;
	}

	public function value(): string {
		return $this->value;
	}
}