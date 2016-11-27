<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Label linked to particular input
 */
final class LinkedLabel implements Label {
	private const FREE = '';
	private $content;
	private $for;

	public function __construct(string $content, string $for = self::FREE) {
		$this->content = $content;
		$this->for = $for;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag(
				'label',
				new Markup\HtmlAttributes(
					new Markup\HtmlAttribute('for', $this->for)
				)
			),
			new Markup\TextElement($this->content)
		))->markup();
	}
}
