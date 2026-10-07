# PHP MVC CMS

A custom PHP Content Management System built as a hands-on backend development and portfolio project.

The project evolved from simpler procedural PHP into a structured MVC-style application with separate controllers, services, repositories, models, views, dependency injection, authentication, authorization, and database layers.

It demonstrates practical experience building, refactoring, securing, debugging, and deploying a PHP application.

---

## Project Overview

This application is a custom-built CMS for managing users, roles, pages, blog content, comments, media, and site settings.

The main goal of the project was to move beyond simple PHP scripting and develop a better understanding of how a maintainable backend application is structured.

### Key Features

* User registration and authentication
* Email address verification
* Password hashing and validation
* Password reset functionality
* Session management
* 30-minute session idle timeout
* Role-based access control
* User, Admin, and Super Admin roles
* User management
* Page management
* Blog posts and comments
* Comment moderation
* Media/image management
* Contact form email delivery
* CSRF protection
* Database repositories
* Service-based business logic
* Dependency injection
* Environment-based configuration
* Application error handling
* Production debugging and deployment troubleshooting

---

## Architecture

The application uses a layered MVC-style architecture that separates HTTP handling, business logic, database access, and presentation.

```text
HTTP Request
     │
     ▼
   Router
     │
     ▼
 Controller
     │
     ▼
  Service
     │
     ▼
 Repository
     │
     ▼
    PDO
     │
     ▼
MySQL / MariaDB
```

### Core Components

**Router**

Handles incoming GET and POST requests and maps routes to controller actions.

**Controllers**

Handle HTTP requests and coordinate application behaviour without directly containing database logic.

**Services**

Contain application and business logic such as authentication, password management, comments, CSRF handling, and password resets.

**Repositories**

Provide a dedicated database-access layer for users, posts, pages, comments, roles, media, and settings.

**Models**

Represent application entities such as users, posts, pages, comments, images, and roles.

**Views**

Provide the presentation layer for the public website, authentication pages, dashboards, and administration interface.

**Dependency Injection Container**

The application includes a lightweight dependency injection container using PHP Reflection to inspect constructor dependencies and resolve them automatically.

---

## Technical Highlights

### Authentication & Authorization

Authentication is handled through a dedicated `AuthService`.

The application includes:

* Password verification
* Secure password hashing
* Email verification
* Session ID regeneration after login
* Session idle timeout
* Logout and session cleanup
* Role-based authorization
* User, Admin, and Super Admin permissions

Reusable authorization checks include:

```text
requireLogin()
requireAdmin()
requireSuperAdmin()
```

---

### Password Security

Passwords are hashed using PHP's password hashing functionality rather than being stored as plaintext.

Password-related functionality is separated into a dedicated `PasswordService`.

---

### CSRF Protection

The application includes a dedicated `CsrfService` for protecting form submissions against Cross-Site Request Forgery attacks.

---

### Database Layer

Database access is built around PDO.

The application uses:

* Environment-based database configuration
* PDO exception handling
* Associative result fetching
* Native prepared statements
* UTF-8 `utf8mb4` character encoding
* MySQL / MariaDB

Repository classes provide a dedicated layer between application services and the database.

---

### Dependency Injection

The application includes a custom dependency injection container.

The container uses PHP Reflection to inspect constructor dependencies and recursively resolve them.

For example:

```text
AuthService
    │
    ├── UserRepository
    ├── Mailer
    └── PasswordService
```

This keeps dependencies explicit and avoids requiring application classes to construct their own dependencies.

---

## Application Features

### Public Website

* Home page
* Blog
* Individual blog posts
* Comments
* Contact form
* Static/content pages

### Authentication

* Registration
* Login
* Logout
* Email verification
* Password reset
* Password validation
* Session management

### User Dashboard

* Authenticated user dashboard
* User content management

### Administration

* Admin dashboard
* User management
* Role management
* Post management
* Page management
* Comment moderation
* Media management
* Site settings

---

## Technology Stack

### Backend

* PHP 8.3+
* Object-Oriented PHP
* MySQL / MariaDB
* PDO
* PHP Sessions

### Architecture

