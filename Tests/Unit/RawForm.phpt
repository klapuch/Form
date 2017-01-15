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

final class RawForm extends Tester\TestCase {
	public function testFormTags() {
		$form = (new Form\RawForm(
			['method' => 'POST'],
			new Form\FakeControl('')
		))->render();
		Assert::contains('<form ', $form);
		Assert::contains('/>', $form);
	}

	public function testIncludingAttributes() {
		$form = (new Form\RawForm(
			['method' => 'POST', 'action' => '/index.php'],
			new Form\FakeControl('')
		))->render();
		Assert::contains('POST', $form);
		Assert::contains('/index.php', $form);
	}

	public function testWrappingControlsToForm() {
		Assert::same(
			'<form method="POST" action="/index.php"><input name="first"/><input name="second"/></form>',
			(new Form\RawForm(
				['method' => 'POST', 'action' => '/index.php'],
				new Form\FakeControl('<input name="first"/>'),
				new Form\FakeControl('<input name="second"/>')
			))->render()
		);
	}

	public function testValidatingInOrder() {
		Assert::exception(function() {
			(new Form\RawForm(
				[],
				new Form\FakeControl(null, null),
				new Form\FakeControl(null, null),
				new Form\FakeControl(null, null),
				new Form\FakeControl(null, new \DomainException('foo')),
				new Form\FakeControl(null, null),
				new Form\FakeControl(null, new \DomainException('bar'))
			))->validate();
		}, \DomainException::class, 'foo');
	}
}

(new RawForm())->run();