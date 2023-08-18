<?php declare(strict_types=1);

namespace h4kuna\Memoize;

final class Helpers
{
	static private bool $checked = false;

	static private bool $checkedStatic = false;


	/**
	 * @param string|int|float|array<string|int|float> $key - keyType
	 */
	public static function resolveKey($key): string
	{
		return is_array($key) ? implode("\x00", $key) : (string) $key;
	}


	/**
	 * This is only for tests
	 */
	public static function bypassMemoize(): void
	{
		self::bypassMemoizeObject();
		self::bypassMemoizeStatic();
	}


	public static function bypassMemoizeObject(): void
	{
		if (self::$checked === true) {
			return;
		} elseif (trait_exists(MemoryStorage::class, false)) {
			throw new \RuntimeException(MemoryStorage::class . ' already loaded, you must call bypass before first use.');
		}

		self::$checked = true;

		self::bypass(false);
	}


	public static function bypassMemoizeStatic(): void
	{
		if (self::$checkedStatic === true) {
			return;
		} elseif (trait_exists(MemoryStorageStatic::class, false)) {
			throw new \RuntimeException(MemoryStorageStatic::class . ' already loaded, you must call bypass before first use.');
		}

		self::$checkedStatic = true;

		self::bypass(true);
	}


	private static function bypass(bool $static): void
	{
		if ($static) {
			$className = 'MemoryStorageStatic';
			$staticWord = ' static';
		} else {
			$className = 'MemoryStorage';
			$staticWord = '';
		}

		eval(<<<TRAIT
		namespace h4kuna\Memoize;
		
		trait $className
		{
		
			final protected$staticWord function memoize(\$key, callable \$callback)
			{
				return \$callback();
			}
		
		}
		TRAIT);
	}

}
