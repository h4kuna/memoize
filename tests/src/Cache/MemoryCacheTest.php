<?php

declare(strict_types=1);

namespace h4kuna\Memoize\Tests\Cache;

use DateTime;
use h4kuna\Memoize\PSR16\MemoryCache;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class MemoryCacheTest extends TestCase
{
	public function testCache(): void
	{
		$k1 = 'a';
		$k2 = 'b';
		$k3 = 'c';
		$cache = new MemoryCache();

		Assert::assertNull($cache->get($k1));
		Assert::assertSame(0, $cache->get($k1, 0));

		Assert::assertTrue($cache->set($k1, 1));
		Assert::assertTrue($cache->set($k2, 2, 2));
		Assert::assertTrue($cache->set($k3, 3, (new DateTime)->diff(new DateTime('+2 seconds'))));

		Assert::assertSame(1, $cache->get($k1, 0));
		Assert::assertSame(2, $cache->get($k2, 0));
		Assert::assertSame(3, $cache->get($k3, 0));
		Assert::assertTrue($cache->has($k1));
		Assert::assertTrue($cache->has($k2));
		Assert::assertTrue($cache->has($k3));

		sleep(3);

		Assert::assertTrue($cache->has($k1));
		Assert::assertFalse($cache->has($k2));
		Assert::assertFalse($cache->has($k3));

		// intentionally
		Assert::assertSame(1, $cache->get($k1, 0));
		Assert::assertSame(2, $cache->get($k2, 0));
		Assert::assertSame(3, $cache->get($k3, 0));

		$cache->delete($k1);
		Assert::assertSame(0, $cache->get($k1, 0));
	}

	public function testClear(): void
	{
		$cache = new MemoryCache();
		$cache->set('a', 1);
		$cache->set('b', 2);
		$cache->clear();
		Assert::assertFalse($cache->has('a'));
		Assert::assertFalse($cache->has('b'));
	}

	public function testDeleteMultiple(): void
	{
		$cache = new MemoryCache();

		$data = iterator_to_array($cache->getMultiple(['a', 'b', 'c'], -1));
		Assert::assertSame(['a' => -1, 'b' => -1, 'c' => -1], $data);

		$cache->setMultiple(['a' => 1, 'b' => 2, 'c' => 3]);
		$data = iterator_to_array($cache->getMultiple(['a', 'b', 'c'], -1));
		Assert::assertSame(['a' => 1, 'b' => 2, 'c' => 3], $data);

		$cache->deleteMultiple(['a', 'b']);
		Assert::assertFalse($cache->has('a'));
		Assert::assertFalse($cache->has('b'));
		Assert::assertTrue($cache->has('c'));
	}
}
