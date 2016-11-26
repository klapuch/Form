<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Csrf;

/**
 * Input as a protection against CSRF
 */
final class CsrfInput implements Control {
	private $session;
	private $post;

	public function __construct(array &$session, array $post) {
		$this->session = $session;
		$this->post = $post;
	}

	public function render(): string {
		return (new Csrf\CsrfInput(
			new Csrf\StoredCsrf($this->session, $this->post, [])
		))->protection();
	}
}