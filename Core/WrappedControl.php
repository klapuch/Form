<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

/**
 * Control wrapped by elements
 */
final class WrappedControl implements Control {
	private $origin;
	private $tag;

	public function __construct(Control $origin, Markup\Tag $tag) {
		$this->origin = $origin;
		$this->tag = $tag;
	}

	public function render(): string {
		return (new Markup\NormalizedElement(
			$this->tag,
			new Markup\FakeElement($this->origin->render())
		))->markup();
	}
}