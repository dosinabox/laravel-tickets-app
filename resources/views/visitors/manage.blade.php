<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Одобрение участников</title>
    @vite(['resources/css/manage.css'])
    <script>
        async function sendPostRequest(endpoint, data) {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (response.ok) {
                console.log('Success:', result);
            } else {
                console.error('Error:', result);
            }

            return result;
        }

        function handleCategoryClick(id, category) {
            const endpoint = '/api/v1/visitors/' + id;
            const data = {
                category: category,
            };

            sendPostRequest(endpoint, data);

            const btnEmployee = document.getElementById("btn-employee-" + id);
            const btnPress = document.getElementById("btn-press-" + id);
            const btnVip = document.getElementById("btn-vip-" + id);
            const btnGuest = document.getElementById("btn-guest-" + id);

            btnEmployee.className = "btn";
            btnPress.className = "btn";
            btnVip.className = "btn";
            btnGuest.className = "btn";

            if (category === 'Сотрудник') {
                btnEmployee.className = "btn btn-employee";
            } else if (category === 'СМИ') {
                btnPress.className = "btn btn-press";
            } else if (category === 'VIP') {
                btnVip.className = "btn btn-vip";
            } else if (category === 'Гость') {
                btnGuest.className = "btn btn-guest";
            }
        }

        function handleRejectionClick(id, isRejected) {
            const endpoint = '/api/v1/visitors/' + id;
            const data = {
                isRejected: isRejected,
            };

            sendPostRequest(endpoint, data);

            const elem = document.getElementById("btn-rejected-" + id);

            if (isRejected === 1) {
                elem.className = "btn btn-rejected";
            } else {
                elem.className = "btn";
            }

            elem.onclick = function() {
                handleRejectionClick(id, 1 - isRejected);
            };
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="header">
    <h1>Одобрение участников мероприятия Кокос</h1>
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
    </div>
    <table>
        <thead>
        <tr>
            <th>Дата и время</th>
            <th>Имя и фамилия</th>
            <th>Компания</th>
            <th>Должность</th>
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
                    <td>{{ $visitor->getCompany() }}</td>
                    <td>{{ $visitor->getStatus() }}</td>
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
