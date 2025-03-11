# AI Forum

A PHP-based web platform inspired by Quora and Reddit, featuring user posts, login/register, CRUD operations, and admin management. Built with MVC structure, Bootstrap, and MySQL.

## Project Demo Video

Watch my AI Forum project in action! This short video shows how users login, create posts, and how the admin dashboard works:

AI Forum Demo Video : ''' https://youtu.be/abc123](https://drive.google.com/file/d/1vxjWe2lne-OEJDqYkYJygYdvLDhA_op_/view?usp=sharing&t=6

## Features
- **User Features:** Register, login, create/edit/delete posts, view posts.
- **Admin Features:** Manage users and posts via a dashboard.
- **CRUD Operations:** Full control over posts (Create, Read, Update, Delete).
- **Responsive Design:** Styled with Bootstrap for all devices.

## Project Structure

```/AI_Forum_PHP_Project
├── /app
│   ├── /Controllers    # Logic for posts, users, admin
│   ├── /Models         # Data models (Post, User)
│   ├── /Views          # Templates (posts, users, admin)
│   ├── /Core           # Router, Database connection
│   └── /Config         # Configuration files
├── /public             # Public-facing files (index.php, assets)
├── /includes           # Unused helper files
├── .env                # Environment variables (DB creds)
├── composer.json       # PHP dependencies
└── .gitignore          # Ignored files


## Technologies
- **Backend:** PHP (MVC), MySQL
- **Frontend:** Bootstrap, HTML
- **Tools:** Composer, Git

## Database Schema
1. **Posts Table**
   - Fields: `id` (PK), `title`, `content`, `user_id` (FK to Users), `created_at`
2. **Users Table**
   - Fields: `id` (PK), `username` (Unique), `email` (Unique), `password`, `created_at`, `reset_token`, `is_admin`

## Setup Instructions
1. **Clone the repo:**
   ```bash
   git clone <repository-url>
   cd AI_Forum_PHP_Project


2. Install dependencies:
bash
composer install


3. Set up MySQL:
Create a database (e.g., ai_forum).
Import tables using the SQL below.
Update .env with your DB credentials:

DB_HOST=localhost
DB_NAME=ai_forum
DB_USER=root
DB_PASS=your_password


Run locally:
Use XAMPP/WAMP or PHP’s built-in server:
bash

php -S localhost:8000 -t public

Open your browser and visit http://localhost:8000.


Database Setup
sql
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


Sample Queries

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

Usage
Register/login as a user to create and manage posts.
Use admin credentials (set is_admin=1 in DB) to access the dashboard and manage users/posts.

License
MIT License—free to use and modify!


### Sample SQL Queries

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
