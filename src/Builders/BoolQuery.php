<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\MakeArrayableInstanceFromFirstParam;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class BoolQuery implements Arrayable
{
    private array $bool = [];

    public function __invoke(
        Closure $callback,
        ?int $minimumShouldMatch = null,
    ): self {
        /** @var ?Arrayable $arrayableInstance */
        $arrayableInstance = app(MakeArrayableInstanceFromFirstParam::class)
            ->execute($callback);

        if ($arrayableInstance === null) {
            return $this;
        }

        $callback($arrayableInstance);

        $this->bool['bool'] = $arrayableInstance->toArray()
            +
            [
                'minimum_should_match' => $minimumShouldMatch ?? Nothing::make(),
            ];

        return $this;
    }

    /**
     * メソッドチェーンや糖衣構文用としての bool メソッド
     */
    public function bool(
        Closure $callback,
        ?int $minimumShouldMatch = null,
    ): self {
        return $this->__invoke(
            $callback,
            $minimumShouldMatch,
        );
    }

    public function toArray(): array
    {
        return app(UnsetNothingKeyInArray::class)->execute(
            $this->bool,
        );
    }
}
