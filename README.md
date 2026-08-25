# Stage Three MVC CMS

A custom PHP MVC Content Management System built as a hands-on backend development and portfolio project.

The project demonstrates structured backend architecture using controllers, services, repositories, dependency injection, PDO, authentication, authorization, CSRF protection, email verification, and environment-based configuration.

It also provided practical experience with **production debugging, Linux server administration, mail delivery, security, application logging, and deployment troubleshooting**.

<img width="1107" height="788" alt="cms-admin-posts" src="https://github.com/user-attachments/assets/539e1ab3-e8df-4f4f-b962-5ce13210e17f" />
<img width="920" height="804" alt="cms-admin" src="https://github.com/user-attachments/assets/66e0e07b-034e-460c-9c14-68ea1612309d" />
<img width="1186" height="880" alt="cms-user-dashboard" src="https://github.com/user-attachments/assets/b0319739-d794-4db5-9673-a342910d9164" />
<img width="851" height="757" alt="cms-home" src="https://github.com/user-attachments/assets/4f5f423e-3830-4832-939f-ac487062c9ef" />

---

# Project Overview

Stage Three MVC CMS is a custom-built PHP application following an MVC-style, layered architecture.

The application includes:

* User registration and authentication
* Email address verification
* Password hashing and validation
* Session management
* Role-based access control
* User, Admin, and Super Admin roles
* User management
* Content management
* Blog functionality
* Comments
* Media/image management
* Contact form email delivery
* Password reset functionality
* CSRF protection
* Database repositories
* Service-based business logic
* Dependency injection
* Environment-based configuration
* Production error troubleshooting
* Server-side email submission and delivery troubleshooting

The goal was to move beyond simple PHP scripting and develop an understanding of how a structured backend application is designed, secured, configured, debugged, and deployed.

---

# Technology Stack

## Backend

* PHP 8.3+
* Object-Oriented PHP
* MySQL / MariaDB
* PDO
* PHP Sessions
* PHP `mail()`

## Architecture

* MVC-style architecture
* Controllers
* Services
* Repositories
* Models
* Dependency Injection
* Core application classes
* Views
* Application bootstrap

## Server / Development

* Linux
* Git / GitHub
* Command-line debugging
* PHP configuration
* Environment-based configuration
* Server-side logging
* Mail transport troubleshooting

---

# Application Architecture

The application separates responsibilities between controllers, services, repositories, models, and views.

```text
HTTP Request
     |
     v
 Controller
     |
     v
  Service
     |
     v
Repository
     |
     v
 Database
