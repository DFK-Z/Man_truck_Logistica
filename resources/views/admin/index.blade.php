<!DOCTYPE html>
<html>
<head>
    <title>Админка - Грузовики</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Управление грузовиками</h1>
            <div>
                <a href="{{ route('admin.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">+ Добавить грузовик</a>
                <a href="{{ route('admin.reviews') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">📝 Отзывы</a>
                <a href="/" class="ml-2 text-gray-600 hover:underline">На сайт</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ml-2 text-red-600 hover:underline">Выйти</a>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Фото</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Марка</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Модель</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($trucks as $truck)
                        <tr>
                            <td class="px-6 py-4">
                                @if($truck->image && Storage::disk('public')->exists($truck->image))
                                    <img src="{{ Storage::url($truck->image) }}" alt="{{ $truck->brand }}" class="h-12 w-16 object-cover rounded border">
                                @else
                                    <span class="text-gray-400 text-sm">Нет фото</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $truck->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $truck->brand }}</td>
                            <td class="px-6 py-4">{{ $truck->model }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('admin.edit', $truck) }}" class="text-blue-600 hover:underline">Редактировать</a>
                                <form action="{{ route('admin.destroy', $truck) }}" method="POST" class="inline" onsubmit="return confirm('Удалить грузовик?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Грузовиков пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
