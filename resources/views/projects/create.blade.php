<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件新規作成ページ</title>
</head>

<body>
    <h1>案件新規作成ページ</h1>

    <form action="{{ route('projects.store') }}" method="post">
        @csrf

        <p>
            <label for="title">案件名</label><br>
            <input type="text" id="title" name="title">
        </p>

        <p>
            <label for="customer_id">顧客名</label><br>
            <input type="number" id="customer_id" name="customer_id">
        </p>

        <p>
            <label for="description">案件内容</label><br>
            <textarea id="description" name="description"></textarea>
        </p>

        <p>
            <label for="status">ステータス</label><br>
            <input type="text" id="status" name="status">
        </p>

        <p>
            <label for="amount">税抜金額</label><br>
            <input type="number" id="amount" name="amount">
        </p>

        <p>
            <label for="start_date">開始日</label><br>
            <input type="date" id="start_date" name="start_date">
        </p>

        <p>
            <label for="end_date">終了日</label><br>
            <input type="date" id="end_date" name="end_date">
        </p>

        <p>
            <label for="assigned_user_id">担当者</label><br>
            <input type="number" id="assigned_user_id" name="assigned_user_id">
        </p>

        <p>
            <label for="memo">メモ</label><br>
            <textarea id="memo" name="memo"></textarea>
        </p>

        <button type="submit">登録</button>
    </form>
</body>

</html>
