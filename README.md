## Requirements

- nginx
- Composer
- Docker
- docker-compose
- npm
- Node.js (v20+)

## Build and start

```
cp .env.example .env
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
npm install
npm run build
```

## Port forwarding

/etc/nginx/sites-enabled/default:
```
server {
        listen 80 default_server;
        listen [::]:80 default_server;

        root /var/www/html;

        server_name yourdomain.com;

        location / {
                proxy_set_header   X-Forwarded-For $remote_addr;
                proxy_set_header   Host $http_host;
                proxy_pass         "http://127.0.0.1:8080";
        }

        # add when https is ready (if you get mixed content warnings)
        # add_header 'Content-Security-Policy' 'upgrade-insecure-requests';
}
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
