<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Control bound with label
 */
final class BoundControl implements Control {
	private $origin;
	private $label;

	public function __construct(Control $origin, Label $label) {
		$this->origin = $origin;
		$this->label = $label;
	}

	public function render(): string {
		return $this->label->render() . $this->origin->render();
	}

	public function validate(): void {
		$this->origin->validate();
	}
}