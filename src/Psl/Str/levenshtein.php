<?php

declare(strict_types=1);

namespace Psl\Str;

use Psl;

/**
 * Calculate Levenshtein distance between two strings.
 *
 * Note: In its simplest form the function will take only the two strings
 * as parameter and will calculate just the number of insert, replace and
 * delete operations needed to transform str1 into str2.
 * Note: A second variant will take three additional parameters that define
 * the cost of insert, replace and delete operations. This is more general
 * and adaptive than variant one, but not as efficient.
 *
 * @return int this function returns the Levenshtein-Distance between the
 *             two argument strings or -1, if one of the argument strings
 *             is longer than the limit of 255 characters
 */
function levenshtein(string $str1, string $str2, ?int $cost_of_insertion = null, ?int $cost_of_replacement = null, ?int $cost_of_deletion = null): int
{
    if (null === $cost_of_deletion && null === $cost_of_insertion && null === $cost_of_replacement) {
        return \levenshtein($str1, $str2);
    }

    if (null !== $cost_of_deletion && null !== $cost_of_insertion && null !== $cost_of_replacement) {
        return \levenshtein($str1, $str2, $cost_of_insertion, $cost_of_replacement, $cost_of_deletion);
    }

    // https://github.com/php/php-src/blob/623911f993f39ebbe75abe2771fc89faf6b15b9b/ext/standard/levenshtein.c#L101
    Psl\invariant_violation('Expected either all costs to be supplied, or non.');

    // satisfy PhpStorm
    return 0;
}