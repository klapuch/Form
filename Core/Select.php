<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Select with options
 */
final class Select implements Control {
	private $attributes;
	private $options;

	public function __construct(Attributes $attributes, Control ...$options) {
		$this->attributes = $attributes;
		$this->options = $options;
	}

	public function validate(): void {
		foreach ($this->options as $option)
			$option->validate();
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag(
				'select',
				new Markup\ArrayAttribute($this->attributes->pairs())
			),
			new class(...$this->options) implements Markup\Element {
				private $options;

				public function __construct(Control ...$options) {
					$this->options = $options;
				}

				public function markup(): string {
					return implode(
						array_map(
							function(Control $option): string {
								return $option->render();
							},
							$this->options
						)
					);
				}
			}
		))->markup();
	}
}