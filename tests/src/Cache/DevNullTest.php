<?php

declare(strict_types=1);

namespace h4kuna\Memoize\Tests\Cache;

use h4kuna\Memoize\PSR16\DevNull;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class DevNullTest extends TestCase
{
	public function testCache(): void
	{
		$cache = new DevNull();
		Assert::assertNull($cache->get('a'));
		Assert::assertSame(0, $cache->get('a', 0));

		Assert::assertTrue($cache->set('a', 1));
		Assert::assertSame(1, $cache->get('a'));
		Assert::assertFalse($cache->has('a')); // intentionally
		Assert::assertSame(1, $cache->get('a'));

		Assert::assertTrue($cache->delete('a'));
		Assert::assertSame(0, $cache->get('a', 0));

		Assert::assertTrue($cache->set('a', 1));
		Assert::assertTrue($cache->clear());
		Assert::assertSame(0, $cache->get('a', 0));
	}

	public function testNotImplemented(): void
	{
		$cache = new DevNull();
		$notImplemented = new RuntimeException('Not implemented');
		assertException(static fn () => $cache->deleteMultiple([]), $notImplemented);
		assertException(static fn () => $cache->setMultiple([]), $notImplemented);
		assertException(static fn () => $cache->getMultiple([]), $notImplemented);
	}
}
