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
            <input type="text" id="name" name="name" placeholder="例：山田太郎" value="{{ old('name') }}">
            @error('name')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="kana">フリガナ</label><br>
            <input type="text" id="kana" name="kana" placeholder="例：ヤマダタロウ" value="{{ old('kana') }}">
            @error('kana')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="email">メール</label><br>
            <input type="email" id="email" name="email" placeholder="例：example@example.com"
                value="{{ old('email') }}">
            @error('email')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="phone">電話番号</label><br>
            <input type="tel" id="phone" name="phone" placeholder="例：090-1234-5678"
                value="{{ old('phone') }}">
            @error('phone')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="postal_code">郵便番号</label><br>
            <input type="text" id="postal_code" name="postal_code" placeholder="例：123-4567"
                value="{{ old('postal_code') }}">
            @error('postal_code')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="address">住所</label><br>
            <input type="text" id="address" name="address" placeholder="例：福岡県福岡市〇〇" value="{{ old('address') }}">
            @error('address')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="address_detail">住所詳細</label><br>
            <input type="text" id="address_detail" name="address_detail" placeholder="例：マンション名・部屋番号など"
                value="{{ old('address_detail') }}">
            @error('address_detail')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="company_name">会社名</label><br>
            <input type="text" id="company_name" name="company_name" placeholder="例：株式会社サンプル"
                value="{{ old('company_name') }}">
            @error('company_name')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="department">部署</label><br>
            <input type="text" id="department" name="department" value="{{ old('department') }}">
            @error('department')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="position">役職</label><br>
            <input type="text" id="position" name="position" value="{{ old('position') }}">
            @error('position')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="status">ステータス</label><br>
            <select name="status" id="status">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status') == $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            @error('status')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="rank">ランク</label><br>
            <select name="rank" id="rank">
                @foreach ($ranks as $rank)
                    <option value="{{ $rank }}" @selected(old('rank') == $rank)>
                        {{ $rank }}
                    </option>
                @endforeach
            </select>
            @error('rank')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="assigned_user_id">担当者</label><br>
            <select name="assigned_user_id" id="assigned_user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('assigned_user_id') == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('assigned_user_id')
                {{ $message }}
            @enderror
        </div>

        <div>
            <label for="memo">メモ</label><br>
            <textarea id="memo" name="memo" placeholder="自由記述欄">{{ old('memo') }}</textarea>
            @error('memo')
                {{ $message }}
            @enderror
        </div>

        <button type="submit">登録する</button>
    </form>

</body>

</html>
