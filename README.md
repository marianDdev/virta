## Virta

Rest-API implementation for Virta's electric vehicle charging station management system.

- Run git clone https://github.com/marianDdev/virta.git
- Run composer install
- Run cp .env.example .env
- Run php artisan key:generate
- Run php artisan migrate && php artisan db:seed
- [Click here to view the API documentation](https://documenter.getpostman.com/view/13777591/2s93Y6ryoF).
- Replace the base url with your own localhost

This projects uses Laravel Sail package, a light-weight command-line interface for interacting with Laravel's default Docker development environment.
- To start all containers run ./vendor/bin/sail up.
  - [Click here for more details about how to use Laravel Sail](https://laravel.com/docs/10.x/sail).
