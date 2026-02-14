<?php declare(strict_types=1);

namespace h4kuna\Memoize;

use DateInterval;
use DateTime;
use h4kuna\Memoize\PSR16\DevNull;
use h4kuna\Memoize\PSR16\MemoryCache;
use Psr\SimpleCache\CacheInterface;

/**
 * @phpstan-type keyType string|int|float|array<string|int|float>
 */
final class Helper
{
	/** @var class-string<CacheInterface>|(callable(): CacheInterface) */
	public static $class = MemoryCache::class;
	public static string $delimiter = "\x00";

	/**
	 * @param keyType $key
	 */
	public static function resolveValue(CacheInterface $cache, $key, callable $callback, null|int|DateInterval $ttl = null): mixed
	{
		$key = self::buildKey($key);
		if ($cache->has($key) === false) {
			$cache->set($key, $callback(), $ttl);
		}

		return $cache->get($key);
	}

	/**
	 * @param keyType $key
	 */
	public static function buildKey($key): string
	{
		return is_array($key) ? implode(self::$delimiter, $key) : (string) $key;
	}


	/**
	 * This is only for tests
	 */
	public static function bypassMemoize(): void
	{
		if (Helper::$class !== DevNull::class) {
			Helper::$class = DevNull::class;
		}
	}

	public static function createCache(): CacheInterface
	{
		$object = is_string(Helper::$class) ? new Helper::$class() : (Helper::$class)();
		assert($object instanceof CacheInterface);

		return $object;
	}


	public static function ttlToExpire(null|int|DateInterval $ttl = null): ?int
	{
		if ($ttl === null) {
			return null;
		} elseif ($ttl instanceof DateInterval) {
			return (new DateTime)->add($ttl)->getTimestamp();
		}

		return $ttl + time();
	}

}
