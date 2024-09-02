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
./vendor/bin/sail artisan db:seed --class=DatabaseSeeder
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
/search
```

Get one visitor by code
```
/visitor/{code}
```

Manage all visitors (assign categories or set access)
```
/manage
```

## API endpoints

[GET] all visitors
```
/api/v1/visitors
```

[GET] one visitor by code
```
/api/v1/visitor/{code}
```

[POST] create new visitor
```
/api/v1/visitors
```

[POST] update one visitor by ID
```
/api/v1/visitors/{id}
```

[DELETE] delete one visitor by ID
```
/api/v1/visitors/{id}
```

[GET] search by name / last name / code
```
/api/v1/search/{query}
```
