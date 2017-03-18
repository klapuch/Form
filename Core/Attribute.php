<?php
declare(strict_types = 1);
namespace Klapuch\Form;

interface Attribute {
	/**
	 * Name of the attribute: TYPE="text"
	 * @return string
	 */
	public function name(): string;

	/**
	 * Value of the attribute: type="TEXT"
	 * @return string
	 */
	public function value(): string;
}