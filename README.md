# ZAI - A Modern E-commerce Platform

**ZAI** is a feature-rich, custom-built e-commerce platform developed with PHP. It provides a complete solution for online businesses, from product showcases to a fully functional checkout process. The platform is designed with a clean and modular architecture, making it easy to manage, customize, and scale. It also features a deep integration with the Dolibarr ERP system for seamless business management.

## Overview

This project is a web-based application that allows users to browse products, add them to a cart, and complete purchases. It includes user account management, order tracking, and a support ticket system. The backend is built on a custom MVC (Model-View-Controller) framework in pure PHP, ensuring a lightweight and understandable codebase.

## Features

The platform comes with a wide range of features designed to provide a comprehensive e-commerce experience:

*   **User Management:**
    *   Secure user registration and login.
    *   Password reset functionality.
    *   User profile management, including updating personal information and managing addresses.
*   **Product Catalog:**
    *   Browse products by category.
    *   Detailed product view with images and descriptions.
    *   Powerful product search functionality.
*   **Shopping Cart:**
    *   Add, update, and remove products from the cart.
    *   Persistent cart for logged-in users.
*   **Checkout & Orders:**
    *   Seamless checkout process.
    *   Order confirmation and success pages.
    *   Users can view their order history and the status of each order.
*   **Support System:**
    *   Users can create and submit support tickets.
    *   View and manage existing tickets.
*   **Dolibarr ERP Integration:**
    *   Synchronization of products, customers, and orders.
    *   Leverages Dolibarr for backend business process management.

## Tech Stack

*   **Backend:** PHP (procedural and OOP)
*   **Frontend:** HTML5, CSS3, JavaScript (with AJAX for dynamic interactions)
*   **Database:** MySQL
*   **ERP Integration:** Dolibarr REST API and direct database connection.
*   **Web Server:** Apache (or any server that supports PHP and `.htaccess` for routing)

## Project Structure

The project follows a Model-View-Controller (MVC) architecture to separate concerns and improve maintainability.

```
├── app/
│   ├── config/       # Configuration files for database, routes, and environment.
│   ├── controllers/  # Contains the business logic and orchestrates data flow.
│   ├── helpers/      # Helper functions and error handlers.
│   ├── middleware/   # Middleware for handling requests (e.g., authentication).
│   ├── models/       # Represents the data structure and interacts with the database.
│   ├── services/     # Business services, like the Dolibarr service.
│   ├── utils/        # Utility classes, e.g., for Dolibarr integration.
│   └── views/        # The presentation layer (HTML templates).
├── public/           # The web server's document root. Contains all public assets.
│   ├── css/          # Stylesheets.
│   ├── js/           # JavaScript files.
│   └── img/          # Images.
├── setup/            # Scripts for database setup and migrations.
├── uploads/          # Directory for user-uploaded files (e.g., ticket attachments).
├── cache/            # Caching directory for performance optimization.
├── .htaccess         # Apache configuration for URL rewriting.
└── index.php         # The single entry point for the application.
```

## Configuration

The application's configuration is managed through an `.env` file and fallback constants in `app/config/config.php`.

1.  **Create a `.env` file:** In the root of the `app/config/` directory, create an `env.php` file or use a `.env` loader. The `app/config/env.php` seems to be the place to define environment variables.
2.  **Set Environment Variables:** Define the following variables:
    *   `APP_ENV`: Set to `development` or `production`.
    *   `BASE_URL`: The base URL of your application (e.g., `http://localhost/zai/`).
    *   **Dolibarr API:**
        *   `DOLIBARR_API_URL`: URL for the Dolibarr API.
        *   `DOLIBARR_API_KEY`: Your Dolibarr API key.
        *   `DOLIBARR_USERNAME`: Dolibarr username.
        *   `DOLIBARR_PASSWORD`: Dolibarr password.
    *   **Dolibarr Database (for direct connection):**
        *   `DB_HOST`: Database host.
        *   `DB_NAME`: Database name.
        *   `DB_USER`: Database user.
        *   `DB_PASSWORD`: Database password.
        *   `DB_PORT`: Database port.
    *   **Local Database (if different):** The application seems to use a local database as well. Configure its credentials in `app/config/database.php`.

## Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository-url> c:\xampp\htdocs\zai
    ```
2.  **Web Server Configuration:**
    *   Point your Apache server's document root to the `c:\xampp\htdocs\zai\public` directory.
    *   Make sure `mod_rewrite` is enabled in Apache.
3.  **Database Setup:**
    *   Create a MySQL database for the e-commerce platform.
    *   Update the database credentials in `app/config/database.php`.
    *   Execute the scripts in the `setup/` directory to create the tables and perform initial data migrations. You can run them via the command line:
        ```bash
        php c:\xampp\htdocs\zai\setup\create_tables.php
        php c:\xampp\htdocs\zai\setup\migrate_users.php
        ```
4.  **Configure Environment:**
    *   Set up your environment variables as described in the **Configuration** section.
5.  **Permissions:**
    *   Ensure the `cache/` and `uploads/` directories are writable by the web server.

## Available Routes

Here is a list of the main routes available in the application:

| Method | Path                      | Controller         | Action        | Description                               |
|--------|---------------------------|--------------------|---------------|-------------------------------------------|
| GET    | /                         | `HomeController`   | `index`       | Displays the home page.                   |
| GET/POST| /auth/login               | `AuthController`   | `login`       | Handles user login.                       |
| GET/POST| /auth/register            | `AuthController`   | `register`    | Handles user registration.                |
| GET    | /auth/logout              | `AuthController`   | `logout`      | Logs the user out.                        |
| GET    | /products                 | `ProductController`| `index`       | Lists all products.                       |
| GET    | /product/view/{id}        | `ProductController`| `view`        | Shows details for a single product.       |
| GET    | /user/profile             | `UserController`   | `profile`     | Displays the user's profile.              |
| POST   | /user/update              | `UserController`   | `update`      | Updates user profile information.         |
| GET    | /user/orders              | `UserController`   | `orders`      | Lists the user's past orders.             |
| GET    | /cart                     | `CartController`   | `index`       | Displays the shopping cart.               |
| POST   | /cart/add                 | `CartController`   | `add`         | Adds a product to the cart.               |
| GET    | /checkout                 | `CheckoutController`| `index`       | Starts the checkout process.              |
| POST   | /checkout/process         | `CheckoutController`| `process`     | Processes the order.                      |
| GET    | /checkout/success/{id}    | `CheckoutController`| `success`     | Shows the order success page.             |
| GET    | /category/view/{id}       | `CategoryController`| `view`        | Displays products in a specific category. |
| GET    | /tickets                  | `TicketController` | `index`       | Lists user's support tickets.             |
| POST   | /ticket/submit            | `TicketController` | `submit`      | Submits a new support ticket.             |

## Dolibarr Integration

The integration with Dolibarr is a core part of this platform, handling backend operations.

*   **`DolibarrService.php`**: Provides high-level methods for interacting with Dolibarr (e.g., fetching products, creating orders).
*   **`DolibarrIntegration.php`**: Manages the low-level details of the Dolibarr API and direct database connections.
*   **`DolibarrController.php`**: Handles webhook callbacks or direct requests related to Dolibarr.

This integration is responsible for:
*   Syncing product stock and information.
*   Creating customers (third parties) in Dolibarr when a new user registers.
*   Pushing new orders from the website into Dolibarr.

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/YourFeature`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Add some feature'`).
5.  Push to the branch (`git push origin feature/YourFeature`).
6.  Open a Pull Request.

## License

This project is licensed under the [MIT License](LICENSE).
