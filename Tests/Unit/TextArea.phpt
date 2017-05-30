<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\Form;
use Klapuch\Validation;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class TextArea extends Tester\TestCase {
	/**
	 * @throws \DomainException Foo
	 */
	public function testUsingValueForRule() {
		(new Form\TextArea(
			new Form\FakeAttributes(['value' => 'my-value']),
			new Validation\FakeRule(false, new \DomainException('Foo'))
		))->validate();
	}

	public function testIgnoringValidationForDisabledAttribute() {
		Assert::noError(function() {
			(new Form\TextArea(
				new Form\FakeAttributes(['value' => 'my-value', 'disabled' => '']),
				new Validation\FakeRule(null, new \DomainException('Foo'))
			))->validate();
		});
	}

	public function testPassingValueAsSafeElementContent() {
		Assert::same(
			'<textarea name="age">Hi!&lt;&gt;</textarea>',
			(new Form\TextArea(
				new Form\FakeAttributes(['value' => 'Hi!<>', 'name' => 'age']),
				new Validation\FakeRule(null, new \DomainException('Foo'))
			))->render()
		);
	}
}

(new TextArea())->run();