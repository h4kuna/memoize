<?php declare(strict_types=1);

namespace h4kuna\Memoize;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

/**
 * @phpstan-import-type keyType from Helper
 */
trait Memoize
{
	private ?CacheInterface $_internalCache = null;

	/**
	 * @template T
	 * @param keyType       $key
	 * @param callable(): T $callback
	 *
	 * @return T
	 */
	final protected function memoize($key, callable $callback, null|int|DateInterval $ttl = null)
	{
		return Helper::resolveValue($this->internalCache(), $key, $callback, $ttl);
	}

	protected function internalCache(): CacheInterface
	{
		return $this->_internalCache ??= Helper::createCache();
	}

}
