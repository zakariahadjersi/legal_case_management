# Legal Case Management System

This is a legal case management system designed to help manage and track legal cases. Follow the steps below to get started:

## Installation

1. Run `composer install` on your command prompt or terminal to install the necessary dependencies.

2. Copy the `.env.example` file to `.env` in the root folder. Use the appropriate command based on your operating system:
   - Windows (Command Prompt): `copy .env.example .env`
   - Ubuntu (Terminal): `cp .env.example .env`

3. Open the `.env` file and make the following changes to the database configuration:
   - `DB_DATABASE`: Set it to your desired database name.
   - `DB_USERNAME`: Set it to your database username.
   - `DB_PASSWORD`: Set it to your database password.

4. Run `php artisan key:generate` to generate a unique application key.

5. Run `php artisan migrate` to run the database migrations and create the required tables.

6. Run `php artisan db:seed` to seed the database with initial data.

7. Finally, run `php artisan serve` to start the application.

Now you should be able to access the Legal Case Management System by opening a web browser and navigating to the provided URL.



## License

The Legal Case Management System is free to use.

