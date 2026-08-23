PHP MVC CMS

A full-stack content management system built with PHP, MySQL and a custom MVC architecture.

This project began as a legacy procedural PHP CMS and has been progressively refactored into a more structured, maintainable application using object-oriented PHP, PDO, Composer and a custom MVC architecture.

Technologies
PHP
MySQL
PDO
HTML5
CSS3
JavaScript
Composer
MVC
Object-Oriented Programming
Features
Custom MVC architecture
Object-oriented PHP
MySQL database integration using PDO
CRUD functionality
User authentication
Session management
Password hashing
Form validation
Database abstraction
Composer dependency management
Responsive frontend
Reusable application components
Screenshots

<img width="1107" height="788" alt="cms-admin-posts" src="https://github.com/user-attachments/assets/539e1ab3-e8df-4f4f-b962-5ce13210e17f" />
<img width="920" height="804" alt="cms-admin" src="https://github.com/user-attachments/assets/66e0e07b-034e-460c-9c14-68ea1612309d" />
<img width="1186" height="880" alt="cms-user-dashboard" src="https://github.com/user-attachments/assets/b0319739-d794-4db5-9673-a342910d9164" />
<img width="851" height="757" alt="cms-home" src="https://github.com/user-attachments/assets/4f5f423e-3830-4832-939f-ac487062c9ef" />

Architecture

This project uses a custom MVC architecture with separate layers for controllers, models, views, services and repositories.

The structure is designed to separate presentation, application logic and data access, making the application easier to maintain, test and extend.

php-mvc-cms/
├── app/
│   ├── controllers/     # Handles HTTP requests and application flow
│   ├── models/          # Application data and domain models
│   ├── Views/           # Presentation layer
│   ├── Services/        # Application and business logic
│   ├── Repositories/    # Data access and database operations
│   └── core/            # Core application functionality
│
├── bootstrap/           # Application bootstrapping
├── config/              # Configuration
├── public/              # Public web root and entry point
├── routes/              # Application routes
├── composer.json        # PHP dependencies and autoloading
└── composer.lock        # Locked dependency versions

Security

Security is an important part of the ongoing refactoring process.

Current security-related improvements include:

CSRF protection
Password hashing
Prepared SQL statements using PDO
Input validation
Output escaping
Session management
SQL injection prevention

Additional security improvements will continue to be added as the application develops.

Testing

Testing has been introduced throughout the application to help identify errors and verify application behaviour during the migration.

Testing is an ongoing part of the refactoring process, with additional coverage planned as more of the legacy application is migrated.

Development Journey

This repository began as a way to document what I was learning while studying PHP architecture, software design, and modern development practices.

The original project was a traditional PHP CMS/blog built with procedural code, mysqli, mixed HTML/PHP templates, and tightly coupled business logic. Rather than starting over, I chose to refactor it incrementally, using the existing application as a practical case study.

The goal isn't simply to "rewrite" the application.

It's to understand why modern architecture exists by experiencing the problems it solves.

Original Application

The legacy application includes features commonly found in older PHP projects:

Procedural PHP
mysqli database access
PHP mixed directly with HTML
Global configuration files
Direct SQL queries in page files
Basic CMS functionality
Blog posts
Categories
User authentication
Admin dashboard
File uploads
Contact forms

While functional, the codebase became increasingly difficult to maintain as features were added.

Common issues included:

Repeated SQL logic
Duplicated validation
Large page files with multiple responsibilities
Difficult testing
Tight coupling between UI and business logic
Minimal separation of concerns
Why Migrate?

Rather than abandoning the project, I decided to use it as a long-term refactoring exercise.

This repository documents:

Architectural decisions
Mistakes
Refactoring strategies
Lessons learned
Implementation notes
Comparisons between "old" and "new" approaches

The migration is intentionally incremental.

Instead of rewriting everything at once, individual components are replaced while the application continues to function.

Migration Strategy

The migration follows an incremental approach.

Instead of replacing the entire application, each feature is migrated individually.

Typical workflow:

Understand the existing implementation.
Identify pain points.
Design a cleaner solution.
Refactor into MVC.
Test.
Repeat.

This approach allows continuous learning while keeping the application functional.

Project Goals
Learn MVC architecture through practice
Improve maintainability
Reduce duplicated code
Introduce dependency injection
Improve routing
Separate business logic from presentation
Improve security
Increase testability
Modernize development workflow
Developer Experience

The project uses Composer for dependency management and follows a structured application layout to improve maintainability and development workflow.

Current development practices include:

Composer dependency management
PSR-4 autoloading
Environment-based configuration
Structured application bootstrapping
Centralised routing
Separation of application responsibilities
Code Quality

The refactoring process focuses on improving the overall quality and maintainability of the application through:

Namespaces
Object-Oriented PHP
Separation of concerns
Dependency injection
Reusable components
Service and repository layers
Testable application code
Appropriate design patterns
What I've Learned So Far

Some of the biggest lessons have little to do with syntax.

I've learned that:

Architecture matters more as projects grow.
Small abstractions can remove large amounts of duplicated code.
Good folder structure makes development easier.
Dependency injection improves flexibility.
Business logic should not live inside templates.
Refactoring is a skill that improves with practice.
Perfect architecture isn't the goal — maintainable architecture is.
Current Status

This project is actively evolving.

Some areas are fully migrated, while others remain intentionally untouched so the differences between the legacy and modern implementations can be documented.

The repository reflects the learning process as well as the finished functionality.

The current focus is on completing the remaining migrations, improving security, increasing test coverage and continuing to refine the application's architecture.

Roadmap
 Complete remaining legacy-to-MVC migrations
 Expand automated test coverage
 Improve admin UI components
 Add database migrations and seeders
 Improve production deployment configuration
 Continue security hardening
 Improve project documentation
Philosophy

This project isn't about creating yet another PHP framework.

It's about understanding how modern PHP applications are structured by carefully evolving a real-world legacy codebase.

Every refactor is documented, every mistake is part of the process, and every improvement is an opportunity to learn.

If you're also migrating an older PHP project, I hope these notes save you time — or at least reassure you that refactoring is rarely a straight line.

Installation

Installation and local development instructions will be documented here as the project moves towards a production-ready release.

License

This repository is provided for educational purposes and personal learning. Feel free to explore the code, compare approaches, and adapt ideas for your own projects.
