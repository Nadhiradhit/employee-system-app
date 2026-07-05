## Employee System App

## ERD 
<img width="850" height="1100" alt="Untitled Diagram drawio" src="https://github.com/user-attachments/assets/c370ae98-4f9e-4c30-a467-d2d3e513a9e2" />

## Tech Stack

- **Language:** PHP (v8.3+)
- **Framework:** Laravel (v13.8+)
- **Frontend:** Node.js, NPM, Vite

## Style Framework

- **Style Framework:** Tailwind CSS (v4)
- **Plugin:** DaisyUI

## Database (Local) use laragon & postgreSQL

- **Host:** localhost
- **Port:** 5432
- **Database:** laravel
- **User:** postgres
- **Password:** [PASSWORD]

## Prerequisites

Make sure you have the following installed on your machine:

- [PHP](https://www.php.net/) (>= 8.3)
- [Composer](https://getcomposer.org/)
- [Node.js and npm](https://nodejs.org/)

## How to Install

Follow these steps to set up the project locally:

1. **Clone the repository** (if you haven't already) and navigate to the project directory:

    ```bash
    git clone <repository-url>
    cd employee-system-app
    ```

2. **Install PHP Dependencies**:

    ```bash
    composer install
    ```

3. **Install Frontend Dependencies**:

    ```bash
    npm install
    ```

4. **Environment Variables**:
   Copy the example environment file and configure it (e.g., database credentials):

    ```bash
    cp .env.example .env
    ```

    _(On Windows Command Prompt, use `copy .env.example .env`)_

5. **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

6. **Run Database Migrations**:
   Make sure your database is created and configured in the `.env` file, then run:
    ```bash
    php artisan migrate
    ```

## How to Run

To run the application locally for development, you need to start both the backend server and the frontend asset compiler.

1. **Start the backend server**:

    ```bash
    php artisan serve
    ```

    _By default, this will run on `http://127.0.0.1:8000`._

2. **Start the frontend compiler**:
   Open a new terminal window/tab and run:
    ```bash
    npm run dev
    ```

## Documentation API
https://web.postman.co/workspace/My-Workspace~78abb84b-1956-4ecb-8531-49655f502409/collection/29163527-190ae6de-0eea-439a-8fe8-f5b5b58bc2c3?action=share&source=copy-link&creator=29163527
