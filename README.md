# Tasks API (Laravel)

## Requirements
- PHP 8.1+
- Composer
- MySQL 
- Laravel 10+

## Setup
1. Clone
   `git clone <repo> && cd tasks-api`
2. Install
   `composer install`
3. Copy env and set DB
   `cp .env.example .env` (adjust DB settings)
4. Generate key & migrate
   `php artisan key:generate`
   `php artisan migrate`
5. Install Sanctum (already in composer.json)

6. Run
   `php artisan serve`

## API Endpoints
- POST /api/register
- POST /api/login
- POST /api/logout (protected by sanctum auth middleware)
- GET /api/tasks?per_page (protected by sanctum auth middleware)
- POST /api/tasks (protected by sanctum auth middleware)
- GET /api/tasks/{id} (protected by sanctum auth middleware)
- PUT /api/tasks/{id} (protected by sanctum auth middleware)
- DELETE /api/tasks/{id} (protected by sanctum auth middleware)
- GET /api/tasks/status/{status} (protected by sanctum auth middleware) for checking status

## Notes
- Authentication: Laravel Sanctum token (Bearer).
- Only authenticated user can access their tasks.
- Filtering by `status` and pagination implemented.

## Tests
`php artisan test`

## Approach
I used Laravel Sanctum for token-based API auth, Form Requests for validation, policies, route-model binding, Pagination and status filter are optional but included.
