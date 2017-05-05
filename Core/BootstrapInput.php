<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Input for bootstrap CSS framework
 */
final class BootstrapInput implements Control {
	private $origin;
	private $columns;

	public function __construct(Control $origin, int $columns) {
		$this->origin = $origin;
		$this->columns = $columns;
	}

	public function render(): string {
		return (new WrappedControl(
			new WrappedControl(
				$this->origin,
				new Markup\ValidTag(
					'div',
					new Markup\ConcatenatedAttribute(
						new Markup\SafeAttribute(
							'class',
							sprintf('col-sm-%d', $this->columns)
						)
					)
				)
			),
			new Markup\ValidTag(
				'div',
				new Markup\ConcatenatedAttribute(
					new Markup\SafeAttribute('class', 'form-group')
				)
			)
		))->render();
	}

	public function validate(): void {
		$this->origin->validate();
	}
}