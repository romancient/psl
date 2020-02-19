<?php

declare(strict_types=1);

namespace Psl\Iter;

use Generator;

use Psl\Arr;

/**
 * @psalm-template Tk of array-key
 * @psalm-template Tv
 *
 * @psalm-param iterable<Tk, Tv>       $first
 * @psalm-param iterable<Tk, mixed>    $second
 * @psalm-param iterable<Tk, mixed>    ...$rest
 *
 * @psalm-return Generator<Tk, iterable<Tk, Tv>, mixed, array<empty, empty>|iterable<Tk, Tv>>
 */
function diff_by_key(iterable $first, iterable $second, iterable ...$rest): Generator
{
    if (is_empty($first)) {
        return [];
    }

    if (is_empty($second) && is_empty($rest)) {
        return $first;
    }

    $other = Arr\flatten([$second, ...$rest]);
    /** @psalm-var iterable<Tk, Tv> */
    foreach ($first as $k => $v) {
        if (!contains_key($other, $k)) {
            yield $k => $v;
        }
    }
}
