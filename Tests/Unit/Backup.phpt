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

final class Backup extends Tester\TestCase {
	public function testNoDirectSetting() {
		$backup = ['id' => 'USER ID!'];
		$storage = new Form\Backup($backup, []);
		Assert::null($storage['id']);
		$storage['id'] = 'foo';
		Assert::same('foo', $storage['id']);
		Assert::same('USER ID!', $backup['id']);
	}

	public function testIgnoringUnnamedIndex() {
		$backup = [];
		$storage = new Form\Backup($backup, []);
		$storage[] = 'foo';
		Assert::count(0, $backup);
	}

	public function testNamedIndex() {
		Assert::noError(function() {
			$backup = [];
			$storage = new Form\Backup($backup, []);
			$storage['foo'] = 'foo';
		});
	}

	public function testGetting() {
		$backup = [];
		$storage = new Form\Backup($backup, []);
		$storage['bar'] = 'foo';
		Assert::null($storage['foo']);
		Assert::same('foo', $storage['bar']);
	}

	public function testGettingWithSourcePrecedence() {
		$backup = ['foo' => 'backup'];
		$source = ['foo' => 'source'];
		$storage = new Form\Backup($backup, $source);
		Assert::same('source', $storage['foo']);
	}

	public function testUnsetingFromStorage() {
		$backup = [];
		$storage = new Form\Backup($backup, ['bar' => 'baz']);
		unset($storage['foo']);
		unset($storage['bar']);
		Assert::null($storage['foo']);
		Assert::same('baz', $storage['bar']);
	}

	public function testCheckingExistence() {
		$backup = [];
		$storage = new Form\Backup($backup, []);
		$storage['foo'] = 'xxx';
		Assert::true(isset($storage['foo']));
		unset($storage['foo']);
		Assert::false(isset($storage['foo']));
	}

	public function testAffectingOriginStorage() {
		$backup = [];
		$storage = new Form\Backup($backup, []);
		$storage['foo'] = 'bar';
		Assert::notSame([], $backup);
	}

	public function testBackup() {
		$backup = [];
		$source = ['a' => '1', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage['foo'] = 'bar';
		$storage->archive('a');
		Assert::count(2, current($backup));
		Assert::same('bar', $storage['foo']);
		Assert::same('1', $storage['a']);
	}

	public function testBackupWithOverwriting() {
		$backup = [];
		$source = ['foo' => 'baz', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage['foo'] = 'bar';
		$storage->archive('foo');
		Assert::count(1, current($backup));
		Assert::same('baz', $storage['foo']);
	}

	public function testBackupUnknownSource() {
		$backup = [];
		$source = ['foo' => 'baz', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage['foo'] = 'bar';
		$storage->archive('c');
		Assert::count(2, current($backup));
		Assert::same('baz', $storage['foo']);
		Assert::null($storage['c']);
	}

	public function testDroppingSources() {
		$backup = [];
		$source = ['a' => '1', 'b' => '2'];
		$storage = new Form\Backup($backup, $source);
		$storage['foo'] = 'bar';
		$storage['a'] = '1';
		$storage['c'] = '4';
		$storage['b'] = time();
		Assert::count(4, current($backup));
		$storage->drop();
		Assert::count(2, current($backup));
		Assert::same('bar', $storage['foo']);
		Assert::same('4', $storage['c']);
	}

	public function testIgnoringArchivingForSpecificKeys() {
		$backup = [];
		$source = ['password' => 'heslo'];
		$storage = new Form\Backup($backup, $source);
		$storage->archive('password');
		$storage->password = 'heslo';
		Assert::count(0, $backup);
	}

	public function testIgnoringArchivingForSpecificKeysWithStrictCheck() {
		$backup = [];
		$source = ['true' => 'heslo'];
		$storage = new Form\Backup($backup, $source);
		$storage->archive(true);
		$storage->true = 'heslo';
		Assert::count(1, $backup);
	}
}

(new Backup())->run();