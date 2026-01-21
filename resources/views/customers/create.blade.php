<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客新規作成ページ</title>
</head>

<body>
    <h1>顧客新規作成ページ</h1>

    <form action="{{ route('customers.store') }}" method="post">
        @csrf

        <div>
            <label for="name">顧客名</label><br>
            <input type="text" id="name" name="name" placeholder="例：山田太郎">
            </p>

            <div>
                <label for="kana">フリガナ</label><br>
                <input type="text" id="kana" name="kana" placeholder="例：ヤマダタロウ">
                </p>

                <div>
                    <label for="email">メール</label><br>
                    <input type="email" id="email" name="email" placeholder="例：example@example.com">
                    </p>

                    <div>
                        <label for="phone">電話番号</label><br>
                        <input type="tel" id="phone" name="phone" placeholder="例：090-1234-5678">
                        </p>

                        <div>
                            <label for="postal_code">郵便番号</label><br>
                            <input type="text" id="postal_code" name="postal_code" placeholder="例：123-4567">
                            </p>

                            <div>
                                <label for="address">住所</label><br>
                                <input type="text" id="address" name="address" placeholder="例：福岡県福岡市〇〇">
                                </p>

                                <div>
                                    <label for="address_detail">住所詳細</label><br>
                                    <input type="text" id="address_detail" name="address_detail"
                                        placeholder="例：マンション名・部屋番号など">
                                    </p>

                                    <div>
                                        <label for="company_name">会社名</label><br>
                                        <input type="text" id="company_name" name="company_name"
                                            placeholder="例：株式会社サンプル">
                                        </p>

                                        <div>
                                            <label for="department">部署</label><br>
                                            <input type="text" id="department" name="department">
                                            </p>

                                            <div>
                                                <label for="position">役職</label><br>
                                                <input type="text" id="position" name="position">
                                                </p>

                                                <div>
                                                    <label for="status">ステータス</label><br>
                                                    <input type="text" id="status" name="status">
                                                    </p>

                                                    <div>
                                                        <label for="rank">ランク</label><br>
                                                        <input type="text" id="rank" name="rank">
                                                        </p>

                                                        <div>
                                                            <label for="assigned_user_id">担当者（ID）</label><br>
                                                            <input type="number" id="assigned_user_id"
                                                                name="assigned_user_id" placeholder="例：1">
                                                            </p>

                                                            <div>
                                                                <label for="memo">メモ</label><br>
                                                                <textarea id="memo" name="memo" placeholder="自由記述欄"></textarea>
                                                                </p>

                                                                <button type="submit">登録する</button>
    </form>

</body>

</html>
