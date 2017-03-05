<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Static XSL attribute
 */
final class StaticXslAttribute extends XslAttribute {
	public function element(): Markup\Element {
		return new Markup\NormalizedElement(
			$this->attribute(),
			new Markup\NormalizedElement(
				new Markup\ValidTag('xsl:text', new Markup\EmptyAttribute()),
				new Markup\SafeElement($this->value())
			)
		);
	}
}