<?php
declare(strict_types = 1);
namespace Klapuch\Form;

interface Control {
	/**
	 * Control itself in particular format
	 * @return string
	 */
	public function render(): string;

	/**
	 * Validate the control
	 * @throws \UnexpectedValueException
	 * @return void
	 */
	public function validate(): void;
}