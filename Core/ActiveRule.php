<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Validation;

/**
 * Rule applied to not disabled attributes
 */
final class ActiveRule implements Validation\Rule {
	private $origin;
	private $attributes;

	public function __construct(Validation\Rule $origin, Attributes $attributes) {
		$this->origin = $origin;
		$this->attributes = $attributes;
	}

	public function satisfied($subject): bool {
		if (isset($this->attributes['disabled']))
			return true;
		return $this->origin->satisfied($subject);
	}

	public function apply($subject): void {
		if (!$this->satisfied($subject))
			$this->origin->apply($subject);
	}
}