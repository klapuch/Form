<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Basic input field
 */
final class Input implements Control {
	private $type;
	private $name;
	private $storage;

	public function __construct(string $type, string $name, array $storage = []) {
		$this->type = $type;
		$this->name = $name;
		$this->storage = $storage;
	}

	public function render(): string {
		$value = $this->storage[$this->name] ?? '';
		unset($this->storage[$this->name]);
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag(
				'input',
				new Markup\HtmlAttributes(
					new Markup\HtmlAttribute('type', $this->type),
					new Markup\HtmlAttribute('name', $this->name),
					new Markup\HtmlAttribute('value', $value)
				)
			),
			new Markup\EmptyElement()
		))->markup();
	}
}
