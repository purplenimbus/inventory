# Installation

 1. Clone the repo `git clone git@github.com:purplenimbus/inventory.git`
 2. Navigate to the installation folder and install composer dependencies `composer install`
 3. Install npm dependencies `npm install`
 4. Download [this](https://github.com/laravel/laravel/blob/master/.env.example);
 5. Open .env.example in a text editor and Change DB_DATABASE , DB_USERNAME ,DB_PASSWORD to your database credentials
 6. Save as .env and copy it to the root folder of the concussion-api folder
 7. Migrate && Seed your database `php artisan migrate:refresh --seed`
 8. Generate a key `php artisan jwt:secret`
 9. Start the Server `php artisan serve`

# Running Tests

run tests  with `./vendor/bin/phpunit`
