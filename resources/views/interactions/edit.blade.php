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
            <input type="datetime-local" name="interacted_at" id="interacted_at"
                value="{{ $interaction->interacted_at->format('Y-m-d\TH:i') }}">
        </p>

        <p>
            <label for="type">対応種別</label><br>
            <select name="type" id="type">
                @foreach ($types as $key => $label)
                    <option value="{{ $key }}" @selected($interaction->type == $key)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
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
            <select name="project_id" id="project_id">
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @selected($interaction->project_id == $project->id)>
                        {{ $project->title }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="customer_id">顧客名</label><br>
            <select name="customer_id" id="customer_id">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" @selected($interaction->customer_id == $customer->id)>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="assigned_user_id">担当者</label><br>
            <select name="assigned_user_id" id="assigned_user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected($interaction->assigned_user_id == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <button type="submit">更新</button>
    </form>
</body>

</html>
