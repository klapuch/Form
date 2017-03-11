<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Persistent input in the storage
 */
final class PersistentInput extends Input {
	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\ValidTag('input', $this->attribute()),
			new Markup\EmptyElement()
		))->markup();
	}
}