<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Dynamic XSL attribute
 */
final class DynamicXslAttribute extends XslAttribute {
	public function element(): Markup\Element {
		return new Markup\NormalizedElement(
			$this->attribute(),
			new Markup\NormalizedElement(
				new Markup\ValidTag(
					'xsl:value-of',
					new Markup\SafeAttribute('select', $this->value())
				),
				new Markup\EmptyElement()
			)
		);
	}
}