<?php declare(strict_types=1);

namespace h4kuna\Memoize;

final class Helpers
{
	static private bool $checked = false;


	/**
	 * This is only for tests
	 */
	public static function bypassMemoize(): void
	{
		if (self::$checked === true) {
			return;
		} elseif (trait_exists(MemoryStorage::class, false)) {
			throw new \RuntimeException(MemoryStorage::class . ' already loaded, you must call bypass before first use.');
		}

		self::$checked = true;

		eval(<<<TRAIT
		namespace h4kuna\Memoize;
		
		trait MemoryStorage
		{
		
			final protected function memoize(\$key, callable \$callback)
			{
				return \$callback();
			}
		
		}
		TRAIT);

	}

}
