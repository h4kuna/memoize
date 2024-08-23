<?php declare(strict_types=1);

namespace h4kuna\Memoize\PSR16;

use DateInterval;
use Generator;
use h4kuna\Memoize\Helper;
use Psr\SimpleCache\CacheInterface;

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
		$this->data[$key] = [self::KeyValue => $value, self::KeyTtl => Helper::ttlToSeconds($ttl)];

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

	/**
	 * @param iterable<string> $keys
	 *
	 * @return Generator<string, mixed>
	 */
	public function getMultiple(iterable $keys, mixed $default = null): Generator
	{
		foreach ($keys as $key) {
			yield $key => $this->get($key, $default);
		}
	}

	/**
	 * @param iterable<string, mixed> $values
	 */
	public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
	{
		foreach ($values as $key => $value) {
			$this->set($key, $value, $ttl);
		}

		return true;
	}

	public function deleteMultiple(iterable $keys): bool
	{
		foreach ($keys as $key) {
			$this->delete($key);
		}

		return true;
	}
}
