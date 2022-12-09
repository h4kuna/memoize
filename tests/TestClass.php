<?php declare(strict_types=1);


final class TestClass
{
	use \h4kuna\Memoize\MemoryStorage;

	public function foo(): void
	{
		$this->memoize(__METHOD__, function (): void { return; });
	}
}
