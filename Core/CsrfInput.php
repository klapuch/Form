<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Csrf;

/**
 * Input as a protection against CSRF
 */
final class CsrfInput implements Control {
	private $csrf;

	public function __construct(Csrf\Csrf $csrf) {
		$this->csrf = $csrf;
	}

	public function render(): string {
		return (new Csrf\CsrfInput($this->csrf))->protection();
	}

	public function validate(): void {
		if($this->csrf->abused())
			throw new \UnexpectedValueException('Timeout');
	}
}