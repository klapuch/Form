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

final class XmlReloadedInput extends Tester\TestCase {
	public function testReloadingInsideRoot() {
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="last_update" value="now"/>',
			(new Form\XmlReloadedInput(['name' => 'last_update'], $dom))->render()
		);
	}

	public function testCaseSensitiveReloading() {
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="LAST_update"/>',
			(new Form\XmlReloadedInput(['name' => 'LAST_update'], $dom))->render()
		);
	}

	public function testRewritingValueByReloading() {
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="last_update" value="now"/>',
			(new Form\XmlReloadedInput(['name' => 'last_update', 'value' => 'foo'], $dom))->render()
		);
	}
}

(new XmlReloadedInput())->run();