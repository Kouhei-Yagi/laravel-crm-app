<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件履歴一覧ページ</title>
</head>

<body>
    <h1>案件履歴一覧ページ</h1>

    <table border="1">
        <thead>
            <tr>
                <th>対応日時</th>
                <th>対応種別</th>
                <th>内容</th>
                <th>案件名</th>
                <th>顧客名</th>
                <th>担当者</th>
                <th>メモ</th>
                <th>作成日</th>
                <th>更新日</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($interactions as $interaction)
                <tr>
                    <td>{{ $interaction->interacted_at->format('Y-m-d H:i') }}</td>
                    <td>{{ App\Models\Interaction::TYPE[$interaction->type] }}</td>
                    <td>{{ $interaction->content }}</td>
                    <td>{{ optional($interaction->project)->title }}</td>
                    <td>{{ optional($interaction->customer)->name }}</td>
                    <td>{{ optional($interaction->user)->name }}</td>
                    <td>{{ $interaction->memo }}</td>
                    <td>{{ $interaction->created_at->format('Y-m-d') }}</td>
                    <td>{{ $interaction->updated_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
