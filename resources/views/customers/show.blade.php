<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 詳細データ --}}
                    <table class="w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border w-40">顧客名</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->name }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">フリガナ</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->kana ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メール</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->email ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">電話番号</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->phone ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">会社名</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->company_name ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">部署</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->department ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">役職</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->position ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">郵便番号</th>
                                <td class="px-3 py-2 border whitespace-normal break-words">
                                    {{ $customer->postal_code ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">住所</th>
                                <td class="px-3 py-2 border whitespace-normal break-words">
                                    {{ $customer->address ?: '未設定' }} {{ $customer->address_detail }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ステータス</th>
                                <td class="px-3 py-2 border">
                                    {{ App\Models\Customer::STATUSES[$customer->status] }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ランク</th>
                                <td class="px-3 py-2 border">
                                    {{ App\Models\Customer::RANKS[$customer->rank] }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">担当者</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->assignedUser->name }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">作成日</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->created_at->format('Y-m-d') }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">更新日</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->updated_at->format('Y-m-d') }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メモ</th>
                                <td class="px-3 py-2 border whitespace-pre-line">{{ $customer->memo ?: '未設定' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
                        <x-button.primary href="{{ route('customers.edit', $customer) }}">
                            編集
                        </x-button.primary>

                        <form action="{{ route('customers.destroy', $customer) }}" method="post" class="inline-block">
                            @csrf
                            @method('delete')
                            <x-button.danger type="submit" onclick="return confirm('本当に削除しますか？')">
                                削除
                            </x-button.danger>
                        </form>

                        <x-button.secondary href="{{ route('customers.index') }}">
                            一覧に戻る
                        </x-button.secondary>
                    </div>

                    {{-- 案件一覧 --}}
                    <x-customer.project-list :projects="$projects">
                        <tbody>
                            {{-- レコード --}}
                            @foreach ($projects as $project)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                                    {{-- 案件名 --}}
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">
                                            {{ $project->title }}
                                        </a>
                                    </td>

                                    {{-- ステータス --}}
                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Project::STATUSES[$project->status] }}
                                    </td>

                                    {{-- 税抜金額 --}}
                                    <td class="px-3 py-2 border">
                                        {{ number_format($project->amount) ?: '未設定'}}
                                    </td>

                                    {{-- 期間 --}}
                                    <td class="px-3 py-2 border">
                                        {{ optional($project->start_date)->format('Y-m-d') ?: '未設定' }}
                                        ～
                                        {{ optional($project->end_date)->format('Y-m-d') ?: '未設定' }}
                                    </td>

                                    {{-- 担当者 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $project->assignedUser->name }}
                                    </td>

                                    {{-- 作成日 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $project->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-customer.project-list>

                    {{-- 対応履歴一覧 --}}
                    <h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
                        対応履歴一覧（{{ $interactions->count() }}件）
                    </h3>

                    @if ($interactions->isEmpty())
                        <p class="text-gray-500">対応履歴はありません。</p>
                    @else
                        {{-- 一覧データ --}}
                        <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">
                            {{-- 項目名 --}}
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    {{-- 対応日時 --}}
                                    <th class="px-3 py-2 border">対応日時</th>

                                    {{-- 対応種別 --}}
                                    <th class="px-3 py-2 border">対応種別</th>

                                    {{-- 内容 --}}
                                    <th class="px-3 py-2 border">内容</th>

                                    {{-- 担当者 --}}
                                    <th class="px-3 py-2 border">担当者</th>

                                    {{-- 関係案件 --}}
                                    <th class="px-3 py-2 border">関係案件</th>
                                </tr>
                            </thead>

                            {{-- レコード --}}
                            <tbody>
                                @foreach ($interactions as $interaction)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                                        {{-- 対応日時 --}}
                                        <td class="px-3 py-2 border">
                                            {{ $interaction->interacted_at->format('Y-m-d H:i') }}
                                        </td>

                                        {{-- 対応種別 --}}
                                        <td class="px-3 py-2 border">
                                            {{ App\Models\Interaction::TYPE[$interaction->type] }}
                                        </td>

                                        {{-- 内容 --}}
                                        <td class="px-3 py-2 border">
                                            {{ Str::limit($interaction->content, 30) }}
                                        </td>

                                        {{-- 担当者 --}}
                                        <td class="px-3 py-2 border">
                                            {{ $interaction->assignedUser->name }}
                                        </td>

                                        {{-- 関係案件 --}}
                                        <td class="px-3 py-2 border">
                                            @if ($interaction->project)
                                                <a href="{{route('projects.show', $interaction->project)}}" class="text-blue-600 hover:underline">
                                                    {{ $interaction->project->title }}
                                                </a>
                                            @else
                                                未設定
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
