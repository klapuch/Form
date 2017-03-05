<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Xsl input
 */
final class XslInput implements Control {
	private $attributes;

	public function __construct(array $attributes) {
		$this->attributes = $attributes;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag(
				'xsl:element', new Markup\SafeAttribute('name', 'input')
			),
			$this->attribute($this->attributes)
		))->markup();
	}

	private function attribute(array $attributes): Markup\Element {
		return new Markup\ChainedElement(
			...array_map(
				function(XslAttribute $attribute): Markup\Element {
					return $attribute->element();
				},
				$attributes
			)
		);
	}

	public function validate(): void {

	}
}