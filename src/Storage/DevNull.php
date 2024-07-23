<?php declare(strict_types=1);

namespace h4kuna\Memoize\Storage;

use h4kuna\Memoize\StorageInterface;

final class DevNull implements StorageInterface
{
	private mixed $value;

	public function offsetExists($offset): bool
	{
		return false;
	}

	public function offsetGet($offset): mixed
	{
		return $this->value;
	}

	public function offsetSet($offset, $value): void
	{
		$this->value = $value;
	}

	public function offsetUnset($offset): void
	{
	}

	public function clear(): void
	{
	}
}
