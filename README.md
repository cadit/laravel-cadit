# Laravel JWT Bolierplate

## JWT 
- Header
- Payload
- Signature

## Installation
```bash
$ composer require tymon/jwt-auth 
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"
$ php artisan jwt:generate
```

## Swagger API Documentation
- localhost:8000/api/documentation

로그인 후에는 헤더에 `Authorization` 와 `Bearer {token}` 을 같이 전송해줍니다.
