<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                案件履歴一覧
            </h2>

            {{-- ボタン --}}
            <a href="{{ route('interactions.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                新規作成
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div
                            class="mb-4 p-3 rounded-md bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-100 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

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
                                            未設定
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('customers.show', $interaction->customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $interaction->customer->name }}
                                        </a>
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ $interaction->assignedUser->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="mt-4">
                {{ $interactions->links() }}
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
