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

final class Backup extends Tester\TestCase {
	/**
	 * @throws \InvalidArgumentException Offset must be named
	 */
	public function testUnnamedIndex() {
		$storage = [];
		$backup = new Form\Backup($storage);
		$backup[] = 'foo';
	}

	public function testNamedIndex() {
		Assert::noError(function() {
			$storage = [];
			$backup = new Form\Backup($storage);
			$backup['foo'] = 'foo';
		});
	}

	public function testGetting() {
		$storage = ['foo' => 'bar'];
		$backup = new Form\Backup($storage);
		$backup['bar'] = 'foo';
		Assert::same('bar', $backup['foo']);
		Assert::same('foo', $backup['bar']);
	}

	public function testUnseting() {
		$storage = ['foo' => 'bar'];
		$backup = new Form\Backup($storage);
		Assert::same('bar', $backup['foo']);
		unset($backup['foo']);
		Assert::null($backup['foo']);
	}

	public function testCheckingExistence() {
		$storage = ['foo' => 'bar'];
		$backup = new Form\Backup($storage);
		Assert::true(isset($backup['foo']));
		unset($backup['foo']);
		Assert::false(isset($backup['foo']));
	}

	public function testAffectingOriginStorage() {
		$storage = ['foo' => 'bar'];
		$backup = new Form\Backup($storage);
		unset($backup['foo']);
		Assert::same([], $storage);
	}
}

(new Backup())->run();
