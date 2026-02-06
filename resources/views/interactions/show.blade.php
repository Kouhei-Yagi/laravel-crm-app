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
                <td>{{ $interaction->interacted_at }}</td>
            </tr>

            <tr>
                <th>対応種別</th>
                <td>{{ $interaction->type }}</td>
            </tr>

            <tr>
                <th>内容</th>
                <td>{{ $interaction->content }}</td>
            </tr>

            <tr>
                <th>案件名</th>
                <td>{{ $interaction->project_id }}</td>
            </tr>

            <tr>
                <th>顧客名</th>
                <td>{{ $interaction->customer_id }}</td>
            </tr>

            <tr>
                <th>担当者</th>
                <td>{{ $interaction->assigned_user_id }}</td>
            </tr>

            <tr>
                <th>メモ</th>
                <td>{{ $interaction->memo }}</td>
            </tr>

            <tr>
                <th>作成日</th>
                <td>{{ $interaction->created_at }}</td>
            </tr>

            <tr>
                <th>更新日</th>
                <td>{{ $interaction->updated_at }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
