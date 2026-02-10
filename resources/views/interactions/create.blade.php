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
            <select id="type" name="type">
                @foreach ($types as $key => $label)
                    <option value="{{ $key }}">
                        {{ $label }}</option>
                @endforeach
            </select>
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
            <select id="project_id" name="project_id">
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">
                        {{ $project->title }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="customer_id">顧客名</label><br>
            <select id="customer_id" name="customer_id">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="assigned_user_id">担当者</label><br>
            <select id="assigned_user_id" name="assigned_user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <button type="submit">登録</button>
    </form>
</body>

</html>
