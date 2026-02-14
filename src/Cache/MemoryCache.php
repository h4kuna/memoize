<?php declare(strict_types=1);

namespace h4kuna\Memoize\Cache;

use DateInterval;
use h4kuna\Memoize\Helper;
use Psr\SimpleCache\CacheInterface;
use RuntimeException;

final class MemoryCache implements CacheInterface
{
	private const KeyValue = 0;
	private const KeyTtl = 1;

	/** @var array<string, array{mixed, ?int}> */
	private array $data = [];

	public function get(string $key, mixed $default = null): mixed
	{
		return $this->data[$key][self::KeyValue] ?? $default;
	}

	public function has(string $key): bool
	{
		return array_key_exists($key, $this->data)
			&& ($this->data[$key][self::KeyTtl] === null || $this->data[$key][self::KeyTtl] >= time());
	}

	public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
	{
		$this->data[$key] = [self::KeyValue => $value, self::KeyTtl => Helper::ttlToExpire($ttl)];

		return true;
	}

	public function delete(string $key): bool
	{
		unset($this->data[$key]);

		return true;
	}

	public function clear(): bool
	{
		$this->data = [];

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
}
