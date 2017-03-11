<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Input reloaded from XML source
 */
final class XmlReloadedInput extends Input {
	private $xml;

	public function __construct(
		array $attributes,
		\DOMDocument $xml,
		Backup $backup,
		Validation\Rule $rule
	) {
		parent::__construct($attributes, $backup, $rule);
		$this->xml = $xml;
	}

	public function render(): string {
		$this->attributes['value'] = $this->value($this->attributes['name']);
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('input', $this->attribute()),
			new Markup\EmptyElement()
		))->markup();
	}

	private function value(string $name): string {
		return (new \DOMXPath($this->xml))->evaluate(sprintf('string(/*/%s)', $name));
	}
}