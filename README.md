# Kanye Quotes Laravel Application

This is a simple Laravel application that displays random Kanye West quotes. The application includes authentication, a protected route for fetching quotes, and an API route that can be accessed securely using a token.

## Features

-   A web page that shows a random Kanye West quote.
-   A button to refresh the quote.
-   Authentication with a password for accessing the quote page.
-   An API route to fetch a random Kanye West quote.
-   Token-based security for the API route.
-   Feature and unit tests for the above functionality.

## Prerequisites

-   PHP 8.x
-   Composer
-   Laravel 8.x or higher
-   Node.js (for front-end dependencies like Tailwind CSS)
-   MySQL (or other supported databases for Laravel)

## Installation

### 1. Clone the repository:

```bash
git clone https://github.com/ahmaad-ansari/kanye-quotes.git
cd kanye-quotes
```

### 2. Install dependencies:

```bash
composer install
npm install
```

### 3. Configure your environment:

-   Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

-   Set up your environment variables, including the `APP_KEY`. You can generate the `APP_KEY` by running the following command:

```bash
php artisan key:generate
```

-   Make sure to set a password for the authentication in your `.env` file:

```env
APP_PASSWORD=your_password_here
API_TOKEN=your_api_token_here
```

### 4. Compile front-end assets (Tailwind CSS):

```bash
npm run dev
```

## Usage

### Running the Development Server:

```bash
php artisan serve
```

By default, the app will be available at `http://127.0.0.1:8000`.

### API Route:

-   To fetch a random quote via the API:

```bash
GET /api/quotes
Authorization: Bearer {YOUR_API_TOKEN}
```

### Authentication:

-   To access the quote page, the user must log in by providing the correct password defined in the `.env` file.
-   The password can be changed by updating the `APP_PASSWORD` value in your `.env`.

### Tests

This project uses Laravel Pest for testing.

-   To run the tests, execute:

```bash
php artisan test
```

This will run all unit and feature tests in your application.
