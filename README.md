## Установка

### Требования

- PHP 8.0 или выше
- Composer
- Node.js и npm
- PostgreSQL
- Docker (опционально)

### Установка бэкенда (Laravel)

1. Клонируйте репозиторий:
   
   ```
   git clone https://github.com/D1akk/pet.git api
   cd api
   ```

2. Установите зависимости:
   
   ```
   composer install
   ```

3. Создайте файл .env на основе .env.example

  ```
  cp .env.example .env
  ```

4. Настройте подключение к базе данных в .env:

  ```
  DB_CONNECTION=pgsql
  DB_HOST=127.0.0.1
  DB_PORT=5432
  DB_DATABASE=ваша_база_данных
  DB_USERNAME=ваш_пользователь
  DB_PASSWORD=ваш_пароль
  ```
5. Сгенерируйте ключ приложения, gримените миграции и запустите сервер:
  ```
  php artisan key:generate
  php artisan migrate
  php artisan serve
  ```

### Установка фронтенда (Vue.js)

1. Перейдите в директорию фронтенда
2. Установите зависимости
3. Запустите проект

```
cd ../client
npm install
npm run serve

```

### Для запуска тестов

```
php artisan jwt:secret --env=testing
php artisan migrate --env=testing   
php artisant test 
```
