<?php

declare(strict_types=1);

namespace Psl\SecureRandom;

use Exception;
use Psl;
use Psl\Str;
use Psl\Type;

use function random_bytes;

/**
 * Returns a cryptographically secure random bytes.
 *
 * @throws Psl\Exception\InvariantViolationException If $length is negative.
 * @throws Psl\Exception\RuntimeException If it was not possible to gather sufficient entropy.
 */
function bytes(int $length): string
{
    Psl\invariant($length >= 0, 'Expected a non-negative length.');
    if (0 === $length) {
        return '';
    }

    try {
        return random_bytes($length);
        // @codeCoverageIgnoreStart
    } catch (Exception $e) {
        $code = $e->getCode();
        if (Type\is_string($code)) {
            $code = Str\to_int($code) ?? 0;
        }

        throw new Psl\Exception\RuntimeException('Unable to gather sufficient entropy.', $code, $e);
        // @codeCoverageIgnoreEnd
    }
}
