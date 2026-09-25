<?php declare(strict_types = 1);

namespace h4kuna\Memoize\Cache;

use DateInterval;
use h4kuna\Memoize\Helper;
use Psr\SimpleCache\CacheInterface;
use RuntimeException;
use function array_key_exists;
use function time;

final class MemoryCache implements CacheInterface
{

	private const KEY_VALUE = 0;
	private const KEY_TTL = 1;

	/**
	 * @var array<string, array{mixed, ?int}>
	 */
	private array $data = [];

	public function get(
		string $key,
		mixed $default = null,
	): mixed
	{
		return $this->data[$key][self::KEY_VALUE] ?? $default;
	}

	public function has(string $key): bool
	{
		return array_key_exists($key, $this->data)
			&& ($this->data[$key][self::KEY_TTL] === null || $this->data[$key][self::KEY_TTL] >= time());
	}

	public function set(
		string $key,
		mixed $value,
		int|DateInterval|null $ttl = null,
	): bool
	{
		$this->data[$key] = [self::KEY_VALUE => $value, self::KEY_TTL => Helper::ttlToExpire($ttl)];

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

	public function getMultiple(
		iterable $keys,
		mixed $default = null,
	): iterable
	{
		throw new RuntimeException('Not implemented');
	}

	/**
	 * @param iterable<mixed> $values
	 */
	public function setMultiple(
		iterable $values,
		int|DateInterval|null $ttl = null,
	): bool
	{
		throw new RuntimeException('Not implemented');
	}

	public function deleteMultiple(iterable $keys): bool
	{
		throw new RuntimeException('Not implemented');
	}

}
