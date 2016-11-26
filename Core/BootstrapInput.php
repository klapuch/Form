<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Input for bootstrap CSS framework
 */
final class BootstrapInput implements Control {
	private $origin;
	private $size;

	public function __construct(Control $origin, int $size) {
		$this->origin = $origin;
		$this->size = $size;
	}

	public function render(): string {
		return (new WrappedControl(
			new WrappedControl(
				$this->origin,
				new Markup\HtmlTag(
					'div',
					new Markup\HtmlAttributes(
						new Markup\HtmlAttribute(
							'class', sprintf('col-sm-%d', $this->size)
						)
					)
				)
			),
			new Markup\HtmlTag(
				'div',
				new Markup\HtmlAttributes(
					new Markup\HtmlAttribute('class', 'form-group')
				)
			)
		))->render();
	}
}
