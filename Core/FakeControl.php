<?php
declare(strict_types = 1);
namespace Klapuch\Form;

final class FakeControl implements Control {
	private $output;
	private $exception;

	public function __construct(
		string $output = null,
		\Throwable $exception = null
	) {
		$this->output = $output;
		$this->exception = $exception;
	}

	public function render(): string {
		return $this->output;
	}

	public function validate(): void {
		if ($this->exception !== null)
			throw $this->exception;
	}
}