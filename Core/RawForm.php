<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Raw form
 */
final class RawForm implements Control {
	private $attributes;
	private $controls;

	public function __construct(array $attributes, Control ...$controls) {
		$this->attributes = $attributes;
		$this->controls = $controls;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag('form', $this->attributes()),
			new Markup\FakeElement($this->children())
		))->markup();
	}

	public function validate(): void {
		foreach($this->controls as $control)
			$control->validate();
	}

	private function attributes(): Markup\Attributes {
		return new Markup\HtmlAttributes(
			...array_map(
				function(string $name): Markup\Attribute {
					return new Markup\HtmlAttribute(
						$name,
						$this->attributes[$name]
					);
				},
				array_keys($this->attributes)
			)
		);
	}

	private function children(): string {
		return implode(
			array_map(
				function(Control $control): string {
					return $control->render();
				},
				$this->controls
			)
		);
	}
}