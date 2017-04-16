<?php
declare(strict_types = 1);
namespace Klapuch\Form;

/**
 * Form harnessed by callbacks
 */
final class HarnessedForm implements Control {
	private $storage;
	private $origin;
	private $onSuccess;

	public function __construct(
		Control $origin,
		Storage $storage,
		callable $onSuccess
	) {
		$this->storage = $storage;
		$this->origin = $origin;
		$this->onSuccess = $onSuccess;
	}

	public function render(): string {
		return $this->origin->render();
	}

	public function validate(): void {
		$this->origin->validate();
		$this->storage->drop();
		($this->onSuccess)();
	}
}