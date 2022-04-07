<?php declare(strict_types=1);

namespace h4kuna\Memoize;

final class Helpers
{
	static private bool $checked = false;


	public static function bypassMemoize(): void
	{
		if (self::$checked === true) {
			return;
		} elseif (trait_exists(MemoryStorage::class, false)) {
			throw new \RuntimeException(MemoryStorage::class . ' already loaded, you must call bypass before first use.');
		}

		self::$checked = true;
		require __DIR__ . '/../bypass/MemoryStorage.php';
	}

}
