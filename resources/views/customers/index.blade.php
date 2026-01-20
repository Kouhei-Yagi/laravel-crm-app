<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Customer Index</title>
</head>

<body>
    <main>
        <table border="1">
            <thead>
                <tr>
                    <th>顧客名</th>
                    <th>フリガナ</th>
                    <th>メールアドレス</th>
                    <th>電話番号</th>
                    <th>会社名</th>
                    <th>部署名</th>
                    <th>役職</th>
                    <th>郵便番号</th>
                    <th>住所</th>
                    <th>住所詳細</th>
                    <th>ステータス</th>
                    <th>ランク</th>
                    <th>担当者</th>
                    <th>メモ</th>
                    <th>作成日</th>
                    <th>更新日</th>
                    <th>削除日</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->kana }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->company_name }}</td>
                        <td>{{ $customer->department }}</td>
                        <td>{{ $customer->position }}</td>
                        <td>{{ $customer->postal_code }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->address_detail }}</td>
                        <td>{{ $customer->status }}</td>
                        <td>{{ $customer->rank }}</td>
                        <td>{{ optional($customer->user)->name }}</td>
                        <td>{{ $customer->memo }}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                        <td>{{ $customer->deleted_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $customers->links() }}
    </main>
</body>

</html>
