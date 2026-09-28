# МАН Грузоперевозки — Man Truck Site

Сайт ИП Авакян Ш.В. — грузоперевозки и поставка строительных материалов в Волгограде.

**Стек:** React + Vite + Tailwind CSS · Node.js + Express · PostgreSQL

---

## Структура проекта

```
Man_Truck_Site/
├── client/          # React + Vite фронтенд
└── server/          # Node.js + Express API
```

---

## Быстрый старт

### 1. PostgreSQL

Убедитесь что PostgreSQL запущен, затем создайте базу и схему:

```powershell
$env:PGPASSWORD = "ваш_пароль"
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -c "CREATE DATABASE man_truck_db;"
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -d man_truck_db -f server/schema.sql
```

### 2. Сервер (Node.js API)

```powershell
cd server
# Заполните .env (скопируйте из .env.example)
Copy-Item .env.example .env
npm install
npm run dev      # http://localhost:5000
```

### 3. Клиент (React + Vite)

```powershell
cd client
npm install
npm run dev      # http://localhost:5173
```

---

## API эндпоинты

### Auth
| Метод | URL                  | Описание         |
|-------|----------------------|------------------|
| POST  | /api/auth/register   | Регистрация      |
| POST  | /api/auth/login      | Вход (JWT)       |
| GET   | /api/auth/me         | Текущий юзер     |

### Грузовики (публичные)
| Метод | URL               | Описание              |
|-------|-------------------|-----------------------|
| GET   | /api/trucks       | Список всех           |
| GET   | /api/trucks/:id   | Детальная страница    |

### Грузовики (только admin)
| Метод  | URL              | Описание     |
|--------|-----------------|--------------|
| POST   | /api/trucks      | Создать      |
| PUT    | /api/trucks/:id  | Обновить     |
| DELETE | /api/trucks/:id  | Удалить      |

### Отзывы
| Метод  | URL                          | Доступ          |
|--------|------------------------------|-----------------|
| GET    | /api/reviews                 | Публичный       |
| GET    | /api/reviews/latest          | Публичный (3шт) |
| POST   | /api/reviews                 | Авторизованные  |
| GET    | /api/reviews/admin           | Admin           |
| PATCH  | /api/reviews/:id/toggle      | Admin           |
| DELETE | /api/reviews/:id             | Admin           |

---

## Создание администратора

Зарегистрируйтесь через сайт, затем вручную установите роль в базе:

```sql
UPDATE users SET role = 'admin' WHERE email = 'ваш@email.com';
```

---

## Загрузка изображений

Файлы сохраняются в `server/uploads/trucks/` и отдаются по пути `/uploads/trucks/<filename>`.
