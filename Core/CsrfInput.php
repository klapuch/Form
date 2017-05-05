<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Csrf;

/**
 * Input as a protection against CSRF
 */
final class CsrfInput implements Control {
	private $csrf;

	public function __construct(Csrf\Protection $csrf) {
		$this->csrf = $csrf;
	}

	public function render(): string {
		return (new Csrf\Input($this->csrf))->coverage();
	}

	public function validate(): void {
		if ($this->csrf->attacked())
			throw new \UnexpectedValueException('Timeout');
	}
}