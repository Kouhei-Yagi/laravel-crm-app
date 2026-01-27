<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件一覧ページ</title>
</head>

<body>
    <h1>案件一覧ページ</h1>

    <table border="1">
        <thead>
            <tr>
                <th>顧客ID</th>
                <th>案件名</th>
                <th>案件内容</th>
                <th>ステータス</th>
                <th>税抜金額</th>
                <th>開始日</th>
                <th>終了日</th>
                <th>担当者ID</th>
                <th>メモ</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->customer_id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->status }}</td>
                    <td>{{ $project->amount }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>{{ $project->assigned_user_id }}</td>
                    <td>{{ $project->memo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
