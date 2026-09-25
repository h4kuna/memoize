<?php declare(strict_types = 1);

namespace h4kuna\Memoize\Tests\Fixtures;

use h4kuna\Memoize\MemoizeStatic;
use function sleep;

final class StaticClass
{

	use MemoizeStatic;

	public static function foo(): int
	{
		return self::memoize('id', static function (): int {
			sleep(1);

			return 10;
		});
	}

}
