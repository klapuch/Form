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

final class BootstrapInput extends Tester\TestCase {
	public function testWrappingToBootstrap() {
		Assert::same(
			'<div class="form-group"><div class="col-sm-5"><input/></div></div>',
			(new Form\BootstrapInput(
				new Form\FakeControl('<input/>'),
				5
			))->render()
		);
	}
}

(new BootstrapInput())->run();