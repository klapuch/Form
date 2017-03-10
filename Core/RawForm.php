<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Raw form
 */
final class RawForm extends SafeControl {
	private $attributes;
	private $controls;

	public function __construct(array $attributes, Control ...$controls) {
		$this->attributes = $attributes;
		$this->controls = $controls;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('form', $this->attribute($this->attributes)),
			new Markup\FakeElement($this->children($this->controls))
		))->markup();
	}

	public function validate(): void {
		foreach($this->controls as $control)
			$control->validate();
	}

	private function children(array $controls): string {
		return array_reduce(
			$controls,
			function(string $children, Control $control): string {
				return $children .= $control->render();
			},
			''
		);
	}
}