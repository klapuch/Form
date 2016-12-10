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

final class Storage extends Tester\TestCase {
	/**
	 * @throws \InvalidArgumentException Offset must be named
	 */
	public function testUnnamedIndex() {
		$backup = [];
		$storage = new Form\Storage($backup, []);
		$storage[] = 'foo';
	}

	public function testNamedIndex() {
		Assert::noError(function() {
			$backup = [];
			$storage = new Form\Storage($backup, []);
			$storage['foo'] = 'foo';
		});
	}

	public function testGetting() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Storage($backup, []);
		$storage['bar'] = 'foo';
		Assert::same('bar', $storage['foo']);
		Assert::same('foo', $storage['bar']);
	}

	public function testSourceWithPrecedence() {
		$backup = ['foo' => 'backup'];
		$source = ['foo' => 'source'];
		$storage = new Form\Storage($backup, $source);
		Assert::same('source', $storage['foo']);
	}

	public function testUnseting() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Storage($backup, []);
		Assert::same('bar', $storage['foo']);
		unset($storage['foo']);
		Assert::null($storage['foo']);
	}

	public function testCheckingExistence() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Storage($backup, []);
		Assert::true(isset($storage['foo']));
		unset($storage['foo']);
		Assert::false(isset($storage['foo']));
	}

	public function testAffectingOriginStorage() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Storage($backup, []);
		unset($storage['foo']);
		Assert::same([], $backup);
	}
}

(new Storage())->run();