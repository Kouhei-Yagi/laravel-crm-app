<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客詳細ページ</title>
</head>

<body>
    <h1>顧客詳細ページ</h1>

    <table border="1">
        <tbody>
            <tr>
                <th>顧客名</th>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <th>フリガナ</th>
                <td>{{ $customer->kana }}</td>
            </tr>
            <tr>
                <th>メール</th>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $customer->phone }}</td>
            </tr>
            <tr>
                <th>会社名</th>
                <td>{{ $customer->company_name }}</td>
            </tr>
            <tr>
                <th>部署</th>
                <td>{{ $customer->department }}</td>
            </tr>
            <tr>
                <th>役職</th>
                <td>{{ $customer->position }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $customer->address }} {{ $customer->address_detail }}</td>
            </tr>
            <tr>
                <th>ステータス</th>
                <td>{{ $customer->status }}</td>
            </tr>
            <tr>
                <th>ランク</th>
                <td>{{ $customer->rank }}</td>
            </tr>
            <tr>
                <th>担当者</th>
                <td>{{ optional($customer->user)->name }}</td>
            </tr>
            <tr>
                <th>作成日</th>
                <td>{{ $customer->created_at->format('Y-m-d') }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
