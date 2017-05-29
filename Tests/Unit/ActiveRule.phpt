<?php
declare(strict_types = 1);
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

final class ActiveRule extends Tester\TestCase {
	public function testActiveRuleForNotDisabledAttribute() {
		$true = new Form\ActiveRule(
			new Validation\FakeRule(true, new \DomainException('Foo')),
			new Form\FakeAttributes([])
		);
		$false = new Form\ActiveRule(
			new Validation\FakeRule(false, new \DomainException('Foo')),
			new Form\FakeAttributes([])
		);
		Assert::true($true->satisfied(null));
		Assert::noError(function() use ($true) {
			$true->apply(null);
		});
		Assert::exception(function() use ($false) {
			$false->apply(null);
		}, \DomainException::class, 'Foo');
		Assert::false($false->satisfied(null));
	}

	public function testNotActiveRuleForDisabledAttribute() {
		$true = new Form\ActiveRule(
			new Validation\FakeRule(true, new \DomainException('Foo')),
			new Form\FakeAttributes(['disabled' => true])
		);
		$false = new Form\ActiveRule(
			new Validation\FakeRule(false, new \DomainException('Foo')),
			new Form\FakeAttributes(['disabled' => true])
		);
		Assert::true($true->satisfied(null));
		Assert::noError(function() use ($true) {
			$true->apply(null);
		});
		Assert::true($false->satisfied(null));
		Assert::noError(function() use ($false) {
			$false->apply(null);
		});
	}
}

(new ActiveRule())->run();