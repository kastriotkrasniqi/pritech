# Pritech

[![License](https://img.shields.io/github/license/kastriotkrasniqi/pritech)](LICENSE)
[![Languages](https://img.shields.io/github/languages/top/kastriotkrasniqi/pritech)](https://github.com/kastriotkrasniqi/pritech/search?l=Blade)
[![Last Commit](https://img.shields.io/github/last-commit/kastriotkrasniqi/pritech)](https://github.com/kastriotkrasniqi/pritech/commits/main)

## Overview

**Pritech** is a project management web application built with [Blade](https://laravel.com/docs/10.x/blade), [PHP](https://www.php.net/), and Laravel's [Livewire](https://livewire.laravel.com/). It enables users to create, manage, and track projects and their associated issues in a collaborative environment.

## Features

- **Project Creation & Editing:** Create new projects and edit existing ones, including name, description, start date, deadline, and owner assignment.
- **Project Listing & Search:** View projects in a paginated table with search and sorting capabilities.
- **Issue Tracking:** Projects can have multiple issues, with quick stats and priority badges displayed.
- **Project Details View:** See comprehensive project info, including owner, dates, issue count, and status (e.g., Overdue, Due Soon, On Track).
- **Role-Based Actions:** Only owners can edit or delete their projects, enforced by policies.
- **Responsive UI:** Built with Blade and Livewire, supporting interactive editing and real-time updates.

## Language Composition

- **Blade:** 68.6%
- **PHP:** 30.8%
- **Other:** 0.6%

## Getting Started

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel Framework
- Node.js & npm (optional for frontend tooling)
- A web server (Apache/Nginx)

### Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/kastriotkrasniqi/pritech.git
    cd pritech
    ```

2. **Install PHP dependencies:**
    ```sh
    composer install
    ```

3. **Set up environment variables:**
    ```sh
    cp .env.example .env
    # Edit .env with your settings
    ```

4. **Generate application key:**
    ```sh
    php artisan key:generate
    ```

5. **Run database migrations:**
    ```sh
    php artisan migrate
    ```

6. **Serve the application:**
    ```sh
    php artisan serve
    ```

### Usage

- Access the app at `http://localhost:8000`.
- Create and manage projects, assign owners, and track issues.
- Use the project table for searching, sorting, and quick actions.

## Project Structure

```
├── app/
│   └── Livewire/Projects/       # Livewire components for project CRUD
│   └── Models/                  # Eloquent models (Project, User, Issue)
├── resources/
│   └── views/                   # Blade templates for UI
│       └── livewire/projects/   # Project-related views
│       └── projects/            # Project index/detail views
├── database/
│   └── migrations/              # Table creation scripts
│   └── factories/               # Model factories for testing
├── public/                      # Public assets
├── routes/                      # Web route definitions
└── README.md                    # Project documentation
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

## Acknowledgements

- [Laravel](https://laravel.com/)
- [Livewire](https://livewire.laravel.com/)
- [kastriotkrasniqi](https://github.com/kastriotkrasniqi)

---

_For questions or issues, open an issue on GitHub._
