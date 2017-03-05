<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Raw form
 */
final class RawForm implements Control {
	private $attribute;
	private $controls;

	public function __construct(Markup\Attribute $attribute, Control ...$controls) {
		$this->attribute = $attribute;
		$this->controls = $controls;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('form', $this->attribute),
			new Markup\FakeElement($this->children($this->controls))
		))->markup();
	}

	public function validate(): void {
		foreach($this->controls as $control)
			$control->validate();
	}

	private function children(array $controls): string {
		return implode(
			array_map(
				function(Control $control): string {
					return $control->render();
				},
				$controls
			)
		);
	}
}