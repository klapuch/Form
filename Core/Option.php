<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;
use Klapuch\Validation;

/**
 * Option
 */
final class Option implements Control {
	private $attributes;
	private $label;
	private $rule;

	public function __construct(
		Attributes $attributes,
		string $label,
		Validation\Rule $rule
	) {
		$this->attributes = $attributes;
		$this->label = $label;
		$this->rule = $rule;
	}

	public function validate(): void {
		$this->rule->apply($this->attributes['value']);
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag(
				'option',
				new Markup\ArrayAttribute($this->attributes->pairs())
			),
			new Markup\SafeElement($this->label)
		))->markup();
	}
}