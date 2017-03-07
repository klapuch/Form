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

final class DynamicXslAttribute extends Tester\TestCase {
	public function testXPathAttribute() {
		$attribute = new Form\DynamicXslAttribute('value', '//foo');
		Assert::same('value', $attribute->name());
		Assert::same('//foo', $attribute->value());
		Assert::same(
			'<xsl:attribute name="value"><xsl:value-of select="//foo"/></xsl:attribute>',
			$attribute->element()->markup()
		);
	}

	public function testVariableAttribute() {
		$attribute = new Form\DynamicXslAttribute('value', '$foo');
		Assert::same('value', $attribute->name());
		Assert::same('$foo', $attribute->value());
		Assert::same(
			'<xsl:attribute name="value"><xsl:value-of select="$foo"/></xsl:attribute>',
			$attribute->element()->markup()
		);
	}

	public function testXssProtection() {
		$attribute = new Form\DynamicXslAttribute('<">', '<">');
		Assert::same('<">', $attribute->name());
		Assert::same('<">', $attribute->value());
		Assert::same(
			'<xsl:attribute name="&lt;&quot;&gt;"><xsl:value-of select="&lt;&quot;&gt;"/></xsl:attribute>',
			$attribute->element()->markup()
		);
	}
}

(new DynamicXslAttribute())->run();