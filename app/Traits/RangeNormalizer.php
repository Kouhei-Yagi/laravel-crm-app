<?php

namespace App\Traits;

trait RangeNormalizer
{
    /**
     * 範囲の開始値と終了値を正しい順番に並べ替える
     *
     * @param mixed $from
     * @param mixed $to
     * @return array [$from, $to]
     */
    protected function normalizeRange($from, $to): array
    {
        // 両方に値があり、かつ from > to の場合は入れ替える
        if ($from && $to && $from > $to) {
            return [$to, $from];
        }

        // それ以外はそのまま返す
        return [$from, $to];
    }
}
