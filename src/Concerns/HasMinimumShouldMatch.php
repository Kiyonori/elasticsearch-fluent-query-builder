<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Concerns;

/**
 * @deprecated 書いてみたけど、やっぱり使わなさそう
 */
trait HasMinimumShouldMatch
{
    private ?int $minimumMatch = null;

    final function minimumShouldMatch(
        int $minimumMatch,
    ): self {
        $this->minimumMatch = $minimumMatch;

        return $this;
    }
}
