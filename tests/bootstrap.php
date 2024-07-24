<?php declare(strict_types=1);

use PHPUnit\Framework\Assert;

function assertException(callable $callback, string|Throwable $exception): void
{
	try {
		$callback();
	} catch (Throwable $e) {
		if ($exception instanceof Throwable) {
			Assert::assertSame($exception::class, $e::class);
			Assert::assertSame($exception->getMessage(), $e->getMessage());
			Assert::assertSame($exception->getCode(), $e->getCode());
		} else {
			Assert::assertSame($exception, $e::class);
		}

		return;
	}

	Assert::fail('Exception should have been thrown.');
}
