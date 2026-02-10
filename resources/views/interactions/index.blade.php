<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件履歴一覧ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 py-2 border">対応日時</th>
                                <th class="px-3 py-2 border">対応種別</th>
                                <th class="px-3 py-2 border">内容</th>
                                <th class="px-3 py-2 border">案件名</th>
                                <th class="px-3 py-2 border">顧客名</th>
                                <th class="px-3 py-2 border">担当者</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($interactions as $interaction)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('interactions.show', $interaction) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $interaction->interacted_at->format('Y-m-d H:i') }}
                                        </a>
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Interaction::TYPE[$interaction->type] }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ Str::limit($interaction->content, 30) }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        @if ($interaction->project)
                                            <a href="{{ route('projects.show', $interaction->project) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $interaction->project->title }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">未設定</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 border">
                                        @if ($interaction->customer)
                                            <a href="{{ route('customers.show', $interaction->customer) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $interaction->customer->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">未設定</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ optional($interaction->user)->name ?? '未設定' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="mt-4 px-6 pb-6">
                {{ $interactions->links() }}
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
