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

final class XmlDynamicValue extends Tester\TestCase {
	public function testReloadingFromInsideRoot() {
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same('now', (string)new Form\XmlDynamicValue('last_update', $dom));
	}

	public function testCaseSensitiveReloading() {
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same('', (string)new Form\XmlDynamicValue('LAST_update', $dom));
	}

	public function testNoValueOnNoRelatedXmlElement() {
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same('', (string)new Form\XmlDynamicValue('foo', $dom));
	}
}

(new XmlDynamicValue())->run();