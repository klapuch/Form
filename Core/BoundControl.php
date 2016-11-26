<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Control bound with label
 */
final class BoundControl implements Control {
	private $control;
	private $label;

	public function __construct(Control $control, Label $label) {
		$this->control = $control;
		$this->label = $label;
	}

	public function render(): string {
		return $this->label->render() . $this->control->render();
	}
}