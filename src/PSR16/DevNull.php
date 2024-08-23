<?php declare(strict_types=1);

namespace h4kuna\Memoize\PSR16;

use DateInterval;
use Psr\SimpleCache\CacheInterface;
use RuntimeException;

final class DevNull implements CacheInterface
{
	private mixed $value = null;

	public function get(string $key, mixed $default = null): mixed
	{
		return $this->value ?? $default;
	}

	public function delete(string $key): bool
	{
		$this->set($key, null);

		return true;
	}

	public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
	{
		$this->value = $value;

		return true;
	}

	public function clear(): bool
	{
		$this->value = null;

		return true;
	}

	public function getMultiple(iterable $keys, mixed $default = null): iterable
	{
		throw new RuntimeException('Not implemented');
	}

	/**
	 * @param iterable<mixed> $values
	 */
	public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
	{
		throw new RuntimeException('Not implemented');
	}

	public function deleteMultiple(iterable $keys): bool
	{
		throw new RuntimeException('Not implemented');
	}

	public function has(string $key): bool
	{
		return false;
	}
}
