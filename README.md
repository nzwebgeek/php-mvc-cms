# Stage Three MVC CMS

A custom PHP MVC Content Management System built as a hands-on backend development and portfolio project.

The project focuses on building a structured PHP application from the HTTP request layer through controllers, services, repositories, database operations, authentication, email verification, and external services.

It also provided practical experience with **production debugging, Linux server administration, mail delivery, security, and deployment troubleshooting**.

<img width="1107" height="788" alt="cms-admin-posts" src="https://github.com/user-attachments/assets/539e1ab3-e8df-4f4f-b962-5ce13210e17f" />
<img width="920" height="804" alt="cms-admin" src="https://github.com/user-attachments/assets/66e0e07b-034e-460c-9c14-68ea1612309d" />
<img width="1186" height="880" alt="cms-user-dashboard" src="https://github.com/user-attachments/assets/b0319739-d794-4db5-9673-a342910d9164" />
<img width="851" height="757" alt="cms-home" src="https://github.com/user-attachments/assets/4f5f423e-3830-4832-939f-ac487062c9ef" />


## Project Overview

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
* Production error troubleshooting
* Server-side email delivery

The goal was to move beyond simple PHP scripting and develop an understanding of how a structured backend application is designed, secured, debugged, and deployed.

---

# Technology Stack

### Backend

* PHP 8+
* Object-Oriented PHP
* MySQL / MariaDB
* PDO
* PHP Sessions
* PHP `mail()`

### Architecture

* MVC-style architecture
* Controllers
* Services
* Repositories
* Dependency Injection
* Core application classes
* Views

### Server / Development

* Linux
* Git / GitHub
* Command-line debugging
* PHP configuration
* Server-side logging
* Mail transport troubleshooting

---

# Application Architecture

The application separates responsibilities between controllers, services, repositories, and views.

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
```

A simplified project structure:

```text
app/
├── Controllers/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── ContactController.php
│   └── VerifyController.php
│
├── Services/
│   ├── AuthService.php
│   ├── CsrfService.php
│   ├── Mailer.php
│   ├── PasswordService.php
│   └── ServiceResult.php
│
├── Repositories/
│   ├── UserRepository.php
│   ├── AdminRepository.php
│   ├── ImageRepository.php
│   └── ...
│
├── Core/
│   └── Controller.php
│
└── Views/
    ├── auth/
    ├── admin/
    └── ...
```

The purpose of this structure is to keep application logic from becoming concentrated inside controllers or individual PHP files.

---

# Authentication & Authorization

Authentication is handled through dedicated services rather than being implemented directly inside controllers.

Users can:

1. Register
2. Receive a verification email
3. Verify their email address
4. Log in
5. Access protected areas
6. Log out

Passwords are never stored in plain text and are hashed using PHP's password hashing functionality.

```php
$hashedPassword = $this->passwords->hash($password);
```

Email verification is required before a user can authenticate successfully.

```php
if (!$user['email_verified']) {
    return ServiceResult::warning(
        'Please verify your email before logging in.'
    );
}
```

---

# Role-Based Access Control

The application supports multiple levels of access:

* **User**
* **Admin**
* **Super Admin**

Authentication services provide permission checks such as:

```php
$this->auth->requireAdmin();
```

and:

```php
$this->auth->requireSuperAdmin();
```

This allows sensitive functionality to be restricted according to the user's role.

For example:

* Users access normal application functionality
* Admins manage users and content
* Super Admins perform higher-level administrative operations

---

# Security

Security was considered throughout the application rather than being treated as a separate feature.

Implemented security measures include:

* Password hashing
* Password validation
* Email verification
* Cryptographically random verification tokens
* CSRF protection
* Session regeneration
* Role-based authorization
* Protected administrative routes
* Input trimming
* HTML escaping
* Authentication checks
* Restrictions on sensitive administrative actions

CSRF protection is applied to state-changing requests:

```php
$this->csrf->requireValidToken();
```

Forms receive a CSRF token through the CSRF service.

```php
'csrfToken' => $this->csrf->token(),
```

Verification tokens are generated using PHP's cryptographically secure random generator:

```php
$token = bin2hex(random_bytes(32));
```

---

# Dependency Injection

Services are injected into controllers rather than being instantiated repeatedly inside controller methods.

For example:

```php
public function __construct(
    private readonly AuthService $auth,
    private readonly AdminRepository $adminRepository,
    private readonly UserRepository $userRepository,
    private readonly ImageRepository $imageRepository,
    private readonly CsrfService $csrf,
    private readonly PasswordService $passwords,
    private readonly Mailer $mailer
) {
}
```

The application bootstrap creates and configures dependencies before passing them to the required services and controllers.

This improves:

* Maintainability
* Testability
* Separation of concerns
* Configuration management
* Code reuse

---

# Database Repository Pattern

Database access is separated into repository classes.

Instead of placing SQL queries directly inside controllers:

```php
$this->userRepository->createUser(...);
```

The controller coordinates the request while the repository handles database operations.

This separation keeps database logic isolated from application and presentation logic.

---

# User Creation Workflow

The administrative user creation process follows a structured workflow:

```text
Admin submits form
        |
        v
