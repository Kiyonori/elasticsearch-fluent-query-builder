<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class Highlight implements Arrayable
{
    private array $fields = [];

    /** @var array<int, string> */
    private array $preTags = [];

    /** @var array<int, string> */
    private array $postTags = [];

    public function field(
        string $fieldName,
        ?int $fragmentSize = null,
        ?int $numberOfFragments = null,
    ): self {
        $this->fields[$fieldName] = [
            'fragment_size'       => $fragmentSize ?? Nothing::make(),
            'number_of_fragments' => $numberOfFragments ?? Nothing::make(),
        ];

        return $this;
    }

    /**
     * @param  array<int, string>  $preTags  e.g. `['<em>', '<strong>']`
     */
    public function preTags(array $preTags): self
    {
        $this->preTags = $preTags;

        return $this;
    }

    /**
     * @param  array<int, string>  $postTags  e.g. `['</em>', '</strong>']`
     */
    public function postTags(array $postTags): self
    {
        $this->postTags = $postTags;

        return $this;
    }

    public function toArray(): array
    {
        return app(UnsetNothingKeyInArray::class)->execute(
            [
                'fields'    => $this->fields,
                'pre_tags'  => $this->preTags ?: Nothing::make(),
                'post_tags' => $this->postTags ?: Nothing::make(),
            ],
        );
    }
}
