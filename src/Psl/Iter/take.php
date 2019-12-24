<?php

declare(strict_types=1);

namespace Psl\Iter;

/**
 * Take the first n elements from an iterable.
 *
 * @psalm-template Tk as array-key
 * @psalm-template Tv
 *
 * @psalm-param iterable<Tk, Tv> $iterable
 *
 * @psalm-return iterable<Tk, Tv>
 */
function take(iterable $iterable, int $n): iterable
{
    /** @psalm-var iterable<Tk, Tv> */
    return slice($iterable, 0, $n);
}