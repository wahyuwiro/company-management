# Company Management System

A Laravel-based Company Management System using Inertia.js, Vue 3, Laravel Breeze, and Tailwind CSS with Ant Design Vue for UI components.

## Features

- Manage companies and employees
- Upload and display company logos
- Edit company and employee details in modals
- Pagination and validation

## Prerequisites

Ensure you have the following installed:

- PHP 8.1+
- Composer
- Node.js & npm
- MySQL (or another supported database)
- Laravel 10+

## Installation

### 1. Clone the Repository
```
git clone https://github.com/wahyuwiro/company-management.git
cd company-management
```

### 2. Install Dependencies
```
composer install
npm install
```

### 3. Set Up Environment

Copy the example environment file and update database credentials:
```
cp .env.example .env
```

Edit ```.env``` and set your database configuration and mail setting:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Your App Name"
```

### 4. Run Migrations & Seed Database
```
php artisan migrate --seed
php artisan db:seed --class=UserSeeder

```

### 5. Build Frontend Assets
```
npm run dev
```
For production, use:
```
npm run build
```

### 6. Serve the Application
his will start the Laravel development server at http://127.0.0.1:8000

## Usage
### Running Vite for Hot Reloading
```
npm run dev
```

### Running the Laravel Development Server
```
php artisan serve
```

## Demo
To see a demonstration of the application running locally, check the following link:
[https://youtu.be/UMJZZFNpejo](https://youtu.be/KrNEjarpfmo)
