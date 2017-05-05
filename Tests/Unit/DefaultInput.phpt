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
	public function testPassingStatedValue() {
		$storage = [];
		Assert::same(
			'<input name="surname" value="myself"/>',
			(new Form\DefaultInput(
				['name' => 'surname', 'value' => 'myself'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testOverwritingValueByBackup() {
		$storage = ['surname' => 'myself'];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\DefaultInput(
				['foo' => 'bar', 'name' => 'surname'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testAllowingRenderingWithoutNameField() {
		$storage = [];
		Assert::noError(function() use ($storage) {
			(new Form\DefaultInput(
				['value' => 'myself'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render();
		});
	}

	public function testRemovingBackupValueAfterPresenting() {
		$storage = ['surname' => 'myself'];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\DefaultInput(
				['foo' => 'bar', 'name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
		Assert::same(
			'<input foo="bar" name="surname" value="you"/>',
			(new Form\DefaultInput(
				['foo' => 'bar', 'name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testValidatingWithSentValueWithFault() {
		$backup = [];
		Assert::exception(function() use ($backup) {
			(new Form\DefaultInput(
				['type' => 'text', 'name' => 'surname'],
				new Form\Backup($backup, ['surname' => 'FOO']),
				new Validation\FakeRule(null, new \DomainException('foo'))
			))->validate();
		}, \DomainException::class, 'foo');
	}

	public function testValidatingWithSentValueWithoutFault() {
		$backup = [];
		Assert::noError(function() use ($backup) {
			(new Form\DefaultInput(
				['type' => 'text', 'name' => 'surname'],
				new Form\Backup($backup, ['surname' => 'FOO']),
				new Validation\FakeRule(null, null)
			))->validate();
		});
	}

	/**
	 * @throws \UnexpectedValueException Field "surname" is missing in sent data
	 */
	public function testThrowingOnNoPostedDataDuringValidation() {
		$backup = [];
		(new Form\DefaultInput(
			['name' => 'surname'],
			new Form\Backup($backup, []),
			new Validation\FakeRule(null, new \DomainException('foo'))
		))->validate();
	}

	/**
	 * @throws \UnexpectedValueException Field "surname" is missing in sent data
	 */
	public function testThrowingOnMissingFieldDuringValidation() {
		$backup = [];
		(new Form\DefaultInput(
			['name' => 'surname'],
			new Form\Backup($backup, ['foo' => 'bar']),
			new Validation\FakeRule(null, new \DomainException('foo'))
		))->validate();
	}

	public function testReloadingStatedValueAfterWrongValidation() {
		$storage = [];
		Assert::same(
			'<input name="surname" value="you"/>',
			(new Form\DefaultInput(
				['name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
		Assert::exception(
			function() use (&$storage) {
				(new Form\DefaultInput(
					['name' => 'surname', 'value' => 'bar'],
					new Form\Backup($storage, ['surname' => 'bar']),
					new Validation\FakeRule(null, new \DomainException('foo'))
				))->validate();
			},
			\DomainException::class
		);
		Assert::same(
			'<input name="surname" value="bar"/>',
			(new Form\DefaultInput(
				['name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testReloadAfterSuccessValidation() {
		$storage = [];
		Assert::same(
			'<input name="surname" value="you"/>',
			(new Form\DefaultInput(
				['name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
		(new Form\DefaultInput(
			['name' => 'surname', 'value' => 'bar'],
			new Form\Backup($storage, ['surname' => 'bar']),
			new Validation\FakeRule(null, null)
		))->validate();
		Assert::same(
			'<input name="surname" value="bar"/>',
			(new Form\DefaultInput(
				['name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}
}

(new DefaultInput())->run();