<?php declare(strict_types=1);

namespace h4kuna\Memoize\Tests\Fixtures;

use h4kuna\Memoize\Memoize;

final class NormalClass
{
	use Memoize;

	public function foo(): int
	{
		return $this->memoize('id', static function (): int {
			sleep(1);

			return 10;
		});
	}
}
