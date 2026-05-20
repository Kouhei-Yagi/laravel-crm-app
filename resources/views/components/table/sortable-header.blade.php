{{--
<x-table.sortable-header> コンポーネント
一覧テーブルの「ソート可能なヘッダーセル（<th>）」を共通化するための部品
--}}

@props([
    'label', // 表示するヘッダー名（例：顧客名）
    'column', // ソート対象のカラム名（例：name）
])

@php
    // 現在のソート状態を取得
    $currentSort = request('sort');
    $currentDirection = request('direction');

    // 次に適用するソート方向を決定（asc → desc、desc → asc）
    $nextDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';

    // 現在のルート名を取得（例：customers.index）
    $routeName = request()->route()->getName();

    // 検索条件を保持したままソートリンクを生成
    $url = route(
        $routeName,
        array_merge(
            request()->query(),
            [
                'sort' => $column,
                'direction' => $nextDirection,
            ]
        )
    );
@endphp

<th class="px-4 py-2 border border-gray-200 dark:border-gray-600">
    {{-- ソートリンク --}}
    <a href="{{ $url }}"
        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
        {{ $label }}
    </a>

    {{-- 昇順 / 降順アイコンの表示 --}}
    @if ($currentSort === $column)
        @if ($currentDirection === 'asc')
            <span class="text-xs">▲</span>
        @else
            <span class="text-xs">▼</span>
        @endif
    @endif
</th>
