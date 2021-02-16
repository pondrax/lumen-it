# Lumen It


## Setup

- clone this git
- copy .env.example to .env
- run composer install
- run artisan jwt:secret
- run artisan migrate
- run composer start

## Available Routing

- [Register]
```
curl -X POST \
  http://localhost:8000/api/auth/register \
  -H 'cache-control: no-cache' \
  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
  -F username=user \
  -F email=user@mail.com \
  -F password=12345678
```

- [Login]
```
curl -X POST \
  http://localhost:8000/api/auth/login \
  -H 'cache-control: no-cache' \
  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
  -F username=user \
  -F password=12345678
```

Check for more other routes at routes/api.php
