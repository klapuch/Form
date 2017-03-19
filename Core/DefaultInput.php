<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Default input
 */
final class DefaultInput implements Control {
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

	public function validate(): void {
		$name = $this->attributes['name'] ?? null;
		$this->backup->archive($name);
		if (isset($this->backup[$name]))
			$this->rule->apply($this->backup[$name]);
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('input', $this->attribute()),
			new Markup\EmptyElement()
		))->markup();
	}

	private function attribute(): Markup\Attribute {
		$name = $this->attributes['name'] ?? null;
		if (isset($this->backup[$name]))
			$this->attributes['value'] = $this->backup[$name];
		unset($this->backup[$name]);
		return new Markup\ArrayAttribute($this->attributes);
	}
}