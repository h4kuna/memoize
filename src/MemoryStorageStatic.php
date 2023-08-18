<?php declare(strict_types=1);

namespace h4kuna\Memoize;

trait MemoryStorageStatic
{
	/** @var array<string, array<string, mixed>> */
	private static array $memoryStorageStatic = [];


	/**
	 * @template T
	 * @param string|int|float|array<string|int|float> $key - keyType
	 * @param callable(): T $callback
	 * @return T
	 */
	final protected static function memoize($key, callable $callback)
	{
		$key = Helpers::resolveKey($key);
		$class = static::class;
		if (isset(self::$memoryStorageStatic[$class]) === false || array_key_exists($key, self::$memoryStorageStatic[$class]) === false) {
			return self::$memoryStorageStatic[$class][$key] = $callback();
		}

		return self::$memoryStorageStatic[$class][$key];
	}

}
