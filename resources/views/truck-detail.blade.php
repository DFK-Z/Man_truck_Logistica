<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $truck->brand }} {{ $truck->model }} - TruckMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .btn-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            transition: all 0.3s ease;
        }
        .btn-orange:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(234, 88, 12, 0.4);
        }
        /* Стили для всплывающих подсказок */
        .tooltip {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .group:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: #1f2937;
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Навигация -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b-2 border-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <a href="/" class="text-2xl md:text-3xl font-bold">
                    🚛 <span class="text-orange-700">Логистика</span>
                </a>
                <a href="/" class="text-gray-600 hover:text-orange-600 transition">← На главную</a>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="flex-grow">
        <div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-8 p-6 sm:p-8">
                    <!-- Фото -->
                    <div>
                        @if($truck->image && file_exists(public_path('storage/' . $truck->image)))
                            <img src="{{ asset('storage/' . $truck->image) }}"
                                 alt="{{ $truck->brand }} {{ $truck->model }}"
                                 class="w-full h-auto rounded-xl shadow-lg object-cover">
                        @else
                            <div class="w-full h-96 bg-orange-50 flex items-center justify-center text-orange-300 rounded-xl">
                                <span class="text-lg">Нет фото</span>
                            </div>
                        @endif
                    </div>

                    <!-- Информация -->
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">{{ $truck->brand }} {{ $truck->model }}</h1>

                        <!-- Кнопки с подсказками -->
                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <!-- Кнопка "Позвонить" -->
                            <div class="relative group flex-1">
                                <a href="tel:89023143540"
                                   class="btn-orange text-white px-8 py-3 rounded-lg font-semibold text-center block w-full">
                                    📞 Позвонить
                                </a>
                                <!-- Всплывающая подсказка -->
                                <div class="tooltip absolute bottom-full left-0 mb-3 w-full bg-gray-800 text-white text-sm rounded-lg shadow-xl p-3 z-10">
                                    <p class="font-semibold text-orange-400 mb-1">📱 Номера телефонов:</p>
                                    <p>+7 (902) 314-35-40</p>
                                    <p>+7 (902) 363-54-00</p>
                                </div>
                            </div>

                            <!-- Кнопка "Написать" -->
                            <div class="relative group flex-1">
                                <a href="mailto:guga-2005@mail.ru"
                                   class="border-2 border-orange-500 text-orange-600 px-8 py-3 rounded-lg font-semibold text-center hover:bg-orange-500 hover:text-white transition block w-full">
                                    ✉️ Написать
                                </a>
                                <!-- Всплывающая подсказка -->
                                <div class="tooltip absolute bottom-full left-0 mb-3 w-full bg-gray-800 text-white text-sm rounded-lg shadow-xl p-3 z-10">
                                    <p class="font-semibold text-orange-400 mb-1">📧 Email:</p>
                                    <p>guga-2005@mail.ru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Кнопка назад -->
            <div class="mt-8 text-center">
                <a href="/#trucks" class="text-orange-600 hover:underline">← Вернуться к каталогу</a>
            </div>
        </div>
    </main>

    <!-- Cookie уведомление -->
<div id="cookie-consent" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 z-50 flex flex-col sm:flex-row justify-between items-center gap-4">
    <p class="text-sm text-center sm:text-left">
        🍪 Мы используем cookie для улучшения работы сайта. Продолжая использовать сайт, вы соглашаетесь с
        <a href="#" class="text-orange-400 hover:underline">политикой конфиденциальности</a>.
    </p>
    <button onclick="document.getElementById('cookie-consent').style.display='none'"
            class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 whitespace-nowrap">
        Принять
    </button>
</div>

<!-- ==================== ПОДВАЛ ==================== -->
    <footer class="bg-gray-900 text-white py-6 sm:py-8 border-t-4 border-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-sm sm:text-base">© {{ date('Y') }} ИП Авакян Ш.В. Все права защищены.</p>
                <p class="text-orange-400 text-xs sm:text-sm mt-1">Логистика грузоперевозки в Волгограде</p>
                <div class="mt-4 flex justify-center gap-4 text-xs sm:text-sm">
                    <a href="#" class="text-gray-400 hover:text-orange-400 transition">Политика конфиденциальности</a>
                    <span class="text-gray-600">|</span>
                    <a href="#" class="text-gray-400 hover:text-orange-400 transition">Условия использования</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
