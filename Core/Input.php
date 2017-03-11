<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Input
 */
abstract class Input implements Control {
	protected $attributes;
	private $backup;
	private $rule;

	public function __construct(
		array $attributes,
		Backup $backup,
		Validation\Rule $rule
	) {
		$this->attributes = $attributes;
		$this->backup = $backup;
		$this->rule = $rule;
	}

	final public function validate(): void {
		$name = $this->attributes['name'] ?? null;
		if(isset($this->backup[$name]))
			$this->rule->apply($this->backup[$name]);
		$this->backup->archive($name);
	}

	final protected function attribute(): Markup\Attribute {
		$name = $this->attributes['name'] ?? null;
		if(isset($this->backup[$name]))
			$this->attributes['value'] = $this->backup[$name];
		unset($this->backup[$name]);
		return new Markup\ArrayAttribute($this->attributes);
	}
}