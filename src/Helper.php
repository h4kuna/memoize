<?php declare(strict_types=1);

namespace h4kuna\Memoize;

use h4kuna\Memoize\Storage\DevNull;
use h4kuna\Memoize\Storage\Memory;

/**
 * @phpstan-type keyType string|int|float|array<string|int|float>
 */
final class Helper
{
	/** @var class-string<StorageInterface>|(callable(): StorageInterface) */
	public static $class = Memory::class;
	public static string $delimiter = "\x00";

	/**
	 * @param keyType $key
	 */
	public static function resolveValue(StorageInterface $storage, $key, callable $callback): mixed
	{
		$key = is_array($key) ? implode(self::$delimiter, $key) : (string) $key;
		if ($storage->offsetExists($key) === false) {
			$storage->offsetSet($key, $callback());
		}

		return $storage->offsetGet($key);
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

	public static function createStorage(): StorageInterface
	{
		$object = is_string(Helper::$class) ? new Helper::$class() : (Helper::$class)();
		assert($object instanceof StorageInterface);

		return $object;
	}

}
