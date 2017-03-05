<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Form\Unit;

use Klapuch\{
	Form, Validation
};
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class XslInput extends Tester\TestCase {
	public function testSingleAttribute() {
		Assert::same(
			'<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"><xsl:element name="input"><xsl:attribute name="value"><xsl:value-of select="//p"/></xsl:attribute></xsl:element></xsl:stylesheet>',
			(new Form\XslInput(
				[new Form\DynamicXslAttribute('value', '//p')]
			))->render()
		);
	}

	public function testChainedMultipleAttributes() {
		Assert::same(
			'<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"><xsl:element name="input"><xsl:attribute name="value"><xsl:value-of select="//p"/></xsl:attribute><xsl:attribute name="type"><xsl:value-of select="text"/></xsl:attribute></xsl:element></xsl:stylesheet>',
			(new Form\XslInput(
				[
					new Form\DynamicXslAttribute('value', '//p'),
					new Form\DynamicXslAttribute('type', 'text')
				]
			))->render()
		);
	}
}

(new XslInput())->run();