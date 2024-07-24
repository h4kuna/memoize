<?php declare(strict_types=1);

namespace h4kuna\Memoize;

class_alias(Memoize::class, 'h4kuna\Memoize\MemoryStorage');
class_alias(MemoizeStatic::class, 'h4kuna\Memoize\MemoryStorageStatic');

if (false) {
	/**
	 * @deprecated use see
	 * @see Memoize
	 */
	trait MemoryStorage {}
}

if (false) {
	/**
	 * @deprecated use see
	 * @see MemoizeStatic
	 */
	trait MemoryStorageStatic {}
}
