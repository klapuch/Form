<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\Form;
use Klapuch\Validation;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class XmlReloadedInput extends Tester\TestCase {
	public function testReloadingInsideRoot() {
		$backup = [];
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="last_update" value="now"/>',
			(new Form\XmlReloadedInput(
				['name' => 'last_update'],
				$dom,
				new Form\Backup($backup, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testCaseSensitiveReloading() {
		$backup = [];
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="LAST_update"/>',
			(new Form\XmlReloadedInput(
				['name' => 'LAST_update'],
				$dom,
				new Form\Backup($backup, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testNoValueOnNoRelatedXmlElement() {
		$backup = [];
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="foo"/>',
			(new Form\XmlReloadedInput(
				['name' => 'foo'],
				$dom,
				new Form\Backup($backup, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testRewritingValueByReloading() {
		$backup = [];
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="last_update" value="now"/>',
			(new Form\XmlReloadedInput(
				['name' => 'last_update', 'value' => 'foo'],
				$dom,
				new Form\Backup($backup, []),
				new Validation\FakeRule()
			))->render()
		);
	}

	public function testRewritingReloadedValueByStoredOne() {
		$backup = [];
		$dom = new \DOMDocument();
		$dom->loadXML('<root><last_update>now</last_update></root>');
		Assert::same(
			'<input name="last_update" value="foo"/>',
			(new Form\XmlReloadedInput(
				['name' => 'last_update'],
				$dom,
				new Form\Backup($backup, ['last_update' => 'foo']),
				new Validation\FakeRule()
			))->render()
		);
	}
}

(new XmlReloadedInput())->run();