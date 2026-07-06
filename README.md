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

## API Documentation

## Base URL

`/api`

## Standard Response Format

All responses from this API follow a standard JSON structure as defined by the `ApiResponse` trait.

### Success Response

```json
{
    "status": true,
    "message": "Success message",
    "data": {},
    "status_code": 200
}
```

### Error Response

```json
{
    "status": false,
    "message": "Error message",
    "errors": {},
    "status_code": 400
}
```

## Error Handling

The API handles various exceptions and returns the following HTTP status codes and formats based on the `ApiResponse`:

- **401 Unauthorized**: User is not authenticated or provided invalid credentials.
- **403 Forbidden**: User does not have the required permissions (e.g., non-admin accessing admin routes).
- **404 Not Found**: The requested resource could not be found.
- **422 Unprocessable Entity**: Validation errors on the request payload.
- **500 Internal Server Error**: A server-side error occurred.

---

## Authentication Endpoints

### 1. Register User

- **URL**: `/register`
- **Method**: `POST`
- **Description**: Register a new user and return an access token.

**Response (201 Created)**:

```json
{
    "status": true,
    "message": "User registered successfully",
    "data": {
        "user": { ... },
        "access_token": "token_string"
    },
    "status_code": 201
}
```

**Response (422 Unprocessable Entity)**:

```json
{
    "status": false,
    "message": "Validation Error",
    "errors": {
        "email": ["The email has already been taken."]
    },
    "status_code": 422
}
```

### 2. Login User

- **URL**: `/login`
- **Method**: `POST`
- **Description**: Authenticate a user and return an access token.

**Response (200 OK)**:

```json
{
    "status": true,
    "message": "Login successful",
    "data": {
        "user": { ... },
        "access_token": "token_string"
    },
    "status_code": 200
}
```

**Response (401 Unauthorized)**:

```json
{
    "status": false,
    "message": "Email or password are incorrect",
    "errors": null,
    "status_code": 401
}
```

### 3. Logout User

- **URL**: `/logout`
- **Method**: `POST`
- **Auth Required**: Yes (`sanctum`)
- **Description**: Log out the authenticated user by revoking their token.

**Response (200 OK)**:

```json
{
    "status": true,
    "message": "Logout successful",
    "data": null,
    "status_code": 200
}
```

---

## Employee Endpoints

### 1. Get Employee List

- **URL**: `/employees`
- **Method**: `GET`
- **Auth Required**: Yes (`sanctum`)
- **Description**: Retrieve a list of employees with optional filtering, sorting, and pagination.
- **Query Parameters**:
    - `per_page` (int, optional): Number of items per page. Default: 10.
    - `keyword` (string, optional): Search keyword.
    - `sort` (string, optional): Sort direction (`asc` or `desc`). Default: `desc`.
    - `sort_by` (string, optional): Column to sort by. Default: `name`.
    - `status` (string, optional): Filter by employee status.
    - `department` (string, optional): Filter by department.

**Response (200 OK)**:

```json
{
    "status": true,
    "message": "Employee retrieved successfully",
    "data": [ ... ],
    "status_code": 200
}
```

### 2. Get Employee Details

- **URL**: `/employees/{id}`
- **Method**: `GET`
- **Auth Required**: Yes (`sanctum`)
- **Description**: Retrieve details of a specific employee.

**Response (200 OK)**:

```json
{
    "status": true,
    "message": "Employee retrieved successfully",
    "data": { ... },
    "status_code": 200
}
```

**Response (404 Not Found)**:

```json
{
    "status": false,
    "message": "Not Found.",
    "errors": null,
    "status_code": 404
}
```

### 3. Create Employee

- **URL**: `/employees`
- **Method**: `POST`
- **Auth Required**: Yes (`sanctum`, Admin only)
- **Description**: Create a new employee record.

**Response (201 Created)**:

```json
{
    "status": true,
    "message": "Employee created successfully",
    "data": { ... },
    "status_code": 201
}
```

**Response (403 Forbidden)**:

```json
{
    "status": false,
    "message": "You do not have permission to access this resource.",
    "errors": null,
    "status_code": 403
}
```

**Response (422 Unprocessable Entity)**:

```json
{
    "status": false,
    "message": "Validation Error",
    "errors": { ... },
    "status_code": 422
}
```

### 4. Update Employee

- **URL**: `/employees/{id}`
- **Method**: `PUT`
- **Auth Required**: Yes (`sanctum`, Admin only)
- **Description**: Update an existing employee record.

**Response (200 OK)**:

```json
{
    "status": true,
    "message": "Employee updated successfully",
    "data": { ... },
    "status_code": 200
}
```

### 5. Delete Employee

- **URL**: `/employees/{id}`
- **Method**: `DELETE`
- **Auth Required**: Yes (`sanctum`, Admin only)
- **Description**: Delete an employee record.

**Response (200 OK)**:

```json
{
    "status": true,
    "message": "Employee deleted successfully",
    "data": null,
    "status_code": 200
}
```
