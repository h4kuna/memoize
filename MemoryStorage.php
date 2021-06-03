<?php

namespace h4kuna\Memoize;

trait MemoryStorage
{
	/** @var array */
	private $memoryStorage = [];

	/** @var bool */
	public static $memoryDisable = false;


	/**
	 * @param string|array $key
	 * @param callable $callback
	 * @return mixed
	 */
	final protected function memoize($key, callable $callback)
	{
		if (is_array($key)) {
			$key = implode("\x00", $key);
		}
		if (array_key_exists($key, $this->memoryStorage) === false || self::$memoryDisable) {
			return $this->memoryStorage[$key] = $callback();
		}
		return $this->memoryStorage[$key];
	}

}
