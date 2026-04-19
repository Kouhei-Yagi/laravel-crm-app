<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Sortable
{
    public function scopeSort($query)
    {
        // クエリパラメータの sort と direction の値を取得する
        $sort = request()->get('sort', $this->defaultSort);
        $direction = request()->get('direction', $this->defaultDirection);

        // ソート対象カラムのホワイトリスト化
        $sortable = property_exists($this, 'sortable') ? $this->sortable : [];
        $direction = ($direction === 'asc') ? 'asc' : 'desc';

        // join が必要なソートキーの設定を取得
        $sortableJoins = property_exists($this, 'sortableJoins') ? $this->sortableJoins : [];

        // テーブル結合・必要カラムの取得
        if (array_key_exists($sort, $sortableJoins)) {
            $join = $sortableJoins[$sort];

            $query->leftJoin($join['table'], $join['local_key'], '=', $join['foreign_key'])
                ->select($join['select']);
        }

        // ソート条件をクエリに追加する
        if (in_array($sort, $sortable, true)) {
            return $query->orderBy($sort, $direction);
        }

        // ホワイトリストにない場合、デフォルトソートを適用
        return $query->orderBy($this->defaultSort, $this->defaultDirection);
    }
}
