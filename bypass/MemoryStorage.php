<?php declare(strict_types=1);

namespace h4kuna\Memoize;

trait MemoryStorage
{
	private array $memoryStorage = [];


	final protected function memoize($key, callable $callback)
	{
		return $callback();
	}

}
