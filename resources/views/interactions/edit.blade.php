<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件履歴編集</title>
</head>

<body>
    <h1>案件履歴編集</h1>

    <form action="{{ route('interactions.update', $interaction) }}" method="post">
        @csrf
        @method('patch')

        <p>
            <label for="interacted_at">対応日時</label><br>
            <input type="datetime-local" name="interacted_at" id="interacted_at" value="{{ $interaction->interacted_at }}">
        </p>

        <p>
            <label for="type">対応種別</label><br>
            <input type="text" name="type" id="type" value="{{ $interaction->type }}">
        </p>

        <p>
            <label for="content">内容</label><br>
            <textarea name="content" id="content">{{ $interaction->content }}</textarea>
        </p>

        <p>
            <label for="memo">メモ</label><br>
            <textarea name="memo" id="memo">{{ $interaction->memo }}</textarea>
        </p>

        <p>
            <label for="project_id">案件名</label><br>
            <input type="number" name="project_id" id="project_id" value="{{ $interaction->project_id }}">
        </p>

        <p>
            <label for="customer_id">顧客名</label><br>
            <input type="number" name="customer_id" id="customer_id" value="{{ $interaction->customer_id }}">
        </p>

        <p>
            <label for="assigned_user_id">担当者</label><br>
            <input type="number" name="assigned_user_id" id="assigned_user_id"
                value="{{ $interaction->assigned_user_id }}">
        </p>

        <button type="submit">更新</button>
    </form>
</body>

</html>
