<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Safe input
 */
final class SafeInput implements Control {
	private $attributes;
	private $storage;
	private $rule;

	public function __construct(
		array $attributes,
		Storage $storage,
		Validation\Rule $rule
	) {
		$this->attributes = $attributes;
		$this->storage = $storage;
		$this->rule = $rule;
	}

	public function render(): string {
		$name = $this->attributes['name'] ?? '';
		if(isset($this->storage[$name]))
			$this->attributes['value'] = $this->storage[$name];
		unset($this->storage[$name]);
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag('input', $this->attributes()),
			new Markup\EmptyElement()
		))->markup();
	}

	public function validate(): void {
		if(isset($this->storage[$this->attributes['name']]))
			$this->rule->apply($this->storage[$this->attributes['name']]);
	}

	private function attributes(): Markup\Attributes {
		return new Markup\HtmlAttributes(
			...array_map(
				function(string $name, string $value): Markup\Attribute {
					return new Markup\HtmlAttribute($name, $value);
				},
				array_keys($this->attributes),
				$this->attributes
			)
		);
	}
}