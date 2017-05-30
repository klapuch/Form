<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;
use Klapuch\Validation;

/**
 * Default textarea
 */
final class TextArea implements Control {
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
				'textarea',
				new Markup\ArrayAttribute(
					array_diff_key(
						$this->attributes->pairs(),
						array_flip(['value'])
					)
				)
			),
			new Markup\SafeElement($this->attributes['value'])
		))->markup();
	}
}