Admin authentication checked
        |
        v
CSRF token checked
        |
        v
Input collected and validated
        |
        v
Password validated
        |
        v
Username and email checked
        |
        v
Role resolved
        |
        v
Verification token generated
        |
        v
Password hashed
        |
        v
User created in database
        |
        v
Verification email sent
        |
        v
User verifies account
```

This provides a more robust workflow than directly inserting a user into the database.

---

# Email Verification

Email verification is implemented through a dedicated `Mailer` service.

When a user is created, a cryptographically random verification token is generated and stored with the user record.

```php
$token = bin2hex(random_bytes(32));
```

The token is then passed to the mailer:

```php
$sent = $this->mailer->sendVerificationEmail(
    $email,
    $username,
    $token
);
```

The email functionality is kept separate from the controllers to improve maintainability and separation of concerns.

---

# Production Debugging Case Study

One of the most valuable parts of the project was troubleshooting email delivery on a production server.

The application reported:

```text
mail() => true
```

However, the email was not initially appearing in Gmail.

This demonstrated an important distinction:

> A successful `mail()` result does not necessarily mean that the email has reached the recipient.

The complete delivery chain was investigated:

```text
Application
     |
     v
Mailer Service
     |
     v
PHP mail()
     |
     v
Sendmail-compatible transport
     |
     v
Exim
     |
     v
Mail Server
     |
     v
