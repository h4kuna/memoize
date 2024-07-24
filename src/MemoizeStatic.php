<?php declare(strict_types=1);

namespace h4kuna\Memoize;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

/**
 * @phpstan-import-type keyType from Helper
 */
trait MemoizeStatic
{
	/** @var array<string, CacheInterface> */
	private static array $_internalCaches = [];

	/**
	 * @template T
	 * @param keyType       $key
	 * @param callable(): T $callback
	 *
	 * @return T
	 */
	final protected static function memoize($key, callable $callback, null|int|DateInterval $ttl = null)
	{
		return Helper::resolveValue(static::staticInternalCache(), $key, $callback, $ttl);
	}

	protected static function staticInternalCache(): CacheInterface
	{
		return self::$_internalCaches[static::class] ??= Helper::createCache();
	}

}
