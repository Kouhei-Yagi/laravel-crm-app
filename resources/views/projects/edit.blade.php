<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>案件編集ページ</title>
</head>

<body>
    <h1>案件編集ページ</h1>

    <form action="{{ route('projects.update', $project) }}" method="post">
        @csrf
        @method('patch')

        <p>
            <label for="title">案件名</label><br>
            <input type="text" name="title" id="title" value="{{ $project->title }}">
        </p>

        <p>
            <label for="customer_id">顧客名</label><br>
            <select name="customer_id" id="customer_id">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" @selected((old('customer_id') ?? $project->customer_id) == $customer->id)>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="description">案件内容</label><br>
            <textarea name="description" id="description">{{ $project->description }}</textarea>
        </p>

        <p>
            <label for="status">案件ステータス</label><br>
            <select name="status" id="status">
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(old('status') ?? $project->status == $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="amount">税抜金額</label><br>
            <input type="number" name="amount" id="amount" value="{{ $project->amount }}"> 円
        </p>

        <p>
            <label for="start_date"">開始日</label><br>
            <input type="date" name="start_date" id="start_date"
                value="{{ optional($project->start_date)->format('Y-m-d') }}">
        </p>

        <p>
            <label for="end_date"">終了日</label><br>
            <input type="date" name="end_date" id="end_date"
                value="{{ optional($project->end_date)->format('Y-m-d') }}">
        </p>

        <p>
            <label for="assigned_user_id">担当者</label><br>
            <select name="assigned_user_id" id="assigned_user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('assigned_user_id') ?? $project->user->id == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="memo">メモ</label><br>
            <textarea name="memo" id="memo">{{ $project->memo }}</textarea>
        </p>

        <button type="submit">更新</button>
    </form>
</body>

</html>
