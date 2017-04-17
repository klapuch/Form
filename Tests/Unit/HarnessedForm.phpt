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

final class HarnessedForm extends Tester\TestCase {
	public function testFlow() {
		ob_start();
		(new Form\HarnessedForm(
			new class implements Form\Control {
				public function render(): string {}
				public function validate(): void {
					echo 'a';
				}
			},
			new class implements Form\Storage {
				public function offsetExists($offset) {}
				public function offsetGet($offset) {}
				public function offsetSet($offset, $value) {}
				public function offsetUnset($offset) {}
				public function archive($name): void {}
				public function drop(): void {
					echo 'b';
				}
			},
			function() {
				echo 'c';
			}
		))->validate();
		Assert::same('acb', ob_get_clean());
	}
}

(new HarnessedForm())->run();