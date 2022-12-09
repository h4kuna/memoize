<?php declare(strict_types=1);

namespace h4kuna\Memoize;

trait MemoryStorage
{
	/** @var array<string, mixed> */
	private array $memoryStorage = [];


	/**
	 * @template T
	 * @param scalar|array<string> $key
	 * @param callable(): T $callback
	 * @return T
	 */
	final protected function memoize($key, callable $callback)
	{
		if (is_array($key)) {
			$key = implode("\x00", $key);
		} else {
			$key = (string) $key;
		}
		if (array_key_exists($key, $this->memoryStorage) === false) {
			return $this->memoryStorage[$key] = $callback();
		}

		return $this->memoryStorage[$key];
	}

}