Recipient
```

The investigation included:

* Checking whether PHP supported `mail()`
* Inspecting PHP mail configuration
* Identifying the configured sendmail-compatible transport
* Inspecting the server's mail transport
* Testing PHP mail independently
* Adding application-level logging
* Verifying recipients and sender configuration
* Tracing the user creation and verification workflow

Application logging was used to trace the request through individual stages rather than guessing where the problem existed.

The debugging process reinforced an important backend development principle:

**Application-level success and system-level success are not always the same thing.**

---

# Debugging & Production Experience

The project provided practical experience troubleshooting applications on a real Linux server.

Tools and techniques used included:

```text
php -l
php -i
grep
sed
find
ps
application logs
server logs
```

These were used to investigate issues involving:

* PHP configuration
* Mail transport
* Dependency injection
* Controller dependencies
* Service dependencies
* Email delivery
* Verification tokens
* User creation
* Role IDs
* CSRF validation
* Authentication
* Server permissions
* Production configuration
* Application logging

A particularly useful debugging technique was breaking a request into individual stages and determining exactly how far it progressed before failing.

---

# Key Learning Outcomes

This project significantly expanded my understanding of backend development and production troubleshooting.

### PHP & Backend Development

* Object-oriented PHP
* Type declarations
* Classes and interfaces
* Namespaces
* Exceptions
* Sessions
* Password hashing
* Email handling
* Application configuration

### Architecture

* MVC
* Controllers
* Services
* Repositories
* Dependency Injection
* Separation of concerns
* Application bootstrap

### Security

* Authentication
* Authorization
* RBAC
* CSRF protection
* Password security
* Session management
* Email verification
* Input handling

### Database

* PDO
* MySQL / MariaDB
* Repository pattern
* CRUD operations
* User records
* Roles
* Relationships

### Production

* Linux command line
* PHP configuration
* Mail transport
* Server permissions
* Application logging
* Production debugging
* Troubleshooting external services

---

# What I Would Improve Next

The current application provides a strong foundation, but there are several areas I would improve as development continues.

Planned improvements include:

* Replace PHP `mail()` with a dedicated SMTP service
* Add automated tests
* Add unit tests for services
* Add authentication integration tests
* Improve structured application logging
* Improve form validation
* Add stronger rate limiting
* Add login attempt protection
* Improve exception handling
* Add database migrations
* Improve environment-based configuration
* Improve secret management
* Add static analysis
* Add automated code quality checks
* Add CI/CD using GitHub Actions
* Automate deployment

These improvements would move the application further toward production-grade software engineering practices.

---

# Project Status

The following functionality has been successfully tested:

* User creation
* Password hashing
* Role assignment
* Verification token generation
* Verification email generation
* Email delivery
* Account verification
* User login
* Authentication checks
* Admin access control
* Super Admin access control
* CSRF validation
* Media management

A complete test workflow has been successfully demonstrated:

```text
Administrator creates user
        |
        v
User assigned a role
        |
        v
Verification token generated
        |
        v
Verification email sent
        |
        v
User verifies account
        |
        v
User logs in
        |
        v
Authenticated access granted
```

---

# What This Project Demonstrates

The main value of this project is not simply that it implements a CMS.

It demonstrates the ability to work across multiple layers of a backend application:

```text
User Interface
      |
      v
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
```

And, when external services are involved:

```text
Application
      |
      v
Service
      |
      v
External System
      |
      v
Production Environment
```

When problems occurred, the focus was on identifying the failing layer and tracing the system systematically rather than making random code changes.

This project therefore provided practical experience in:

* Backend architecture
* Security
* Authentication
* Authorization
* Database integration
* Dependency management
* Email delivery
* Linux
* Production debugging
* Application logging
* Troubleshooting external services

---

# Portfolio Value

This project was developed as a practical learning and portfolio project rather than simply following a tutorial.

The most valuable development experience came from solving problems where the application appeared to be functioning correctly while the complete system was not.

The email verification issue was a good example.

Although PHP reported:

```text
mail() = true
```

the message was not initially reaching Gmail.

Investigating the issue required tracing the application through PHP configuration, dependency injection, the Mailer service, Linux, the sendmail-compatible transport, Exim, server configuration, and application logging.

That experience reinforced the importance of understanding the complete technology stack and using systematic debugging rather than relying on assumptions.

---

# Future Direction

The long-term goal is to continue evolving the project toward a more production-oriented application by introducing:

* Automated testing
* SMTP email delivery
* CI/CD
* Static analysis
* Automated deployment
* Improved observability
* Stronger validation and rate limiting
* Better configuration and secret management
* Database migrations

---

# Author

Developed as a practical PHP/MVC learning and portfolio project.

The goal of the project is to demonstrate continuous development, problem solving, backend architecture, security awareness, debugging, and the ability to troubleshoot real-world production issues.

---

## GitHub Repository Description

> **Custom PHP MVC CMS demonstrating authentication, RBAC, CSRF protection, email verification, database repositories, dependency injection, and production troubleshooting.**

### Suggested Topics

```text
php
mvc
mysql
mariadb
pdo
authentication
authorization
rbac
csrf
dependency-injection
backend
cms
web-development
linux
email
security
```
