<?php declare(strict_types=1);

namespace h4kuna\Memoize\Tests\Fixtures;

use h4kuna\Memoize\Memoize;
use h4kuna\Memoize\MemoizeStatic;

final class MixedClass
{
	use Memoize, MemoizeStatic {
		Memoize::memoize insteadof MemoizeStatic;
		MemoizeStatic::memoize as memoizeStatic;
	}

	public static function fooStatic(): int
	{
		return self::memoizeStatic('id', static function (): int {
			return 11;
		});
	}

	public function foo(): int
	{
		return $this->memoize('id', static function (): int {
			return 12;
		});
	}
}
