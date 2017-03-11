<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Persistent input in the storage
 */
final class PersistentInput extends SafeControl {
	private $attributes;
	private $backup;
	private $rule;

	public function __construct(
		array $attributes,
		Backup $backup,
		Validation\Rule $rule
	) {
		$this->attributes = $attributes;
		$this->backup = $backup;
		$this->rule = $rule;
	}

	public function render(): string {
		$name = $this->attributes['name'] ?? null;
		if(isset($this->backup[$name]))
			$this->attributes['value'] = $this->backup[$name];
		unset($this->backup[$name]);
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('input', $this->attribute($this->attributes)),
			new Markup\EmptyElement()
		))->markup();
	}

	public function validate(): void {
		$name = $this->attributes['name'] ?? null;
		if(isset($this->backup[$name]))
			$this->rule->apply($this->backup[$name]);
		$this->backup->archive($name);
	}
}