<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Input protected from potential XSS
 */
final class SafeInput implements Control {
	private $attributes;
	private $backup;

	public function __construct(array $attributes, Backup $backup) {
		$this->attributes = $attributes;
		$this->backup = $backup;
	}

	public function render(): string {
		$this->attributes['value'] = (string)$this->backup[$this->attributes['name'] ?? ''];
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag('input', $this->attributes()),
			new Markup\EmptyElement()
		))->markup();
	}

	private function attributes(): Markup\Attributes {
		return new Markup\HtmlAttributes(
			...array_map(
				function(string $name, string $value): Markup\Attribute {
					return new Markup\HtmlAttribute(
						$name,
						htmlspecialchars($this->attributes[$name], ENT_QUOTES)
					);
				},
				array_keys($this->attributes),
				$this->attributes
			)
		);
	}
}
