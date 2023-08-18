<?php declare(strict_types=1);

namespace Tests;

use h4kuna\Memoize;
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

// without memoize, micro times are not same

Assert::false(trait_exists(Memoize\MemoryStorage::class, false));

Memoize\Helpers::bypassMemoize();
Memoize\Helpers::bypassMemoize();

$object = new class {

	use Memoize\MemoryStorage, Memoize\MemoryStorageStatic {
		Memoize\MemoryStorage::memoize insteadof Memoize\MemoryStorageStatic;
		Memoize\MemoryStorageStatic::memoize as memoizeStatic;
	}

	public function badKeyParameter(): void
	{
		$this->memoize(true, fn () => true);
	}

	public function microtime(): float
	{
		return $this->memoize(__METHOD__, function (): float {
			return microtime(true);
		});
	}


	public static function microtimeStatic(): float
	{
		return static::memoizeStatic(__METHOD__, function (): float {
			return microtime(true);
		});
	}

};

$microtime = $object->microtime();
$microtimeStatic = $object::microtimeStatic();

usleep((int) (0.1 * 1_000_000.0));

Assert::notSame($microtime, $object->microtime());
Assert::notSame($microtimeStatic, $object::microtimeStatic());
