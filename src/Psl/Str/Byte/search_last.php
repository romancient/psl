<?php

declare(strict_types=1);

namespace Psl\Str\Byte;

use Psl;

/**
 * Returns the last position of the 'needle' string in the 'haystack' string,
 * or null if it isn't found.
 *
 * An optional offset determines where in the haystack (from the beginning) the
 * search begins. If the offset is negative, the search will begin that many
 * characters from the end of the string and go backwards. If the offset is
 * out-of-bounds, an InvariantViolationException will be thrown.
 */
function search_last(string $haystack, string $needle, int $offset = 0): ?int
{
    $haystack_length = length($haystack);
    Psl\invariant($offset >= -$haystack_length && $offset <= $haystack_length, 'Offset is out-of-bounds.');

    return false === ($pos = \strrpos($haystack, $needle, $offset)) ? null : $pos;
}