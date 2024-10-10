<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $visitor->getCategory() }}</title>
    @if($visitor->getCategory() === \App\Models\Visitor::CATEGORY_EMPLOYEE)
        @vite(['resources/css/visitors/employee.css'])
    @elseif($visitor->getCategory() === \App\Models\Visitor::CATEGORY_VIP)
        @vite(['resources/css/visitors/vip.css'])
    @else
        @vite(['resources/css/visitors/common.css'])
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <p class="title">{{ $visitor->getCategory() }}</p>
    <p class="name">{{ $visitor->getName() }}<br>{{ $visitor->getLastName() }}</p>
    @if(session('error'))
        <p class="name">
            <span style="color: #FF2D20">Ошибка: {{ session('error') }}</span>
        </p>
    @endif
    @auth
        @if($visitor->getStatus())
            <p class="name" style="color: forestgreen">{{ $visitor->getStatus() }}</p>
        @else
            <a href="{{ route('visitors.ui.pass', ['code' => $visitor->getCode()]) }}">
                <button class="back-button">Подтвердить посещение</button>
            </a>
            <br>
            <br>
        @endif
    @endauth
    <a href="{{ route('visitors.ui.search') }}">
        <button class="back-button">Назад к поиску</button>
    </a>
</div>
</body>
</html>
