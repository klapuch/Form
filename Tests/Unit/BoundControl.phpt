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

final class BoundControl extends Tester\TestCase {
	public function testLabelAsFirst() {
		Assert::same(
			'BarFoo',
			(new Form\BoundControl(
				new Form\FakeControl('Foo'),
				new Form\FakeLabel('Bar')
			))->render()
		);
	}
}

(new BoundControl())->run();