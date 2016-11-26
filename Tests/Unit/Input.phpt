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
	public function testRenderedKnownInputType() {
		Assert::same(
			'<input type="text" name="surname"/>',
			(new Form\Input('text', 'surname'))->render()
		);
	}

	public function testRenderedUnknownInputType() {
		Assert::same(
			'<input type="foo" name="surname"/>',
			(new Form\Input('foo', 'surname'))->render()
		);
	}

	public function testRenderingWithStoredValue() {
		$storage = ['surname' => 'cool'];
		Assert::same(
			'<input type="text" name="surname" value="cool"/>',
			(new Form\Input('text', 'surname', $storage))->render()
		);
	}

	public function testRemovingAfterRepresentingValue() {
		$storage = ['surname' => 'cool'];
		$input = new Form\Input('text', 'surname', $storage);
		Assert::contains('cool', $input->render());
		Assert::notContains('cool', $input->render());
	}
}

(new Input())->run();
