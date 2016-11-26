<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\Form;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class CsrfInput extends Tester\TestCase {
	public function testHiddenField() {
		$session = [];
		Assert::contains(
			'type="hidden"',
			(new Form\CsrfInput($session, []))->render()
		);
	}
}

(new CsrfInput())->run();