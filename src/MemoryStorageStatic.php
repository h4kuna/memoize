<?php declare(strict_types=1);

namespace h4kuna\Memoize;

/**
 * @phpstan-import-type keyType from Helper
 */
trait MemoryStorageStatic
{
	/** @var array<string, StorageInterface> */
	private static array $internalStorageStatic = [];

	/**
	 * @template T
	 * @param keyType       $key
	 * @param callable(): T $callback
	 *
	 * @return T
	 */
	final protected static function memoize($key, callable $callback)
	{
		return Helper::resolveValue(self::getInternalStaticStorage(), $key, $callback);
	}

	final protected static function getInternalStaticStorage(): StorageInterface
	{
		return self::$internalStorageStatic[static::class] ??= Helper::createStorage();
	}

}
