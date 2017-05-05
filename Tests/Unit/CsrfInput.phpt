<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\Csrf;
use Klapuch\Form;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class CsrfInput extends Tester\TestCase {
	public function testHiddenField() {
		Assert::contains(
			'type="hidden"',
			(new Form\CsrfInput(new Csrf\FakeProtection('')))->render()
		);
	}

	public function testValidating() {
		Assert::noError(function() {
			(new Form\CsrfInput(new Csrf\FakeProtection('', false)))->validate();
		});
		Assert::exception(function() {
			(new Form\CsrfInput(new Csrf\FakeProtection('', true)))->validate();
		}, \UnexpectedValueException::class, 'Timeout');
	}
}

(new CsrfInput())->run();