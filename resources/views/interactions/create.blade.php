<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件履歴新規作成ページ</title>
</head>

<body>
    <h1>案件履歴新規作成ページ</h1>

    <form action="{{ route('interactions.store') }}" method="post">
        @csrf

        <p>
            <label for="interacted_at">対応日時</label><br>
            <input type="datetime-local" id="interacted_at" name="interacted_at">
        </p>

        <p>
            <label for="type">対応種別</label><br>
            <input type="text" id="type" name="type">
        </p>

        <p>
            <label for="content">内容</label><br>
            <textarea id="content" name="content"></textarea>
        </p>


        <p>
            <label for="memo">メモ</label><br>
            <textarea id="memo" name="memo"></textarea>
        </p>

        <p>
            <label for="project_id">案件名</label><br>
            <input type="number" id="project_id" name="project_id">
        </p>

        <p>
            <label for="customer_id">顧客名</label><br>
            <input type="number" id="customer_id" name="customer_id">
        </p>

        <p>
            <label for="assigned_user_id">担当者</label><br>
            <input type="number" id="assigned_user_id" name="assigned_user_id">
        </p>

        <button type="submit">登録</button>
    </form>
</body>

</html>
