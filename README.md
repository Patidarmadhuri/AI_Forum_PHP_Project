# AI Forum PHP Project

A PHP-based web platform inspired by Quora and Reddit, featuring user posts, login/register, CRUD operations, and admin management. Built with MVC structure, Bootstrap, and MySQL.

## Table of Contents
- [Introduction](#introduction)
- [Project Demo Video](#project-demo-video)
- [Features](#features)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Database Schema](#database-schema)
- [Setup Instructions](#setup-instructions)
- [Environment Configuration](#environment-configuration)
- [How to Use](#how-to-use)
- [Authentication and Authorization](#authentication-and-authorization)
- [Error Handling](#error-handling)
- [Database Setup and Queries](#database-setup-and-queries)
- [Contributing](#contributing)
- [License](#license)

## Introduction
The AI Forum PHP Project is a web-based discussion platform designed to allow users to create, view, edit, and delete posts related to artificial intelligence. It also includes an admin dashboard for managing users and posts. The application emphasizes user authentication, role-based access control, and responsive design using Bootstrap.

This project is ideal for beginners learning PHP, MVC architecture, and web development best practices. It demonstrates how to build a secure, scalable, and maintainable web application using modern PHP frameworks and libraries.

## Project Demo Video

Watch my AI Forum project in action! This short video shows how users login, create posts, and how the admin dashboard works:

[AI Forum Demo Video](https://drive.google.com/file/d/1vxjWe2lne-OEJDqYkYJygYdvLDhA_op_/view?usp=sharing&t=6)

## Features

### User Features
- **User Authentication**: Users can register, log in, and log out.
- **Post Management**: Authenticated users can create, view, edit, and delete their own posts.
- **Search Functionality**: Users can search for posts by title or content.
- **Responsive Design**: The UI is mobile-friendly and works seamlessly across devices.

### Admin Features
- **Admin Dashboard**: Admins have access to a dashboard for managing users and posts.
- **User Management**: Admins can create, update, and delete users.
- **Post Management**: Admins can manage all posts, including those created by other users.
- **Role-Based Access Control**: Only admins can access certain features (e.g., deleting other users' posts).

### General Features
- **Session Management**: Secure session handling for user authentication.
- **Error Handling**: Custom error pages for 403 (Forbidden) and 404 (Not Found) errors.
- **Validation**: Server-side validation for form inputs to ensure data integrity.
- **CRUD Operations**: Full control over posts (Create, Read, Update, Delete).

## Project Structure
The project follows the MVC (Model-View-Controller) architecture for better organization and maintainability. Below is the directory structure:

```
AI_Forum_PHP_Project/
├── app/
│   ├── Config/          # Configuration files (e.g., config.php)
│   ├── Controllers/     # Controller classes (e.g., PostController.php, UserController.php)
│   ├── Core/            # Core components (e.g., Router.php, Database connection)
│   ├── Models/          # Model classes for database interactions (e.g., Post.php, User.php)
│   └── Views/           # View templates (e.g., posts/index.tpl, admin/dashboard.tpl)
├── public/              # Publicly accessible files (index.php, assets)
├── includes/            # Unused helper files
├── vendor/              # Composer dependencies
├── .env                 # Environment variables (e.g., BASE_URL, DEBUG_MODE)
├── composer.json        # PHP dependencies
├── .git/                # Git repository metadata
└── README.md            # This file
```

## Technologies Used
- **Backend**: PHP (MVC), MySQL
- **Frontend**: Bootstrap, HTML
- **Tools**: Composer, Git
- **Local Development**: XAMPP/WAMP or PHP's built-in server

## Database Schema
1. **Posts Table**
   - Fields: `id` (PK), `title`, `content`, `user_id` (FK to Users), `created_at`
2. **Users Table**
   - Fields: `id` (PK), `username` (Unique), `email` (Unique), `password`, `created_at`, `reset_token`, `is_admin`

## Setup Instructions

### Prerequisites
- Install XAMPP or any other local server with PHP and MySQL.
- Install Composer for dependency management.

### Steps to Set Up

#### Clone the Repository
```bash
git clone <repository-url>
cd AI_Forum_PHP_Project
```

#### Install Dependencies
```bash
composer install
```

#### Set Up the Database
- Create a new MySQL database named `ai_forum`.
- Import the SQL schema from the [Database Setup](#database-setup-and-queries) section below.
- Update the `.env` file with your database credentials.

#### Configure Environment Variables
- Rename `.env.example` to `.env`.
- Update the `.env` file with your database credentials:
```
BASE_URL=http://localhost/AI_Forum_PHP_Project/public
DEBUG_MODE=true
DB_HOST=localhost
DB_NAME=ai_forum
DB_USER=root
DB_PASS=your_password
```

#### Run the Application
- Start Apache and MySQL in XAMPP/WAMP or use PHP's built-in server:
```bash
php -S localhost:8000 -t public
```
- Open your browser and navigate to:
```
http://localhost:8000
```

## Environment Configuration
The `.env` file contains configuration variables for the application. Below are the key variables:

| Variable | Description | Default Value |
|----------|-------------|---------------|
| BASE_URL | Base URL of the application | http://localhost/AI_Forum_PHP_Project/public |
| DEBUG_MODE | Enable/disable debugging | true |
| DB_HOST | Database host | localhost |
| DB_NAME | Database name | ai_forum |
| DB_USER | Database username | root |
| DB_PASS | Database password | your_password |

## How to Use

### User Registration and Login
- Navigate to `/signup` to create a new account.
- Log in at `/login` using your credentials.
- Once logged in, you can create posts, view posts, and manage your profile.

### Admin Dashboard
- Log in as an admin user (admin credentials should be predefined in the database).
- Access the admin dashboard at `/admin/dashboard`.
- Manage users and posts from the respective sections.

## Authentication and Authorization
- **Authentication**: Users must log in to access protected routes (e.g., creating posts).
- **Authorization**: Only admins can access the admin dashboard and perform administrative tasks.
- **Session Management**: Sessions are used to track logged-in users securely.

## Error Handling
The application provides custom error pages for common HTTP errors:

- **403 Forbidden**: Shown when a user tries to access a restricted resource.
- **404 Not Found**: Shown when a requested page or resource does not exist.
- Error messages are sanitized using `htmlspecialchars()` to prevent XSS attacks.

## Database Setup and Queries

### Database Setup
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reset_token VARCHAR(255),
    is_admin TINYINT DEFAULT 0
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content TEXT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Basic Sample Queries
```sql
-- Insert a new user
INSERT INTO users (username, email, password) 
VALUES ('testuser', 'test@example.com', '$2y$10$hashedpassword');

-- Insert a post
INSERT INTO posts (title, content, user_id) 
VALUES ('My New Post', 'This is a test post!', 1);

-- Fetch all posts with usernames
SELECT p.id, p.title, p.content, u.username, p.created_at 
FROM posts p 
JOIN users u ON p.user_id = u.id;

-- Update a post
UPDATE posts 
SET title = 'Edited Post', content = 'Updated content' 
WHERE id = 1;

-- Delete a post
DELETE FROM posts 
WHERE id = 1;
```

### Advanced Sample Queries
```sql
-- Add an admin user
INSERT INTO users (username, email, password, is_admin) 
VALUES ('admin_user', 'admin@example.com', '$2y$10$hashedpassword', 1);

-- Fetch posts by a specific user
SELECT title, content, created_at 
FROM posts 
WHERE user_id = 4;

-- Count posts per user
SELECT u.username, COUNT(p.id) AS post_count 
FROM users u 
LEFT JOIN posts p ON u.id = p.user_id 
GROUP BY u.id, u.username;

-- Find recent posts
SELECT p.title, p.content, u.username, p.created_at 
FROM posts p 
JOIN users u ON p.user_id = u.id 
ORDER BY p.created_at DESC 
LIMIT 5;

-- Update user to admin
UPDATE users 
SET is_admin = 1 
WHERE id = 2;
```

## Contributing
We welcome contributions to improve the project! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Commit your changes (`git commit -m "Add your feature"`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Open a pull request.

Please ensure your code adheres to the project's coding standards and includes appropriate documentation.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
