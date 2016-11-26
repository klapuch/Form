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

final class SafeForm extends Tester\TestCase {
	public function testIncludingAttributes() {
		$form = (new Form\SafeForm(
			'POST',
			'/index.php',
			new Form\FakeControl('')
		))->render();
		Assert::contains('POST', $form);
		Assert::contains('/index.php', $form);
	}

	public function testWrappingControlsToForm() {
		Assert::same(
			'<form method="POST" action="/index.php"><input name="first"/><input name="second"/></form>',
			(new Form\SafeForm(
				'POST',
				'/index.php',
				new Form\FakeControl('<input name="first"/>'),
				new Form\FakeControl('<input name="second"/>')
			))->render()
		);
	}
}

(new SafeForm())->run();
