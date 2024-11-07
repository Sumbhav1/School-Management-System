# School Management System

## Description
A PHP-based CRUD application designed to manage a school system with user roles for students, teachers, and administrators. The system allows for secure authentication, role-based access control, and dynamic data management. It includes a login system, role-based dashboards, and CRUD operations for managing school data.

## Features
- User role management for **students**, **teachers**, and **administrators**.
- **CRUD operations** for managing school data.
- **Session-based authentication** with role-based access control.
- **Secure password storage** using a custom hashing algorithm.
- Frontend built with **HTML**, **CSS**, and **Bootstrap** for responsive design.
- **AJAX-based API** for seamless data handling and asynchronous interactions.

## Installation Instructions

1. Clone the Repositor:
   Clone this repository to your local machine using the following command:
   ```bash
   git clone https://github.com/yourusername/school-management-system.git
2. Set Up the Database:

  Open phpMyAdmin (or any MySQL client).
  Create a new database, e.g., school_management.
  Import the provided SQL file (database.sql) to set up the necessary tables.
  
3. Configure Database Connection:

  In the project directory, navigate to config.php and update the following with your MySQL database credentials:
  php
  Copy code
  define('DB_HOST', 'localhost');
  define('DB_USER', 'your_db_username');
  define('DB_PASS', 'your_db_password');
  define('DB_NAME', 'school_management');
3. Set Up the Project:

  Ensure your PHP server is running (e.g I used XAMPP).
  Place the project files inside the root directory of your server (e.g., htdocs in XAMPP).
  Run the Project:
  
  Open a web browser and go to http://localhost/school-management-system (or wherever your server is set up).
  Access the login page to register or log in as a user (admin, teacher, or student).
