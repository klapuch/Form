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
		$backup = [];
		$storage = new Form\Backup($backup, []);
		$storage[] = 'foo';
	}

	public function testNamedIndex() {
		Assert::noError(function() {
			$backup = [];
			$storage = new Form\Backup($backup, []);
			$storage['foo'] = 'foo';
		});
	}

	public function testGetting() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Backup($backup, []);
		$storage['bar'] = 'foo';
		Assert::same('bar', $storage['foo']);
		Assert::same('foo', $storage['bar']);
	}

	public function testSourceWithPrecedence() {
		$backup = ['foo' => 'backup'];
		$source = ['foo' => 'source'];
		$storage = new Form\Backup($backup, $source);
		Assert::same('source', $storage['foo']);
	}

	public function testUnseting() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Backup($backup, []);
		Assert::same('bar', $storage['foo']);
		unset($storage['foo']);
		Assert::null($storage['foo']);
	}

	public function testCheckingExistence() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Backup($backup, []);
		Assert::true(isset($storage['foo']));
		unset($storage['foo']);
		Assert::false(isset($storage['foo']));
	}

	public function testAffectingOriginStorage() {
		$backup = ['foo' => 'bar'];
		$storage = new Form\Backup($backup, []);
		unset($storage['foo']);
		Assert::same([], $backup);
	}

	public function testBackup() {
		$backup = ['foo' => 'bar'];
		$source = ['a' => '1', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage->archive('a');
		Assert::count(2, $backup);
		Assert::same('bar', $storage['foo']);
		Assert::same('1', $storage['a']);
	}

	public function testBackupWithOverwriting() {
		$backup = ['foo' => 'bar'];
		$source = ['foo' => 'baz', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage->archive('foo');
		Assert::count(1, $backup);
		Assert::same('baz', $storage['foo']);
	}

	public function testBackupUnknownSource() {
		$backup = ['foo' => 'bar'];
		$source = ['foo' => 'baz', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage->archive('c');
		Assert::count(2, $backup);
		Assert::same('baz', $storage['foo']);
		Assert::null($storage['c']);
	}

	public function testDroppingSources() {
		$backup = ['foo' => 'bar'];
		$source = ['a' => '1', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		Assert::count(1, $backup);
		$storage->drop();
		Assert::count(0, $backup);
	}
}

(new Backup())->run();