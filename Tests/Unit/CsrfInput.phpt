<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\{
	Form, Csrf
};
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class CsrfInput extends Tester\TestCase {
	public function testHiddenField() {
		Assert::contains(
			'type="hidden"',
			(new Form\CsrfInput(new Csrf\FakeCsrf('')))->render()
		);
	}

	public function testValidating() {
		Assert::noError(function() {
			(new Form\CsrfInput(new Csrf\FakeCsrf('', false)))->validate();
		});
		Assert::exception(function() {
			(new Form\CsrfInput(new Csrf\FakeCsrf('', true)))->validate();
		}, \UnexpectedValueException::class, 'Timeout');
	}
}

(new CsrfInput())->run();