<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Одобрение участников</title>
    @vite(['resources/css/visitors/manage.css', 'resources/js/visitors/manage.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="header">
    <h1>Одобрение участников мероприятия</h1>
    <p class="stats">
        Всего: {{ count($visitors) }},
        новых: {{ $newCount }},
        сотрудник: {{ $employeesCount }},
        СМИ: {{ $pressCount }},
        VIP: {{ $vipCount }},
        гость: {{ $guestsCount }},
        отказано: {{ $rejectedCount }}
    </p>
</div>

<div class="content">
    <div class="search-bar">
        <form method="GET" action="{{ route('visitors.ui.manage') }}">
            <input type="text" id="query" name="query" value="{{ $query ?? '' }}" placeholder="Поиск по имени, фамилии или коду">
            <button class="btn" type="submit" style="height: 35px; width: 100px">Найти</button>
        </form>
        <a href="{{ route('visitors.ui.import') }}">
            <button class="btn" style="height: 35px; background: #00BFFF">Импорт XLSX</button>
        </a>
        <a href="{{ route('visitors.ui.export') }}">
            <button class="btn" style="height: 35px; background: #00BFFF">Шаблон XLSX</button>
        </a>
        @if(session('error'))
            <span style="color: #FF2D20">Ошибка экспорта: {{ session('error') }}</span>
        @endif
    </div>
    <table>
        <thead>
        <tr>
            <th>Дата и время</th>
            <th>Имя и фамилия</th>
            <th>Компания</th>
            <th>Категория</th>
            <th>Отказ</th>
            <th>Телеграм</th>
            <th>Email</th>
            <th>Код</th>
        </tr>
        </thead>
        <tbody>
        @if(count($visitors) > 0)
            @foreach ($visitors as $visitor)
                <tr>
                    <td>{{ $visitor->getCreatedAt() }}</td>
                    <td>{{ $visitor->getName() }} {{ $visitor->getLastName() }}</td>
                    <td>{{ Str::limit($visitor->getCompany(), 30) }}</td>
                    <td>
                        <button
                            class="btn {{ $visitor->getCategory() === \App\Models\Visitor::CATEGORY_EMPLOYEE ? 'btn-employee' : '' }}"
                            id="btn-employee-{{ $visitor->getID() }}"
                            onclick="handleCategoryClick({{ $visitor->getID() }}, '{{ \App\Models\Visitor::CATEGORY_EMPLOYEE }}')">
                            Сотрудник
                        </button>
                        <button
                            class="btn {{ $visitor->getCategory() === \App\Models\Visitor::CATEGORY_PRESS ? 'btn-press' : '' }}"
                            id="btn-press-{{ $visitor->getID() }}"
                            onclick="handleCategoryClick({{ $visitor->getID() }}, '{{ \App\Models\Visitor::CATEGORY_PRESS }}')">
                            СМИ
                        </button>
                        <button
                            class="btn {{ $visitor->getCategory() === \App\Models\Visitor::CATEGORY_VIP ? 'btn-vip' : '' }}"
                            id="btn-vip-{{ $visitor->getID() }}"
                            onclick="handleCategoryClick({{ $visitor->getID() }}, '{{ \App\Models\Visitor::CATEGORY_VIP }}')">
                            VIP
                        </button>
                        <button
                            class="btn {{ $visitor->getCategory() === \App\Models\Visitor::CATEGORY_GUEST ? 'btn-guest' : '' }}"
                            id="btn-guest-{{ $visitor->getID() }}"
                            onclick="handleCategoryClick({{ $visitor->getID() }}, '{{ \App\Models\Visitor::CATEGORY_GUEST }}')">
                            Гость
                        </button>
                    </td>
                    <td>
                        <button
                            class="btn {{ $visitor->isRejected() ? 'btn-rejected' : '' }}"
                            id="btn-rejected-{{ $visitor->getID() }}"
                            onclick="handleRejectionClick({{ $visitor->getID() }}, {{ $visitor->isRejected() ? 0 : 1 }})">
                            Отказ
                        </button>
                    </td>
                    <td>{{ $visitor->getTelegram() }}</td>
                    <td>{{ $visitor->getEmail() }}</td>
                    <td>{{ $visitor->getCode() }}</td>
                </tr>
            @endforeach
        @elseif($query)
            {{ $query }} - не найдено!
        @else
            <tr>
                <td>Нет посетителей</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
</body>
</html>
