<?php declare(strict_types = 1);

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
	 * @param keyType $key
	 * @param callable(): T $callback
	 * @return T
	 *
	 * @template T
	 */
	final protected function memoize(
		$key,
		callable $callback,
		int|DateInterval|null $ttl = null,
	)
	{
		return Helper::resolveValue($this->internalCache(), $key, $callback, $ttl);
	}

	protected function internalCache(): CacheInterface
	{
		return $this->_internalCache ??= Helper::createCache();
	}

}
