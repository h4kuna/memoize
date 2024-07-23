<?php declare(strict_types=1);

namespace h4kuna\Memoize\Storage;

use h4kuna\Memoize\StorageInterface;

final class Memory implements StorageInterface
{
	/** @var array<string, mixed> */
	private array $data = [];

	public function offsetExists($offset): bool
	{
		return array_key_exists($offset, $this->data);
	}

	public function offsetGet($offset): mixed
	{
		return $this->data[$offset];
	}

	public function offsetSet($offset, $value): void
	{
		$this->data[$offset] = $value;
	}

	public function offsetUnset($offset): void
	{
		unset($this->data[$offset]);
	}

	public function clear(): void
	{
		$this->data = [];
	}
}
