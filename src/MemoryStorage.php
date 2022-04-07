<?php declare(strict_types=1);

namespace h4kuna\Memoize;

trait MemoryStorage
{
	/** @var array<string, mixed> */
	private array $memoryStorage = [];


	/**
	 * @param string|array $key
	 * @return mixed
	 */
	final protected function memoize($key, callable $callback)
	{
		if (is_array($key)) {
			$key = implode("\x00", $key);
		}
		if (array_key_exists($key, $this->memoryStorage) === FALSE) {
			return $this->memoryStorage[$key] = $callback();
		}
		return $this->memoryStorage[$key];
	}

}
