# Task Management System

A RESTful API for user and task management with role-based access control.

## Setup
1. Clone the repository: `git clone <repo-url>`
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure database settings.
4. Run migrations: `php artisan migrate`
5. Start the server: `php artisan serve`
6. Access the frontend at `http://localhost:8000/frontend/index.html`

## Docker
1. Install Docker and Docker Compose.
2. Run: `docker-compose up -d`
3. Access at `http://localhost:8000`

## Testing
Run: `php artisan test --coverage`

## Scheduler
Run: `php artisan schedule:run` or add to cron: `* * * * * php /path/to/artisan schedule:run`

## API Documentation
Access Swagger at: `http://localhost:8000/api/documentation`
