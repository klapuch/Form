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

final class Option extends Tester\TestCase {
	/**
	 * @throws \DomainException Foo
	 */
	public function testUsingValueForValidation() {
		(new Form\Option(
			new Form\FakeAttributes(['value' => 'my-value']),
			'My value',
			new Validation\FakeRule(false, new \DomainException('Foo'))
		))->validate();
	}

	public function testPassingValueAsSafeElementContent() {
		Assert::same(
			'<option value="foo">Hi!&lt;&gt;</option>',
			(new Form\Option(
				new Form\FakeAttributes(['value' => 'foo']),
				'Hi!<>',
				new Validation\FakeRule(false)
			))->render()
		);
	}
}

(new Option())->run();