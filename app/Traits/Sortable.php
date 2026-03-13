<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Sortable
{
    public function scopeSort($query, Request $request)
    {
        // クエリパラメータの sort と direction の値を取得する
        $sort = $request->get('sort');
        $direction = $request->get('direction');

        // sort の値がある場合、ソート条件をクエリに追加する
        if ($sort) {
            return $query->orderBy($sort, $direction);
        }

        // ソートされていない場合、そのまま返す
        return $query;
    }
}
