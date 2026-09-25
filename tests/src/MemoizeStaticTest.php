<?php

declare(strict_types=1);

namespace h4kuna\Memoize\Tests;

use h4kuna\Memoize\MemoryStorageStatic;
use h4kuna\Memoize\Tests\Fixtures\MixedClass;
use h4kuna\Memoize\Tests\Fixtures\StaticClass;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class MemoizeStaticTest extends TestCase
{
	public function testBackCompatibility(): void
	{
		$a = new class {
			use MemoryStorageStatic;

			public static function foo(): int
			{
				return self::memoize('id', static fn () => 13);
			}
		};

		Assert::assertSame(13, $a::foo());
	}

	public function testBasic(): void
	{
		$start = microtime(true);
		$first = StaticClass::foo();
		$second = StaticClass::foo();
		$diff = microtime(true) - $start;
		Assert::assertSame(10, $first);
		Assert::assertSame(10, $second);
		Assert::assertSame(1, (int) round($diff));

		Assert::assertSame(11, MixedClass::fooStatic());
	}
}
