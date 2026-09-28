<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все отзывы - Логистика</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .star { color: #fbbf24; font-size: 1.25rem; }
        .review-card {
            transition: all 0.3s ease;
        }
        .review-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            transition: all 0.3s ease;
        }
        .btn-orange:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(234, 88, 12, 0.4);
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }
        .pagination a, .pagination span {
            padding: 8px 16px;
            border-radius: 8px;
            background: white;
            color: #374151;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        .pagination a:hover {
            background: #f97316;
            color: white;
            border-color: #f97316;
        }
        .pagination .active span {
            background: #f97316;
            color: white;
            border-color: #f97316;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Навигация -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b-2 border-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <a href="/" class="text-2xl md:text-3xl font-bold">
                    🚛 <span class="text-orange-700">Логистика</span>
                </a>
                <a href="/#reviews" class="text-gray-600 hover:text-orange-600 transition">← На главную</a>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-8 sm:py-12 w-full">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800">Все отзывы</h1>
            <div class="w-24 h-1 bg-orange-500 mx-auto mt-3 rounded-full"></div>
            <p class="text-gray-600 mt-3">Что говорят наши клиенты</p>
        </div>

        <!-- Список отзывов -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reviews as $review)
                <div class="review-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $review->user_name }}</h4>
                            <div class="flex items-center gap-1 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </div>
                        <span class="text-sm text-gray-400">{{ $review->created_at->format('d.m.Y') }}</span>
                    </div>
                    <p class="text-gray-600 mt-3">{{ $review->message }}</p>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    <p class="text-xl">Пока нет отзывов</p>
                    <p class="mt-2">Будьте первым, кто оставит отзыв!</p>
                </div>
            @endforelse
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            {{ $reviews->links() }}
        </div>

        <!-- Кнопка назад -->
        <div class="mt-8 text-center">
            <a href="/#reviews" class="text-orange-600 hover:underline">← Вернуться на главную</a>
        </div>
    </main>

    <!-- Подвал -->
    <footer class="bg-gray-900 text-white py-6 border-t-4 border-orange-500">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>© {{ date('Y') }} ИП Авакян Ш.В. Все права защищены.</p>
            <p class="text-orange-400 text-sm mt-1">Логистика грузоперевозки в Волгограде</p>
        </div>
    </footer>

</body>
</html>
