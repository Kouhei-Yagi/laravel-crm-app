<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件履歴詳細ページ</title>
</head>

<body>
    <h1>案件履歴詳細ページ</h1>

    <table border="1">
        <tbody>
            <tr>
                <th>対応日時</th>
                <td>{{ $interaction->interacted_at->format('Y-m-d H:i') }}</td>
            </tr>

            <tr>
                <th>対応種別</th>
                <td>{{ App\Models\Interaction::TYPE[$interaction->type] }}</td>
            </tr>

            <tr>
                <th>内容</th>
                <td>{{ $interaction->content }}</td>
            </tr>

            <tr>
                <th>メモ</th>
                <td>{{ $interaction->memo }}</td>
            </tr>

            <tr>
                <th>案件名</th>
                <td>{{ optional($interaction->project)->title ?? '未設定' }}</td>
            </tr>

            <tr>
                <th>顧客名</th>
                <td>{{ optional($interaction->customer)->name ?? '未設定' }}</td>
            </tr>

            <tr>
                <th>担当者</th>
                <td>{{ optional($interaction->user)->name ?? '未設定' }}</td>
            </tr>

            <tr>
                <th>作成日</th>
                <td>{{ $interaction->created_at->format('Y-m-d') }}</td>
            </tr>

            <tr>
                <th>更新日</th>
                <td>{{ $interaction->updated_at->format('Y-m-d') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
