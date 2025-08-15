<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\GetFirstParamClassNameInClosure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

/**
 * Elasticsearch DSL root.
 */
final class Body
{
    private array $query = [];

    private ?int $from = null;

    private ?int $size = null;

    private array $sorts = [];

    private array $searchAfters = [];

    public static function query(
        ?Closure $callback = null,
    ): self {
        /** @var ?string $classFqn */
        $classFqn = app(GetFirstParamClassNameInClosure::class)
            ->execute($callback);

        if ($classFqn === null) {
            return new self;
        }

        /** @var Arrayable $instance */
        $instance = app($classFqn);

        $isArrayable = $instance instanceof Arrayable;

        if ($isArrayable === false) {
            return new self;
        }

        $callback($instance);

        $bodyInstance = new self;

        $bodyInstance->query = $instance->toArray();

        return $bodyInstance;
    }

    public function from(int $offset): self
    {
        $this->from = $offset;

        return $this;
    }

    public function sort(
        string $fieldName,
        string $direction,
    ): self {
        $this->sorts[] = [
            $fieldName => [
                'order' => $direction,
            ],
        ];

        return $this;
    }

    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function searchAfter(int $searchAfter): self
    {
        $this->searchAfters[] = $searchAfter;

        return $this;
    }

    public function toArray(): array
    {
        $params = app(UnsetNothingKeyInArray::class)->execute(
            [
                'query'        => $this->query ?: Nothing::make(),
                'from'         => $this->from ?? Nothing::make(),
                'size'         => $this->size ?? Nothing::make(),
                'sort'         => $this->sorts ?: Nothing::make(),
                'search_after' => $this->searchAfters ?: Nothing::make(),
            ],
        );

        return [
            'body' => $params,
        ];
    }
}
