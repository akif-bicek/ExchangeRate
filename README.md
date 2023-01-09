## Installation

For installation, run the following commands in order. You can find Postman Documentation in 'ExchangeRate.json' file.


```bash
php artisan migrate
```

```bash
php artisan db:seed
```

To log in with Passport, paste your client_secret to the place below after running the relevant command below.
```bash
php artisan passport:install
```
```json
{
    "client_id": 2,
    "client_secret": "your_client_key",
    "grant_type": "password",
    "username": "example@gmail.com",
    "password": "12345678"
}
```

Run the following command locally for scheduled tasks.

```bash
 php artisan schedule:work
```
