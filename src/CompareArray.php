<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

final readonly class CompareArray
{
    /**
     * 2 つの array を Elasticsearch のドキュメント更新用に比較する
     *
     * - 1階層目、$new と $current を比較して、値が変化していれば、それは差分として評価する
     * - 1階層目、$current にあるキーが $new ではキーごと消失していても、それは差分として評価しない
     * - 2階層目以降、更に内側の細部の一部が変化していている場合、それは１階層目の所属するキー全体の差分として評価する
     *
     * @param  array  $current  変更前
     * @param  array  $new  変更後
     * @return array 差分
     */
    public function execute(
        array $current,
        array $new,
    ): array {
        $diff = [];

        foreach ($current as $key => $currentItem) {
            if (! array_key_exists($key, $new)) {
                continue;
            }

            if (! is_array($currentItem)) {
                if (! is_array($new[$key]) && $currentItem === $new[$key]) {
                    continue;
                }

                $diff[$key] = $new[$key];

                continue;
            }

            // ココに到達した時点で $currentItem は is_array である

            if (! is_array($new[$key])) {
                $diff[$key] = $new[$key];

                continue;
            }

            // ココに到達した時点で $currentItem と $new[$key] の両方は is_array である

            $currentJson = json_encode($currentItem);
            $newJson     = json_encode($new[$key]);

            if ($currentJson === $newJson) {
                continue;
            }

            $diff[$key] = $new[$key];
        }

        return $diff;
    }
}
