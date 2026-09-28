{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ config('app.name') }} - Продажа грузовиков</title>
    <meta name="description" content="Продажа грузовиков и спецтехники. Индивидуальный предприниматель Авакян Ш.В.">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Оранжевая цветовая схема */
        :root {
            --orange-500: #f97316;
            --orange-600: #ea580c;
            --orange-700: #c2410c;
            --orange-800: #9a3412;
            --orange-900: #7c2d12;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .truck-card {
            transition: all 0.3s ease;
        }
        .truck-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(234, 88, 12, 0.15);
        }

        .mobile-menu {
            transition: max-height 0.3s ease;
            max-height: 0;
            overflow: hidden;
        }
        .mobile-menu.open {
            max-height: 500px;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #ea580c 0%, #9a3412 100%);
        }

        .btn-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            transition: all 0.3s ease;
        }
        .btn-orange:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(234, 88, 12, 0.4);
        }

        .btn-orange-outline {
            border: 2px solid #f97316;
            color: #f97316;
            transition: all 0.3s ease;
        }
        .btn-orange-outline:hover {
            background: #f97316;
            color: white;
            transform: translateY(-2px);
        }

        .badge-orange {
            background: linear-gradient(135deg, #f97316, #ea580c);
        }

        .stat-number {
            background: linear-gradient(135deg, #f97316, #ea580c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .review-card {
            transition: all 0.3s ease;
        }
        .review-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .star {
            color: #fbbf24;
            font-size: 1.25rem;
        }

        /* ===== КНОПКА "НАВЕРХ" ===== */
        .scroll-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(234, 88, 12, 0.4);
            transition: all 0.3s ease;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px) scale(0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .scroll-top-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 30px rgba(234, 88, 12, 0.6);
        }
        .scroll-top-btn:active {
            transform: scale(0.95);
        }
        .scroll-top-btn.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        .scroll-top-btn svg {
            width: 28px;
            height: 28px;
            stroke: white;
            stroke-width: 2.5;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @media (max-width: 640px) {
            .hero-title {
                font-size: 2.25rem !important;
                line-height: 1.2 !important;
            }
            .hero-subtitle {
                font-size: 1.125rem !important;
            }
            .contact-info {
                font-size: 0.875rem !important;
            }
            .scroll-top-btn {
                bottom: 20px;
                right: 20px;
                width: 48px;
                height: 48px;
            }
            .scroll-top-btn svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .hero-title {
                font-size: 3rem !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">

    <!-- ==================== НАВИГАЦИЯ ==================== -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b-2 border-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <!-- Логотип -->
                <div class="flex items-center flex-shrink-0">
                    <a href="/" class="text-2xl md:text-3xl font-bold">
                        🚛 <span class=" text-orange-700">Логистика</span>
                    </a>
                </div>

                <!-- Десктопное меню -->
                <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                    <a href="#trucks" class="text-gray-700 hover:text-orange-600 transition font-medium">Грузовики</a>
                    <a href="#about" class="text-gray-700 hover:text-orange-600 transition font-medium">О нас</a>
                    <a href="#reviews" class="text-gray-700 hover:text-orange-600 transition font-medium">Отзывы</a>
                    <a href="#contacts" class="text-gray-700 hover:text-orange-600 transition font-medium">Контакты</a>

                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="/admin" class="btn-orange text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                Админка
                            </a>
                        @endif
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-700 hover:text-orange-600 transition font-medium">
                            Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-orange-600 transition font-medium">Войти</a>
                    @endauth
                </div>

                <!-- Мобильная кнопка меню -->
                <div class="md:hidden flex items-center gap-2">
                    <a href="tel:89023143540" class="btn-orange text-white px-3 py-1.5 rounded-lg text-sm font-semibold flex items-center gap-1">
                        <span class="text-lg">📞</span>
                        <span class="hidden xs:inline">Позвонить</span>
                    </a>
                    <button id="menuToggle" class="text-gray-700 hover:text-orange-600 focus:outline-none p-2 rounded-lg hover:bg-orange-50 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Мобильное меню -->
            <div id="mobileMenu" class="mobile-menu md:hidden bg-white border-t border-gray-100">
                <div class="py-3 space-y-2">
                    <a href="#trucks" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition">Грузовики</a>
                    <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition">О нас</a>
                    <a href="#reviews" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition">Отзывы</a>
                    <a href="#contacts" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition">Контакты</a>

                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="/admin" class="block px-4 py-2 text-orange-600 font-semibold hover:bg-orange-50 rounded-lg transition">Админка</a>
                        @endif
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition">
                            Выйти
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="/login" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition">Войти</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO СЕКЦИЯ ==================== -->
    <section class="hero-gradient text-white py-12 sm:py-16 md:py-20 lg:py-24 overflow-hidden relative">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="order-2 lg:order-1 text-center lg:text-left">
                    <h1 class="hero-title text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                        Логистика грузоперевозки, поставка строительных материалов
                        <span class="block text-orange-200 mt-1">в Волгограде</span>
                    </h1>
                    <p class="hero-subtitle text-base sm:text-lg md:text-xl mt-4 text-orange-100 max-w-2xl mx-auto lg:mx-0">
                        Надежная техника. Гарантия качества
                    </p>
                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                        <a href="#trucks" class="bg-white text-orange-600 px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-semibold hover:bg-orange-50 transition shadow-lg text-center">
                            📋 Смотреть каталог
                        </a>
                        <a href="#contacts" class="border-2 border-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-semibold hover:bg-white hover:text-orange-600 transition text-center">
                            📞 Связаться
                        </a>
                    </div>

                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto lg:mx-0">
                        <div class="flex items-center justify-center gap-3 bg-white/10 rounded-xl backdrop-blur-sm px-4 py-3">
                            <span class="text-2xl">💰</span>
                            <div>
                                <div class="text-sm font-semibold text-white">Лучшие цены</div>
                                <div class="text-xs text-orange-200">Прямые поставки</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-3 bg-white/10 rounded-xl backdrop-blur-sm px-4 py-3">
                            <span class="text-2xl">⏳</span>
                            <div>
                                <div class="text-sm font-semibold text-white">10+ лет опыта</div>
                                <div class="text-xs text-orange-200">Надёжность</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-3 bg-white/10 rounded-xl backdrop-blur-sm px-4 py-3">
                            <span class="text-2xl">🛡️</span>
                            <div>
                                <div class="text-sm font-semibold text-white">100% гарантия</div>
                                <div class="text-xs text-orange-200">Качества и сроков</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <img src="{{ asset('images/mantruck-1.jpg') }}"
                             alt="Грузовик"
                             class="rounded-2xl shadow-2xl w-full h-auto max-h-[400px] sm:max-h-[500px] object-cover border-4 border-white/20"
                             loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== О НАС ==================== -->
    <section id="about" class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-sm border border-orange-200">
                <div class="grid md:grid-cols-2 gap-6 md:gap-10">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">ИНДИВИДУАЛЬНЫЙ ПРЕДПРИНИМАТЕЛЬ</h2>
                        <p class="text-lg sm:text-xl font-semibold text-orange-600 mt-2">АВАКЯН ШАГЕН ВАРАЗДАТОВИЧ</p>
                        <p class="text-gray-600 mt-1 text-sm sm:text-base">ОТ 27.12.2018</p>

                        <div class="mt-4 sm:mt-6 space-y-1.5 sm:space-y-2 text-sm sm:text-base">
                            <p><span class="font-semibold">ИНН:</span> 344597041102</p>
                            <p><span class="font-semibold">ОГРНИП:</span> 318344300129387</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg sm:text-xl text-gray-800">Перевозка строительных материалов:</h3>
                        <ul class="mt-3 space-y-1.5 text-sm sm:text-base text-gray-600">
                            <li class="flex items-start gap-2">
                                <span class="text-orange-500 mt-0.5 font-bold">✓</span>
                                <span>Песок и щебень</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-orange-500 mt-0.5 font-bold">✓</span>
                                <span>Асфальт и бетонная смесь</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-orange-500 mt-0.5 font-bold">✓</span>
                                <span>Строительные блоки</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-orange-500 mt-0.5 font-bold">✓</span>
                                <span>Камни и другие материалы</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== КАТАЛОГ ГРУЗОВИКОВ ==================== -->
    <section id="trucks" class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800">Наши грузовики</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mt-3 rounded-full"></div>
                <p class="text-gray-600 mt-3 text-sm sm:text-base">Выберите подходящую технику для ваших задач</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @forelse($trucks ?? [] as $truck)
                    <div class="truck-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl border-t-4 border-orange-500">
                        <div class="relative">
                            @if($truck->image)
                                <img src="{{ Storage::url($truck->image) }}"
                                     alt="{{ $truck->brand }} {{ $truck->model }}"
                                     class="w-full h-48 sm:h-56 object-cover"
                                     loading="lazy">
                            @else
                                <div class="w-full h-48 sm:h-56 bg-orange-50 flex items-center justify-center text-orange-300">
                                    <span class="text-sm">Нет фото</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 sm:p-6">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 truncate">{{ $truck->brand }} {{ $truck->model }}</h3>
                                </div>
                                <span class="text-xl sm:text-2xl font-bold text-orange-600 whitespace-nowrap">{{ $truck->formatted_price }}</span>
                            </div>

                            <div class="mt-4 flex flex-col xs:flex-row justify-between items-stretch xs:items-center gap-2">
                                <a href="/truck/{{ $truck->id }}"
                                   class="btn-orange text-white px-4 py-2 rounded-lg text-sm font-semibold text-center">
                                    Подробнее →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12 text-gray-500">
                        <p class="text-xl">Грузовики скоро появятся</p>
                        <p class="mt-2 text-sm">Следите за обновлениями</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==================== ОТЗЫВЫ ==================== -->
    <section id="reviews" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800">Отзывы клиентов</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mt-3 rounded-full"></div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
                @forelse($reviews ?? [] as $review)
                    <div class="review-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $review->user_name }}</h4>
                                <div class="flex items-center gap-1 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-yellow-400">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-400">{{ $review->created_at->format('d.m.Y') }}</span>
                        </div>
                        <p class="text-gray-600 mt-3">{{ $review->message }}</p>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8 text-gray-500">
                        <p>Пока нет отзывов. Будьте первым!</p>
                    </div>
                @endforelse
            </div>

            <!-- ===== ССЫЛКА НА ВСЕ ОТЗЫВЫ ===== -->
            <div class="text-center mt-8">
                <a href="{{ route('reviews.index') }}" class="btn-orange text-white px-6 py-2 rounded-lg inline-block hover:shadow-lg transition">
                    Смотреть все отзывы →
                </a>
            </div>

            <div class="max-w-2xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-8 border border-orange-100">
                @auth
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Оставить отзыв</h3>
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ваше имя</label>
                            <input type="text" value="{{ Auth::user()->name }}" disabled
                                   class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Оценка</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                        <span class="text-xl">{{ $i }}★</span>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ваш отзыв *</label>
                            <textarea name="message" required rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                      placeholder="Расскажите о вашем опыте..."></textarea>
                        </div>
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-orange-700 transition shadow-lg">
                            📨 Отправить отзыв
                        </button>
                    </form>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 text-lg">Чтобы оставить отзыв, необходимо</p>
                        <div class="mt-4 flex justify-center gap-4">
                            <a href="{{ route('login') }}" class="btn-orange text-white px-6 py-2 rounded-lg">
                                Войти
                            </a>
                            <a href="{{ route('register') }}" class="btn-orange-outline px-6 py-2 rounded-lg">
                                Зарегистрироваться
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </section>

    <!-- ==================== КОНТАКТЫ ==================== -->
    <section id="contacts" class="py-12 sm:py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Контакты</h2>
                    <div class="w-16 h-1 bg-orange-500 mt-3 rounded-full"></div>
                    <div class="mt-6 space-y-4 sm:space-y-5">
                        <div class="flex items-start gap-3 contact-info hover:bg-orange-50 p-3 rounded-lg transition">
                            <span class="text-2xl flex-shrink-0">📍</span>
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Юридический адрес:</p>
                                <p class="text-gray-600 text-sm sm:text-base">400038, Волгоградская обл. Городищенский район, с. Студено-Яблоновка, дом 45а</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 contact-info hover:bg-orange-50 p-3 rounded-lg transition">
                            <span class="text-2xl flex-shrink-0">🏢</span>
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Фактический адрес:</p>
                                <p class="text-gray-600 text-sm sm:text-base">400120, г.Волгоград, ул.Неждановой, дом 10а</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 contact-info hover:bg-orange-50 p-3 rounded-lg transition">
                            <span class="text-2xl flex-shrink-0">📞</span>
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Телефон:</p>
                                <p class="text-gray-600 text-sm sm:text-base grid">
                                    <a href="tel:89023143540" class="hover:text-orange-600 transition font-medium">
                                        +7 (902) 314-35-40
                                    </a>
                                    <a href="tel:89023143540" class="hover:text-orange-600 transition font-medium">
                                        +7 (902) 363-54-00
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 contact-info hover:bg-orange-50 p-3 rounded-lg transition">
                            <span class="text-2xl flex-shrink-0">✉️</span>
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Email:</p>
                                <p class="text-gray-600 text-sm sm:text-base break-all">
                                    <a href="mailto:guga-2005@mail.ru" class="hover:text-orange-600 transition">
                                        guga-2005@mail.ru
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 sm:p-8 border border-orange-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Часы работы</h3>
                        <div class="space-y-2 text-gray-600 text-sm sm:text-base">
                            <p class="flex justify-between border-b border-orange-100 pb-2">
                                <span>Ежедневно:</span>
                                <span class="font-medium text-orange-600">8:00 - 20:00</span>
                            </p>
                            <p class="flex justify-between pb-2">
                                <span>Без выходных</span>
                                <span class="text-green-600 font-medium">✅ Работаем</span>
                            </p>
                        </div>

                        <div class="mt-6 p-4 bg-white rounded-lg shadow-sm border border-orange-100">
                            <p class="font-semibold text-gray-700 text-sm sm:text-center">Свяжитесь с нами удобным способом</p>
                            <div class="mt-3 flex flex-col sm:flex-row gap-3">
                                <a href="tel:89023143540"
                                   class="btn-orange text-white px-6 py-2.5 rounded-lg text-center font-semibold text-sm sm:text-base">
                                    📞 Позвонить
                                </a>
                                <a href="mailto:guga-2005@mail.ru"
                                   class="btn-orange-outline px-6 py-2.5 rounded-lg text-center font-semibold text-sm sm:text-base">
                                    ✉️ Написать
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== COOKIE ==================== -->
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

    <!-- ==================== КНОПКА "НАВЕРХ" ==================== -->
    <button onclick="scrollToTop()" id="scrollTopBtn" class="scroll-top-btn" aria-label="Наверх">
        <svg viewBox="0 0 24 24">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>

    <!-- ==================== СКРИПТЫ ==================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('open');
                });

                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('open');
                    });
                });
            }

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // ===== КНОПКА "НАВЕРХ" =====
            const scrollBtn = document.getElementById('scrollTopBtn');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add('visible');
                } else {
                    scrollBtn.classList.remove('visible');
                }
            });

            window.scrollToTop = function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
        });
    </script>
</body>
</html>
