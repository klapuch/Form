<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Default input
 */
final class DefaultInput implements Control {
	private $attributes;
	private $storage;
	private $rule;

	public function __construct(
		array $attributes,
		Storage $storage,
		Validation\Rule $rule
	) {
		$this->attributes = $attributes;
		$this->storage = $storage;
		$this->rule = $rule;
	}

	public function validate(): void {
		$name = $this->attributes['name'];
		$this->storage->archive($name);
		if (!isset($this->storage[$name])) {
			throw new \UnexpectedValueException(
				sprintf('Field "%s" is missing in sent data', $name)
			);
		}
		$this->rule->apply($this->storage[$name]);
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('input', $this->attribute()),
			new Markup\EmptyElement()
		))->markup();
	}

	private function attribute(): Markup\Attribute {
		$name = $this->attributes['name'];
		if (isset($this->storage[$name]))
			$this->attributes['value'] = $this->storage[$name];
		unset($this->storage[$name]);
		return new Markup\ArrayAttribute($this->attributes);
	}
}