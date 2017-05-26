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

final class DefaultInput extends Tester\TestCase {
	/**
	 * @throws \DomainException Foo
	 */
	public function testUsingValueForRule() {
		(new Form\DefaultInput(
			new Form\FakeAttributes(['value' => 'my-value']),
			new Validation\FakeRule(null, new \DomainException('Foo'))
		))->validate();
	}

	public function testIgnoringValidationForDisabledAttribute() {
		Assert::noError(function() {
			(new Form\DefaultInput(
				new Form\FakeAttributes(['value' => 'my-value', 'disabled' => '']),
				new Validation\FakeRule(null, new \DomainException('Foo'))
			))->validate();
		});
	}

	public function testRenderingAsInput() {
		Assert::same(
			'<input type="number" name="age"/>',
			(new Form\DefaultInput(
				new Form\FakeAttributes(['type' => 'number', 'name' => 'age']),
				new Validation\FakeRule(null, new \DomainException('Foo'))
			))->render()
		);
	}
}

(new DefaultInput())->run();