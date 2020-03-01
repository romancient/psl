<?php

declare(strict_types=1);

namespace Psl\Gen;

use Psl\Arr;
use Psl\Iter;

/**
 * Returns the cartesian product of iterables that were passed as arguments.
 *
 * The resulting generator will contain all the possible tuples of keys and
 * values.
 *
 * Examples:
 *
 *      Gen\product(
 *          Gen\range(1, 2),
 *          Gen\range(3, 4)
 *      )
 *     => Gen([0, 0] => [1, 3], [0, 1] => [1, 4], [1, 0] => [2, 3], [1, 1] => [2, 4])
 *
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @psalm-param    iterable<Tk, Tv> ...$iterables Iterables to combine
 *
 * @psalm-return   iterable<array<int, Tk>, array<int, Tv>>
 *
 * @psalm-suppress MixedReturnTypeCoercion
 */
function product(iterable ...$iterables): iterable
{
    /** @psalm-var array<int, Iter\Iterator<Tk, Tv>> $iterators */
    $iterators = Iter\to_array(Iter\map(
        $iterables,
        fn (iterable $iterable) => new Iter\Iterator($iterable)
    ));

    $numIterators = count($iterators);
    if (0 === $numIterators) {
        /** @plsam-var iterable<array<int, Tk>, array<int, Tv>> */
        yield [] => [];

        return;
    }

    /** @psalm-var array<int, Tk|null> $keyTuple */
    /** @psalm-var array<int, Tv|null> $valueTuple */
    $keyTuple = Arr\fill(null, 0, $numIterators);
    $valueTuple = Arr\fill(null, 0, $numIterators);
    $i = -1;
    while (true) {
        while (++$i < $numIterators - 1) {
            $iterators[$i]->rewind();
            if (!$iterators[$i]->valid()) {
                return;
            }

            $keyTuple[$i] = $iterators[$i]->key();
            $valueTuple[$i] = $iterators[$i]->current();
        }

        foreach ($iterators[$i] as $keyTuple[$i] => $valueTuple[$i]) {
            yield $keyTuple => $valueTuple;
        }

        while (--$i >= 0) {
            $iterators[$i]->next();
            if ($iterators[$i]->valid()) {
                $keyTuple[$i] = $iterators[$i]->key();
                $valueTuple[$i] = $iterators[$i]->current();
                continue 2;
            }
        }

        return;
    }
}