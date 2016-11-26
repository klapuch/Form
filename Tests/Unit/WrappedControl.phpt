<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\{
	Form, Markup
};
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class WrappedControl extends Tester\TestCase {
	public function testSimpleWrapping() {
		Assert::same(
			'<div class="danger"><input type="text" name="surname"/></div>',
			(new Form\WrappedControl(
				new Form\FakeControl('<input type="text" name="surname"/>'),
				new Markup\FakeTag('div class="danger"', 'div')
			))->render()
		);
	}
}

(new WrappedControl())->run();