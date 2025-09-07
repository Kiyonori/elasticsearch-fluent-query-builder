<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\MakeArrayableInstanceFromFirstParam;
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

    private array $highlight = [];

    public static function query(
        ?Closure $callback = null,
    ): self {
        /** @var ?Arrayable $arrayableInstance */
        $arrayableInstance = app(MakeArrayableInstanceFromFirstParam::class)
            ->execute($callback);

        if ($arrayableInstance === null) {
            return new self;
        }

        $callback($arrayableInstance);

        $bodyInstance = new self;

        $bodyInstance->query = $arrayableInstance->toArray();

        return $bodyInstance;
    }

    public function highlight(
        Closure $callback,
    ): self {
        /** @var ?Arrayable $arrayableInstance */
        $arrayableInstance = app(MakeArrayableInstanceFromFirstParam::class)
            ->execute($callback);

        if ($arrayableInstance === null) {
            return $this;
        }

        $callback($arrayableInstance);

        $this->highlight = $arrayableInstance->toArray();

        return $this;
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
                'highlight'    => $this->highlight ?: Nothing::make(),
            ],
        );

        return [
            'body' => $params,
        ];
    }
}
