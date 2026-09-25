<?php declare(strict_types = 1);

namespace h4kuna\Memoize\PSR16;

use InvalidArgumentException as NativeInvalidArgumentException;
use Psr\SimpleCache\InvalidArgumentException as PsrInvalidArgumentException;

final class InvalidArgumentException extends NativeInvalidArgumentException implements PsrInvalidArgumentException
{

}
