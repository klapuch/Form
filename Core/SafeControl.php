<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\Markup;

abstract class SafeControl implements Control {
	final protected function attribute(array $attributes): Markup\Attribute {
		return new Markup\ConcatenatedAttribute(
			...array_map(
				function(string $name) use($attributes): Markup\Attribute {
					return new Markup\SafeAttribute(
						$name,
						$attributes[$name]
					);
				},
				array_keys($attributes)
			)
		);
	}
}