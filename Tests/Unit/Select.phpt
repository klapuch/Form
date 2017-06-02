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

final class Select extends Tester\TestCase {
	/**
	 * @throws \DomainException Foo
	 */
	public function testValidationUsingOptions() {
		(new Form\Select(
			new Form\FakeAttributes(['name' => 'fruit']),
			new Form\Option(
				new Form\FakeAttributes(['value' => 'good']),
				'apple',
				new Validation\FakeRule(false, new \DomainException('Foo'))
			),
			new Form\Option(
				new Form\FakeAttributes(['value' => 'bad']),
				'cherry',
				new Validation\FakeRule(false, new \DomainException('Bar'))
			)
		))->validate();
	}

	public function testSafeRendering() {
		Assert::same(
			'<select name="fruit"><option value="good">apple&lt;&gt;</option><option value="bad">cherry</option></select>',
			(new Form\Select(
				new Form\FakeAttributes(['name' => 'fruit']),
				new Form\Option(
					new Form\FakeAttributes(['value' => 'good']),
					'apple<>',
					new Validation\FakeRule(false)
				),
				new Form\Option(
					new Form\FakeAttributes(['value' => 'bad']),
					'cherry',
					new Validation\FakeRule(false)
				)
			))->render()
		);
	}
}

(new Select())->run();