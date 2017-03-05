<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * <xsl:attribute>...</xsl:attribute>
 */
abstract class XslAttribute {
	private $name;
	private $value;

	final public function __construct(string $name, string $value) {
		$this->name = $name;
		$this->value = $value;
	}

	final public function name(): string {
		return $this->name;
	}

	final public function value(): string {
		return $this->value;
	}

	final protected function attribute(): Markup\Tag {
		return new Markup\ValidTag(
			'xsl:attribute',
			new Markup\SafeAttribute('name', $this->name())
		);
	}

	abstract public function element(): Markup\Element;
}