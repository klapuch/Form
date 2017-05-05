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

final class LinkedLabel extends Tester\TestCase {
	public function testFreeLabel() {
		Assert::same(
			'<label>Cool</label>',
			(new Form\LinkedLabel('Cool'))->render()
		);
	}

	public function testBindLabel() {
		Assert::same(
			'<label for="surname">Cool</label>',
			(new Form\LinkedLabel('Cool', 'surname'))->render()
		);
	}
}

(new LinkedLabel())->run();