<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件詳細ページ</title>
</head>

<body>
    <h1>案件詳細ページ</h1>

    <table border="1">
        <tbody>
            <tr>
                <th>案件名</th>
                <td>{{ $project->title }}</td>
            </tr>
            <tr>
                <th>顧客名</th>
                <td>{{ $project->customer_id }}</td>
            </tr>
            <tr>
                <th>案件内容</th>
                <td>{{ $project->description }}</td>
            </tr>
            <tr>
                <th>ステータス</th>
                <td>{{ $project->status }}</td>
            </tr>
            <tr>
                <th>税抜金額</th>
                <td>{{ $project->amount }} 円</td>
            </tr>
            <tr>
                <th>開始日</th>
                <td>{{ $project->start_date }}</td>
            </tr>
            <tr>
                <th>終了日</th>
                <td>{{ $project->end_date }}</td>
            </tr>
            <tr>
                <th>担当者</th>
                <td>{{ $project->assigned_user_id }}</td>
            </tr>
            <tr>
                <th>メモ</th>
                <td>{{ $project->memo }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
