<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Input reloaded from XML source
 */
final class XmlReloadedInput extends SafeControl {
	private $attributes;
	private $dom;

	public function __construct(array $attributes, \DOMDocument $dom) {
		$this->attributes = $attributes;
		$this->dom = $dom;
	}

	public function render(): string {
		$this->attributes['value'] = $this->value($this->attributes['name']);
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('input', $this->attribute($this->attributes)),
			new Markup\EmptyElement()
		))->markup();
	}

	public function validate(): void {

	}

	private function value(string $name): string {
		return (new \DOMXPath($this->dom))->evaluate(sprintf('string(/*/%s)', $name));
	}
}