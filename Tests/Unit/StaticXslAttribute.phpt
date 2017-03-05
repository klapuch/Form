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

final class StaticXslAttribute extends Tester\TestCase {
	public function testTextAttribute() {
		$attribute = new Form\StaticXslAttribute('value', 'Foo');
		Assert::same('value', $attribute->name());
		Assert::same('Foo', $attribute->value());
		Assert::same(
			'<xsl:attribute name="value"><xsl:text>Foo</xsl:text></xsl:attribute>',
			$attribute->element()->markup()
		);
	}
}

(new StaticXslAttribute())->run();