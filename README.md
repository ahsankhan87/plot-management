# Plot / Land Management System

## Overview

Plot / Land Management System is a modern office management solution for real estate and property development companies, built with CodeIgniter 4 and TailwindCSS. It provides robust modules for managing plots, booking, projects, customers, expenses, roles, permissions, and document generation.

## Key Features

- **Role & Permission Management**: Fine-grained access control for users and modules.
- **Customer & Company Management**: CRUD operations for customers, companies, and related entities.
- **Projects, Phases, Sectors, Streets**: Hierarchical management of real estate assets.
- **Plots & Booking Applications**: End-to-end plot allocation, Booking application tracking, and status management.
- **Installment Plans & Payments**: Flexible installment scheduling and payment tracking.
- **Expense Tracking & Reporting**: Categorized expense management with visual reports (Chart.js).
- **Audit Logging**: Track all critical actions for compliance and review.
- **Document Generation**: Professional allotment and provisional letters with watermark/logo integration.
- **Database Backup & Restore**: Downloadable backups for data safety.
- **Modern UI**: Responsive, user-friendly interface using TailwindCSS.

## Technologies Used

- CodeIgniter 4 (PHP Framework)
- TailwindCSS (UI Design)
- Chart.js (Reporting)
- MySQL (Database)

## Modules

- Roles & Permissions
- Users & User Roles
- Customers
- Companies
- Projects, Phases, Sectors, Streets
- Plots & Booking Applications
- Installment Plans & Payments
- Expenses & Expense Categories
- Audit Logs
- Document Letters (Allotment, Provisional)

## Setup Instructions

1. Clone the repository:
   ```
   git clone https://github.com/ahsankhan87/plot-management.git
   ```
2. Install dependencies:
   ```
   composer install
   ```
3. Copy `env` to `.env` and configure database and baseURL settings.
4. Set up your web server to point to the `public` folder.
5. Run database migrations and seeders as needed.

## Deployment

- Supports deployment on shared hosting and XAMPP.
- Ensure `public` is the web root.
- Use the built-in backup feature for database safety.

## License

MIT License

## Author

Ahsan Khan

## Support

For issues and feature requests, please open an issue on GitHub.

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
>
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
