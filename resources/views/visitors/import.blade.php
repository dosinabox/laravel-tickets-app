<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Импорт</title>
    @vite(['resources/css/search.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="search-container">
        @if($success)
            Записей импортировано: {{ $count }}
            <a href="{{ route('visitors.ui.manage') }}">
                <button>К управлению</button>
            </a>
            <a href="{{ route('visitors.ui.import') }}">
                <button>Начать заново</button>
            </a>
        @else
            <form method="POST" action="{{ route('visitors.ui.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="search-input-container">
                    Выберите файл для импорта (.xls или .xlsx)
                    <input type="file" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                </div>
                <button type="submit">Загрузить</button>
                @if($error)
                    <span style="color: #FF2D20">Ошибка импорта: {{ $error }}</span>
                @endif
            </form>
        @endif
    </div>
</div>
</body>
</html>
