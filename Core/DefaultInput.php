<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;
use Klapuch\Validation;

/**
 * Default input
 */
final class DefaultInput implements Control {
	private $attributes;
	private $rule;

	public function __construct(Attributes $attributes, Validation\Rule $rule) {
		$this->attributes = $attributes;
		$this->rule = $rule;
	}

	public function validate(): void {
		(new ActiveRule(
			$this->rule,
			$this->attributes
		))->apply($this->attributes['value']);
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag(
				'input',
				new Markup\ArrayAttribute($this->attributes->pairs())
			),
			new Markup\EmptyElement()
		))->markup();
	}
}