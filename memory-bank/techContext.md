# Technical Context: Rex

## Technology Stack

### Backend
- **PHP**: Version 8.4.0 or higher
- **Laravel**: Version 12.0.0 or higher
- **MySQL**: Version 8.4 or higher
- **PHPStan**: Version 2.1 or higher (Level 9)
- **PHP_CodeSniffer**: Version 3.12 or higher

### Infrastructure
- **Docker**: Containerization platform
- **Nginx**: Version 1.27.0 or higher (Web server)

### Development Tools
- **Composer**: PHP dependency management
- **Laravel Tinker**: REPL for Laravel
- **Laravel Pail**: Log viewer
- **Laravel Pint**: PHP code style fixer
- **Laravel Sail**: Docker development environment
- **PHPUnit**: Version 11.5.3 or higher (Testing framework)
- **Mockery**: Mocking framework for testing
- **Faker**: Test data generation
- **Collision**: CLI error handling

## Development Environment

### Container Setup
The application runs in a containerized environment with three main services:

1. **PHP Container**:
   - Runs the Laravel application
   - PHP 8.4.0 or higher
   - Composer for dependency management

2. **Nginx Container**:
   - Handles HTTP requests
   - Routes traffic to the PHP container
   - Serves static assets

3. **Database Container**:
   - Runs MySQL 8.4 or higher
   - Persists application data

### Local Development
Development is facilitated through Laravel Sail, which provides a Docker-based development environment:

```bash
# Start the development environment
./vendor/bin/sail up

# Run artisan commands
./vendor/bin/sail artisan migrate

# Run tests
./vendor/bin/sail test
```

Alternatively, the composer script can be used:

```bash
# Start development servers
composer dev
```

This runs:
- Laravel development server
- Queue worker
- Log viewer
- Vite for frontend assets

## Technical Constraints

### Code Quality
- All code must pass PHPStan at Level 9
- All code must conform to PHP_CodeSniffer rules
- All new code must include corresponding tests

### Architecture
- Must follow clean architecture principles
- Must adhere to the defined layer structure
- Each layer can only depend on inner layers, not outer ones

### Testing
- Unit tests for code without external dependencies
- Feature tests for code with external dependencies
- Tests must use mocks for cross-layer dependencies
- Tests must achieve branch coverage

## Dependencies

### Core Dependencies
- **laravel/framework**: The Laravel framework
- **laravel/tinker**: Interactive REPL

### Development Dependencies
- **fakerphp/faker**: Test data generation
- **laravel/pail**: Log viewer
- **laravel/pint**: Code style fixer
- **laravel/sail**: Docker development environment
- **mockery/mockery**: Mocking framework
- **nunomaduro/collision**: CLI error handling
- **phpunit/phpunit**: Testing framework

## Tool Usage Patterns

### Static Analysis
PHPStan is used at Level 9 to ensure type safety and prevent common errors:

```bash
./vendor/bin/phpstan analyse --level=9
```

### Code Style
PHP_CodeSniffer is used to enforce coding standards:

```bash
./vendor/bin/phpcs
```

Laravel Pint can be used to automatically fix style issues:

```bash
./vendor/bin/pint
```

### Testing
PHPUnit is used for testing, with separate suites for unit and feature tests:

```bash
# Run all tests
./vendor/bin/phpunit

# Run only unit tests
./vendor/bin/phpunit --testsuite=Unit

# Run only feature tests
./vendor/bin/phpunit --testsuite=Feature
```

### Database Migrations
Laravel migrations are used for database schema management:

```bash
php artisan migrate
```

### Seeding
Laravel seeders are used to populate the database with test data:

```bash
php artisan db:seed
```
