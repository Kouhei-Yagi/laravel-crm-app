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
                    <td>{{ $interaction->interacted_at }}</td>
                    <td>{{ $interaction->type }}</td>
                    <td>{{ $interaction->content }}</td>
                    <td>{{ $interaction->project_id }}</td>
                    <td>{{ $interaction->customer_id }}</td>
                    <td>{{ $interaction->assigned_user_id }}</td>
                    <td>{{ $interaction->memo }}</td>
                    <td>{{ $interaction->created_at }}</td>
                    <td>{{ $interaction->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
