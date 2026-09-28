<!DOCTYPE html>
<html>
<head>
    <title>Управление отзывами</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Управление отзывами</h1>
            <div>
                <a href="{{ route('admin.index') }}" class="text-gray-600 hover:underline mr-4">← Назад к грузовикам</a>
                <a href="/" class="text-gray-600 hover:underline mr-4">На сайт</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-600 hover:underline">Выйти</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Пользователь</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Оценка</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Отзыв</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr class="{{ $review->is_approved ? 'bg-white' : 'bg-yellow-50' }}">
                            <td class="px-6 py-4">{{ $review->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $review->user_name }}</td>
                            <td class="px-6 py-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-yellow-400">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">{{ $review->message }}</td>
                            <td class="px-6 py-4 text-sm">{{ $review->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-6 py-4">
                                @if($review->is_approved)
                                    <span class="text-green-600 text-sm font-semibold">✅ Одобрен</span>
                                @else
                                    <span class="text-yellow-600 text-sm font-semibold">⏳ На модерации</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <!-- Кнопка Одобрить/Скрыть -->
                                <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="{{ $review->is_approved ? 'text-yellow-600 hover:underline' : 'text-green-600 hover:underline' }}">
                                        {{ $review->is_approved ? '🙈 Скрыть' : '✅ Одобрить' }}
                                    </button>
                                </form>

                                <!-- Кнопка Удалить -->
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Удалить этот отзыв?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">🗑️ Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Отзывов пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
