<?php declare(strict_types=1);

namespace h4kuna\Memoize;

use ArrayAccess;

/**
 * @extends ArrayAccess<string, mixed>
 */
interface StorageInterface extends ArrayAccess
{
	function clear(): void;
}
