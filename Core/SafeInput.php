<?php
declare(strict_types = 1);
namespace Klapuch\Form;

use Klapuch\{
	Markup, Validation
};

/**
 * Safe input
 */
final class SafeInput implements Control {
	private $attributes;
	private $backup;
	private $rule;
	private const IGNORED_BACKUPS = [
		'password',
	];

	public function __construct(
		array $attributes,
		Backup $backup,
		Validation\Rule $rule
	) {
		$this->attributes = $attributes;
		$this->backup = $backup;
		$this->rule = $rule;
	}

	public function render(): string {
		$name = $this->attributes['name'] ?? null;
		if(isset($this->backup[$name]))
			$this->attributes['value'] = $this->backup[$name];
		unset($this->backup[$name]);
		return (new Markup\NormalizedElement(
			new Markup\HtmlTag('input', $this->attributes()),
			new Markup\EmptyElement()
		))->markup();
	}

	public function validate(): void {
		[$type, $name] = [
			$this->attributes['type'] ?? null,
			$this->attributes['name'] ?? null,
		];
		if(isset($this->backup[$name]))
			$this->rule->apply($this->backup[$name]);
		if(!in_array($type, self::IGNORED_BACKUPS, true))
			$this->backup->archive($name);
	}

	private function attributes(): Markup\Attributes {
		return new Markup\HtmlAttributes(
			...array_map(
				function(string $name, string $value): Markup\Attribute {
					return new Markup\HtmlAttribute($name, $value);
				},
				array_keys($this->attributes),
				$this->attributes
			)
		);
	}
}