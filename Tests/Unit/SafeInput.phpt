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

final class Input extends Tester\TestCase {
	public function testRenderingKnownAttributes() {
		Assert::same(
			'<input type="text" name="surname"/>',
			(new Form\SafeInput(['type' => 'text', 'name' => 'surname']))->render()
		);
	}

	public function testRenderingUnknownAttributes() {
		Assert::same(
			'<input foo="bar" name="surname"/>',
			(new Form\SafeInput(['foo' => 'bar', 'name' => 'surname']))->render()
		);
	}

	public function testProtectingAgainstXss() {
		Assert::same(
			'<input type="&quot;\'&lt;&gt;"/>',
			(new Form\SafeInput(['type' => '"\'<>']))->render()
		);
	}
}

(new Input())->run();
