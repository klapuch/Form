<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * XML dynamic value
 */
final class XmlDynamicValue {
	private $name;
	private $xml;

	public function __construct(string $name, \DOMDocument $xml) {
		$this->name = $name;
		$this->xml = $xml;
	}

	public function __toString(): string {
		return (new \DOMXPath($this->xml))->evaluate(
			sprintf('string(/*/%s)', $this->name)
		);
	}
}