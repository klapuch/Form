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
		$storage = [];
		Assert::same(
			'<input type="text" name="surname"/>',
			(new Form\SafeInput(
				['type' => 'text', 'name' => 'surname'],
				new Form\Backup($storage)
			))->render()
		);
	}

	public function testRenderingUnknownAttributes() {
		$storage = [];
		Assert::same(
			'<input foo="bar" name="surname"/>',
			(new Form\SafeInput(
				['foo' => 'bar', 'name' => 'surname'],
				new Form\Backup($storage)
			))->render()
		);
	}

	public function testProtectingAgainstXss() {
		$storage = [];
		Assert::same(
			'<input type="&quot;\'&lt;&gt;"/>',
			(new Form\SafeInput(
				['type' => '"\'<>'],
				new Form\Backup($storage)
			))->render()
		);
	}

	public function testPassingValue() {
		$storage = ['surname' => 'myself'];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\SafeInput(
				['foo' => 'bar', 'name' => 'surname'],
				new Form\Backup($storage)
			))->render()
		);
	}

	public function testOverwritingValue() {
		$storage = ['surname' => 'myself'];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\SafeInput(
				['foo' => 'bar', 'name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage)
			))->render()
		);
	}

	public function testRemovingAfterPresenting() {
		$storage = ['surname' => 'myself'];
		$expectation = '<input foo="bar" name="surname" value="myself"/>';
		$input = new Form\SafeInput(
			['foo' => 'bar', 'name' => 'surname', 'value' => 'you'],
			new Form\Backup($storage)
		);
		Assert::same($expectation, $input->render());
		Assert::notSame($expectation, $input->render());
	}

}

(new Input())->run();
