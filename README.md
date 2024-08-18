## Requirements

- Composer
- Docker
- docker-compose
- npm
- Node.js (v20+)

## Build and start

```
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
npm install
npm run build
```

## Stop

```
./vendor/bin/sail down
```

## Endpoints

[GET] all visitors
```
/visitors
```

[GET] one visitor by code
```
/visitors/{code}
```

[POST] create new visitor
```
/visitors
```

[POST] update one visitor by ID
```
/visitors/{id}
```

[DELETE] one visitor by ID
```
/visitors/{id}
```

[GET] search by name / last name / code
```
/search/{query}
```

## Authorization

Create default user in database:
```
php artisan db:seed --class=DatabaseSeeder
```

Login: `admin@elestonia.com`

Password: `812e3e7`
