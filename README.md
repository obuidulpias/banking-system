::::::::::RUN PROJECT:::::::::::

First Clone the Git Repository:
git clone <repository-url>

Install Composer Dependencies:
composer install

Create a .env File:
.env.example .env

Generate an Application Key:
php artisan key:generate

Set the database name : coding-test
Migrate the Database:
php artisan migrate

Start the Development Server:
php artisan serve
This will start a local development server, and you can access your Laravel project by opening a web browser and going to http://localhost:8000



