<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final readonly class UnsetNothingKeyInArray
{
    /**
     * value 部分が Nothing::class の場合は key ごと取り除く
     */
    public function execute(array $input): array
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = $this->execute($value);

                if (empty($input[$key])) {
                    unset($input[$key]);
                }
            } elseif ($value instanceof Nothing) {
                unset($input[$key]);
            }
        }

        return $input;
    }
}
