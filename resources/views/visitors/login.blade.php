<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Вход</title>
    @vite(['resources/css/login.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="content">
        <p class="description">Добрый день!<br>Добро пожаловать в систему проверки билетов. Пожалуйста, укажите данные для входа</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-container">
                <label for="email">Логин<span class="required" style="color: #FF2D20">*</span></label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="input-container">
                <label for="password">Пароль<span class="required" style="color: #FF2D20">*</span></label>
                <input type="password" id="password" name="password" required>
                <x-input-error :messages="$errors->get('email')" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <button class="login-button" type="submit">Войти</button>
        </form>
    </div>
</div>
</body>
</html>
