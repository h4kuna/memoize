<?php declare(strict_types=1);

namespace h4kuna\Memoize;

/**
 * @phpstan-import-type keyType from Helper
 */
trait MemoryStorage
{
	private ?StorageInterface $internalStorage = null;

	/**
	 * @template T
	 * @param keyType       $key
	 * @param callable(): T $callback
	 *
	 * @return T
	 */
	final protected function memoize($key, callable $callback)
	{
		return Helper::resolveValue($this->getInternalStorage(), $key, $callback);
	}

	final protected function getInternalStorage(): StorageInterface
	{
		return $this->internalStorage ??= Helper::createStorage();
	}

}
