<?php
declare(strict_types = 1);
namespace Klapuch\Form;

final class FakeLabel implements Label {
	private $output;

	public function __construct(string $output = null) {
	    $this->output = $output;
	}

	public function render(): string {
		return $this->output;
	}
}