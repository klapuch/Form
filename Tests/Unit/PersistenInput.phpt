<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\{
	Form, Validation
};
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class PersistentInput extends Tester\TestCase {
	public function testRenderingKnownAttributes() {
		$storage = [];
		Assert::same(
			'<input type="text" name="surname"/>',
			(new Form\PersistentInput(
				['type' => 'text', 'name' => 'surname'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testRenderingUnknownAttributes() {
		$storage = [];
		Assert::same(
			'<input foo="bar" name="surname"/>',
			(new Form\PersistentInput(
				['foo' => 'bar', 'name' => 'surname'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testPassingValue() {
		$storage = ['surname' => 'myself'];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\PersistentInput(
				['foo' => 'bar', 'name' => 'surname'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testValidating() {
		$backup = ['surname' => 'myself'];
		Assert::exception(function() use($backup) {
			(new Form\PersistentInput(
				['type' => 'text', 'name' => 'surname'],
				new Form\Backup($backup, ['surname' => 'FOO']),
				new Validation\FakeRule(null, new \DomainException('foo'))
			))->validate();
			Assert::same('FOO', $backup['surname']);
		}, \DomainException::class, 'foo');
		Assert::noError(function() use($backup) {
			(new Form\PersistentInput(
				['type' => 'text', 'name' => 'surname'],
				new Form\Backup($backup, ['surname' => 'BAR']),
				new Validation\FakeRule(null, null)
			))->validate();
			Assert::same('BAR', $backup['surname']);
		});
	}

	public function testValidatingWithEmptyAttributes() {
		$backup = ['surname' => 'myself'];
		Assert::noError(function() use($backup) {
			(new Form\PersistentInput(
				[],
				new Form\Backup($backup, ['surname' => 'BAR']),
				new Validation\FakeRule(null, null)
			))->validate();
		});
	}

	public function testIgnoredBackups() {
		$backup = ['surname' => 'myself'];
		(new Form\PersistentInput(
			['type' => 'password', 'name' => 'surname'],
			new Form\Backup($backup, ['surname' => 'FOO']),
			new Validation\FakeRule()
		))->validate();
		Assert::same('myself', $backup['surname']);
	}

	public function testIgnoredBackupsWithStrictChecking() {
		$backup = ['surname' => 'myself'];
		(new Form\PersistentInput(
			['type' => 'true', 'name' => 'surname'],
			new Form\Backup($backup, ['surname' => 'FOO']),
			new Validation\FakeRule()
		))->validate();
		Assert::same('FOO', $backup['surname']);
	}

	public function testPassingStatedValue() {
		$storage = [];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\PersistentInput(
				['foo' => 'bar', 'name' => 'surname', 'value' => 'myself'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testOverwritingValue() {
		$storage = ['surname' => 'myself'];
		Assert::same(
			'<input foo="bar" name="surname" value="myself"/>',
			(new Form\PersistentInput(
				['foo' => 'bar', 'name' => 'surname', 'value' => 'you'],
				new Form\Backup($storage, []),
				new Validation\FakeRule()
			))->render()
		);
	}
}

(new PersistentInput())->run();