## Golden Minds Colleges Voting System

### Application Structure
  - `Backend (Laravel 10)` 
    The backend is responsible for handling all server-side logic, database interactions, and API endpoints. It follows the Model-View-Controller (MVC) pattern, with a clean separation of concerns thru Object Oriented Programming (OOP)


  - `app` - The core of the backend application.
    - `app/Enums` - Contains predefined constant values for use throughout the application.
    - `app/Exceptions` - Custom exception classes for handling errors.
    - `app/Helpers` - Utility or helper methods that provide reusable code snippets.
    - `app/Http` - Handles all HTTP-related tasks.
      - `app/Http/Controllers` - Contains controllers that handle HTTP requests and return responses.
      - `app/Http/Middleware` - Manages authentication and request filtering.
      - `app/Http/Requests` - Houses request validation logic.
      - `app/Http/Resources` - Data Transfer Objects (DTO) for transforming API responses.
    - `app/Models` - Eloquent models representing database tables.
    - `app/Observers` - Observers for monitoring and reacting to Eloquent model events.
    - `app/Providers` - Service providers that bootstrap the application services.
    - `app/Services` - Contains business logic that is more complex than what's in controllers.
  - `bootstrap` - Manages the initial bootstrapping of the application.
  - `config` - Contains all configuration files for the application.
  - `routes` - Defines backend routes.
    - `routes/api.php` - API endpoint routes.
    - `routes/web.php` - Web application routes.
    - `routes/auth.php` - Authentication routes.


### Router
Routing is a crucial part of both the frontend and backend. It defines how requests are mapped to their corresponding controllers or components.

- `Backend Routes:` 
  - `api.php` - for defining RESTful API endpoints.
  - `web.php` - for defining routes that return views.
  - `auth.php` - For defining authentication-related routes.

# Deployment
The application is configured for continuous deployment using GitHub Actions. On every push to the `main` branch, the application is automatically built and deployed to the production server.

To deploy manually:
	- Push your changes to the main branch.
	- The GitHub Actions workflow will handle the rest.

## Rules

Please read the repo **Standards** here: [README.STANDARDS.md](./README.STANDARDS.md)
