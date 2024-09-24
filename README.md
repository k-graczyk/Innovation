
---

# Aplikacja umożliwa stworzenie pracownika, dodania jego czasu pracy oraz wyciągnięcia podsumowoania roboczo godzin oraz zarobku dla danego dnia lub miesiąca - Laravel API 

## Po pobraniu projektu dostosuj plik config/worktime.php

```php
return [
    'monthly_hours' => 40,               // Norma miesięczna godzin
    'rate' => 20,                        // Stawka godzinowa w PLN
    'overtime_rate_multiplier' => 2.0,   // Mnożnik dla nadgodzin
];
```

## Spis

- [Instalacja](#instalacja)
- [API Endpoints](#api-endpoints)
  - [Tworzenie pracownika](#tworzenie-pracownika)
  - [Tworzenie czasu pracy](#tworzenie-czasu-pracy)
  - [Pobranie raportu dziennego](#pobranie-raportu-dziennego)
  - [Pobranie raportu miesięcznego](#pobranie-raportu-miesięcznego)


---

## Instalacja

Aby uruchomić aplikację lokalnie, wykonaj poniższe kroki:

1. **Sklonuj repozytorium:**

```bash
git clone https://github.com/k-graczyk/Innovation.git
cd Innovation
```

2. **Zainstaluj zależności za pomocą Composer:**

```bash
composer install
```

3. **Skonfiguruj środowisko:**

   Skopiuj plik `.env.example` i nazwij go `.env`, a następnie zaktualizuj wartości w pliku `.env`:

```bash
cp .env.example .env
```

4. **Wygeneruj klucz aplikacji:**

```bash
php artisan key:generate
```

5. **Skonfiguruj bazę danych:**

   W pliku `.env` zaktualizuj ustawienia połączenia z bazą danych:

```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

6. **Uruchom migracje bazy danych:**

```bash
php artisan migrate
```

7. **Uruchom serwer deweloperski:**

```bash
php artisan serve
```

Aplikacja powinna być dostępna pod adresem `http://localhost:8000`.

---


## API Endpoints

### Tworzenie pracownika

**Endpoint:**

```http
POST /api/workers
```

**Body:**

```json
{
    "first_name": "John",
    "last_name":"Doe"
}
```

**Response:**

```json
{
    "data": {
        "id": "Unikalny identyfikator UUid"
    }
}
```

### Tworzenie czasu pracy

**Endpoint:**

```http
POST /api/worktimes
```
**Body:**

```json
{
    "worker_id": "Unikalny identyfikator użytkownika UUid",
    "date_start": "01.01.1970 01:00", 
    "date_end": "01.01.1970 02:00"
}
```

**Response:**

```json
{
    "Czas pracy został dodany"
}
```

### Pobranie raportu dziennego

**Endpoint:**

```http
GET /api/worktimes/daily
```
**Body:**

```json
{
    "worker_id": "Unikalny identyfikator użytkownika UUid",
    "date": "01.01.1970"
}
```

**Response:**

```json
{
    "data": {
        "hours": 5, // ilość godzin
        "rate": "20 PLN", // stawka
        "sum": "100 PLN" // sum zarobku
    }
}
```

### Pobranie raportu miesięcznego

**Endpoint:**

```http
GET /api/worktimes/monthly
```
**Body:**

```json
{
    "worker_id": "Unikalny identyfikator użytkownika UUid",
    "date": "01.1970"
}
```

**Response:**

```json
{
    "data": {
        "normal_hours": 15.5, // ilość godzin standardowych
        "overtime_hours": 0, // ilość nadgodzin
        "rate": "20 PLN", // stawka
        "overtime_rate": "40 PLN", // stawka nadgodzinowa
        "total": "310 PLN" //suma zarobku
    }
}
```


---

### Dodatkowe informacje

- Upewnij się, że serwer bazy danych działa prawidłowo, zanim rozpoczniesz konfigurację.
- Możesz użyć narzędzi takich jak Postman do testowania API.

---
