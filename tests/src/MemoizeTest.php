<?php

declare(strict_types=1);

namespace h4kuna\Memoize\Tests;

use h4kuna\Memoize\MemoryStorage;
use h4kuna\Memoize\Tests\Fixtures\MixedClass;
use h4kuna\Memoize\Tests\Fixtures\NormalClass;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class MemoizeTest extends TestCase
{
	public function testBackCompatibility(): void
	{
		$a = new class {
			use MemoryStorage;

			public function foo(): int
			{
				return $this->memoize('id', static fn (): int => 13);
			}
		};

		Assert::assertSame(13, $a->foo());
	}

	public function testBasic(): void
	{
		$class = new NormalClass();
		$start = microtime(true);
		Assert::assertSame(10, $class->foo());
		Assert::assertSame(10, $class->foo());
		$diff = microtime(true) - $start;
		Assert::assertSame(1, (int) round($diff));

		Assert::assertSame(12, (new MixedClass())->foo());
	}

}
