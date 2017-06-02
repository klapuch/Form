<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\Form;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class DependentAttributes extends Tester\TestCase {
	public function testAllAttributes() {
		$storage = [];
		Assert::same(
			['name' => 'age', 'type' => 'number', 'value' => 'abc'],
			(new Form\DependentAttributes(
				['name' => 'age', 'type' => 'number', 'value' => 'abc'],
				new Form\Backup($storage, []),
				'age'
			))->pairs()
		);
	}

	public function testMatchingValueCreatingNewAttribute() {
		$storage = ['age' => 'bar'];
		Assert::same(
			['name' => 'foo', 'type' => 'number', 'value' => 'bar', 'selected' => 'selected'],
			(new Form\DependentAttributes(
				['name' => 'foo', 'type' => 'number', 'value' => 'bar'],
				new Form\Backup($storage, []),
				'age'
			))->pairs()
		);
	}

	public function testStrictTypeMatching() {
		$storage = ['age' => 20];
		Assert::same(
			['name' => 'foo', 'type' => 'number', 'value' => '20'],
			(new Form\DependentAttributes(
				['name' => 'foo', 'type' => 'number', 'value' => '20'],
				new Form\Backup($storage, []),
				'age'
			))->pairs()
		);
	}

	public function testRemovingAfterSuccessfulMatchUse() {
		$storage = ['age' => '20'];
		(new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number', 'value' => '20'],
			new Form\Backup($storage, []),
			'age'
		))->pairs();
		Assert::same([], $storage);
	}

	public function testSameStorageValueAfterNotMatchingValue() {
		$storage = ['age' => '20'];
		(new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number', 'value' => '30'],
			new Form\Backup($storage, []),
			'age'
		))->pairs();
		Assert::notSame([], $storage);
	}

	public function testGetting() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number'],
			new Form\Backup($storage, []),
			''
		);
		Assert::same('age', $attributes['name']);
	}

	public function testGettingValueUsingStorage() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number'],
			new Form\Backup($storage, ['age' => '20']),
			''
		);
		Assert::same('20', $attributes['value']);
	}

	public function testThrowingOnMissingData() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number'],
			new Form\Backup($storage, ['foo' => '20']),
			''
		);
		Assert::exception(function() use ($attributes) {
			$foo = $attributes['value'];
		}, \UnexpectedValueException::class, 'Field "age" is missing in sent data');
	}

	public function testArchiving() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number', 'disabled' => 'true'],
			new Form\Backup($storage, ['age' => '20']),
			''
		);
		$foo = $attributes['value'];
		Assert::same(['age' => '20'], $storage);
	}

	public function testCheckingExistence() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number'],
			new Form\Backup($storage, []),
			''
		);
		Assert::false(isset($attributes['disabled']));
		Assert::true(isset($attributes['type']));
	}

	public function testSetting() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number'],
			new Form\Backup($storage, []),
			''
		);
		$attributes['disabled'] = 'true';
		Assert::same(['name' => 'age', 'type' => 'number', 'disabled' => 'true'], $attributes->pairs());
		$attributes['disabled'] = 'false';
		Assert::same(['name' => 'age', 'type' => 'number', 'disabled' => 'false'], $attributes->pairs());
	}

	public function testUnsetting() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['name' => 'age', 'type' => 'number'],
			new Form\Backup($storage, []),
			''
		);
		unset($attributes['disabled']);
		unset($attributes['type']);
		Assert::same(['name' => 'age'], $attributes->pairs());
	}

	public function testCaseSensitiveAttributes() {
		$storage = [];
		$attributes = new Form\DependentAttributes(
			['type' => 'number', 'TYPE' => 'text'],
			new Form\Backup($storage, []),
			''
		);
		Assert::same('number', $attributes['type']);
		Assert::same('text', $attributes['TYPE']);
		Assert::true(isset($attributes['type']));
		Assert::true(isset($attributes['TYPE']));
		unset($attributes['TYPE']);
		$attributes['TYPE'] = 'FOO';
		Assert::count(2, $attributes->pairs());
	}
}

(new DependentAttributes())->run();