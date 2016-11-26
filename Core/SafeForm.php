<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Safely submitted form
 */
final class SafeForm implements Control {
	private $method;
	private $action;
	private $controls;

	public function __construct(
		string $method,
		string $action,
		Control ...$controls
	) {
		$this->method = $method;
		$this->action = $action;
		$this->controls = $controls;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag(
				'form',
				new Markup\HtmlAttributes(
					new Markup\HtmlAttribute('method', $this->method),
					new Markup\HtmlAttribute('action', $this->action)
				)
			),
			new Markup\FakeElement(
				implode(
					array_map(
						function(Control $control): string {
							return $control->render();
						},
						$this->controls
					)
				)
			)
		))->markup();
	}
}
