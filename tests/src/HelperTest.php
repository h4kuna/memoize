<?php

declare(strict_types=1);

namespace h4kuna\Memoize\Tests;

use DateTime;
use h4kuna\Memoize\Cache\DevNull;
use h4kuna\Memoize\Helper;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class HelperTest extends TestCase
{
	public function testResolveValue(): void
	{
		$cache = Helper::createCache();
		$v = Helper::resolveValue($cache, 10, static fn () => 1);
		Assert::assertSame(1, $v);
		Assert::assertSame(1, $cache->get('10'));

		$v = Helper::resolveValue($cache, ['a', 'b'], static fn () => 2);
		Assert::assertSame(2, $v);
		Assert::assertSame(2, $cache->get("a\x00b"));
	}

	public function testCreateCacheCallback(): void
	{
		$prev = Helper::$class;
		Helper::$class = static fn () => new DevNull();

		Assert::assertInstanceOf(DevNull::class, Helper::createCache());
		Helper::$class = $prev;
	}

	public function testByPass(): void
	{
		$prev = Helper::$class;
		Helper::bypassMemoize();
		Helper::bypassMemoize();

		Assert::assertInstanceOf(DevNull::class, Helper::createCache());
		Helper::$class = $prev;
	}

	public function testTtl(): void
	{
		Assert::assertNull(Helper::ttlToSeconds());
		Assert::assertSame(time() + 1, Helper::ttlToSeconds(1));
		Assert::assertSame(time() - 1, Helper::ttlToSeconds(-1));
		Assert::assertSame(time() + 1, Helper::ttlToSeconds((new DateTime)->diff(new DateTime('+1 seconds'))));
		Assert::assertSame(time() - 1, Helper::ttlToSeconds((new DateTime('+1 seconds'))->diff(new DateTime)));
	}

}