* MVC-style architecture
* Layered architecture
* Controllers
* Services
* Repositories
* Models
* Views
* Dependency Injection
* PSR-4 autoloading

### Development

* Git
* GitHub
* Composer
* PHP CLI
* Environment-based configuration
* Application logging
* Command-line debugging

---

## Project Structure

```text
app/
├── Controllers/
├── Core/
├── Models/
├── Repositories/
├── Services/
└── Views/

bootstrap/
config/
public/
routes/
screenshots/

.env.example
composer.json
composer.lock
```

The application is organised by responsibility rather than keeping routing, database queries, business logic, and presentation inside the same files.

---

## Development Journey

One of the main goals of this project was learning how to transition from procedural PHP toward a more structured application architecture.

The project evolved through multiple stages of development and refactoring.

This provided practical experience with:

* Refactoring existing PHP code
* Separating application responsibilities
* Introducing controllers and routing
* Moving database operations into repositories
* Moving business logic into services
* Introducing dependency injection
* Implementing authentication and authorization
* Improving application security
* Debugging production issues
* Working with Linux server environments
* Troubleshooting email delivery
* Managing configuration across environments
* Using Git to track incremental development

The Git history reflects this iterative development process rather than a single completed implementation.

---

## Screenshots

### Admin Posts

<img width="1107" height="788" alt="CMS Admin Posts" src="https://github.com/user-attachments/assets/539e1ab3-e8df-4f4f-b962-5ce13210e17f" />

### Admin Dashboard

<img width="920" height="804" alt="CMS Admin Dashboard" src="https://github.com/user-attachments/assets/66e0e07b-034e-460c-9c14-68ea1612309d" />

### User Dashboard

<img width="1186" height="880" alt="CMS User Dashboard" src="https://github.com/user-attachments/assets/b0319739-d794-4db5-9673-a342910d9164" />

### Home Page

<img width="851" height="757" alt="CMS Home Page" src="https://github.com/user-attachments/assets/4f5f423e-3830-4832-939f-ac487062c9ef" />

---

## Running Locally

### Requirements

* PHP 8.3+
* MySQL or MariaDB
* Composer

### Installation

Clone the repository:

```bash
git clone https://github.com/nzwebgeek/php-mvc-cms.git
cd php-mvc-cms
```

Install Composer dependencies:

```bash
composer install
```

Create a local `.env` file based on `.env.example`:

```text
.env.example
```

Configure the application and database values for your local environment.

Create a MySQL/MariaDB database and configure the corresponding credentials in `.env`.

The application expects the required CMS database tables to exist in the configured database.

Start the PHP development server:

```bash
php -S localhost:8000 -t public
```

Then open:

```text
http://localhost:8000
```

> Local database setup may require additional configuration depending on the development environment.

---

## Security Considerations

The project was developed with several common web application security concerns in mind, including:

* Password hashing
* Password verification
* Session ID regeneration
* Session idle timeout
* CSRF protection
* Role-based authorization
* Environment-based configuration
* PDO prepared statements
* Input validation
* Generic authentication error messages

Security and configuration decisions were introduced as the application evolved from a simpler PHP implementation toward a more structured backend system.

---

## What I Learned

This project helped me develop a deeper understanding of backend application development beyond individual PHP scripts.

Key areas of learning included:

* Designing layered PHP applications
* Applying MVC concepts
* Dependency injection
* Repository and service patterns
* Authentication and authorization
* Session management
* Database abstraction with PDO
* Secure password handling
* CSRF protection
* Application configuration
* Debugging production issues
* Linux server administration
* Git-based development and refactoring

It also helped me understand the practical trade-offs involved in introducing structure into an existing application rather than starting with a framework.

---

## Future Improvements

Potential future improvements include:

* Automated testing
* More comprehensive validation
* Improved routing for dynamic parameters
* Expanded API functionality
* Additional security hardening
* Improved deployment automation
* More comprehensive documentation
* Further refactoring as the application grows

---

## Author

**Mike**

Junior Web Developer specialising in PHP, JavaScript, WordPress, and MySQL.

* Portfolio: https://nzwebgeek.co.nz/
* GitHub: https://github.com/nzwebgeek
* LinkedIn: https://www.linkedin.com/in/mike-flannigan-723312227/
