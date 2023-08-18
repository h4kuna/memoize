<?php declare(strict_types=1);

namespace Tests;

use h4kuna\Memoize;
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

// with memoize, micro times are same

Assert::false(trait_exists(Memoize\MemoryStorage::class, false));

$object = new class {

	use Memoize\MemoryStorage, Memoize\MemoryStorageStatic {
		Memoize\MemoryStorage::memoize insteadof Memoize\MemoryStorageStatic;
		Memoize\MemoryStorageStatic::memoize as memoizeStatic;
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

$object2 = new class {

	use  Memoize\MemoryStorageStatic;

	public static function microtimeStatic(): float
	{
		return static::memoize(__METHOD__, function (): float {
			return microtime(true);
		});
	}

};

$microtime = $object->microtime();
$microtimeStatic = $object::microtimeStatic();

usleep((int) (0.1 * 1_000_000.0));

$microtimeStatic2 = $object2::microtimeStatic();

usleep((int) (0.1 * 1_000_000.0));

Assert::same($microtime, $object->microtime());
Assert::same($microtimeStatic, $object::microtimeStatic());
Assert::same($microtimeStatic2, $object2::microtimeStatic());
Assert::notSame($object::microtimeStatic(), $object2::microtimeStatic());
