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

## Authorization

Create default user in database:
```
php artisan db:seed --class=DatabaseSeeder
```

Go to login page:
```
/login
```

Email: `admin@elestonia.com`

Password: `812e3e7`

## Password-protected routes

Search by name / last name / code
```
/ui/search
```

Get one visitor by code
```
/ui/visitors/{code}
```

Manage all visitors (assign categories or set access)
```
/ui/manage
```

## API endpoints

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

[DELETE] delete one visitor by ID
```
/visitors/{id}
```

[GET] search by name / last name / code
```
/search/{query}
```
