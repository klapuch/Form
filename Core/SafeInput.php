<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Input protected from potential XSS
 */
final class SafeInput implements Control {
	private $attributes;

	public function __construct(array $attributes) {
		$this->attributes = $attributes;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag(
				'input',
				new Markup\HtmlAttributes(
					...array_reduce(
						array_keys($this->attributes),
						function($attributes, string $name) {
							$attributes[] = new Markup\HtmlAttribute(
								$name,
								htmlspecialchars(
									$this->attributes[$name],
									ENT_QUOTES,
									'UTF-8'
								)
							);
							return $attributes;
						}
					)
				)
			),
			new Markup\EmptyElement()
		))->markup();
	}
}
