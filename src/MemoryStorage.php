<?php declare(strict_types=1);

namespace h4kuna\Memoize;

trait MemoryStorage
{
	/** @var array<string, mixed> */
	private array $memoryStorage = [];


	/**
	 * @template T
	 * @param string|int|float|array<string|int|float> $key - keyType
	 * @param callable(): T $callback
	 * @return T
	 */
	final protected function memoize($key, callable $callback)
	{
		$key = Helpers::resolveKey($key);
		if (array_key_exists($key, $this->memoryStorage) === false) {
			return $this->memoryStorage[$key] = $callback();
		}

		return $this->memoryStorage[$key];
	}

}
