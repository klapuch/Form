<?php
declare(strict_types = 1);
namespace Klapuch\Form;

interface Label {
	/**
	 * Label itself in particular format
	 * @return string
	 */
	public function render(): string;
}