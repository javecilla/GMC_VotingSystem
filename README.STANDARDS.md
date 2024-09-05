## Standards

### Naming Conventions
Consistent naming conventions help maintain clarity and consistency throughout the codebase.
	- `kebab-case` - Used for all folder and file names (e.g., user-profile.vue).
	- `PascalCase` - Used for class and type names (e.g., UserProfileComponent).
	- `snake_case` - Used for database table and column names (e.g., user_profile).
	- `camelCase` - Used for functions, variables, and Zod schemas (e.g., validateUserInput).


###Folder Structure
The project is organized into distinct folders, each serving a specific purpose:
- `Backend (Laravel)`
	- `Enums` - Enumerations and constants.
	- `Exceptions` - Error handling.
	- `Helpers` - Utility functions.
	- `Http` - Controllers, middleware, and request validation.
	- `Models` - Database models.
	- `Observers` - Event observers.
	- `Providers` - Service providers.
	- `Services` - Business logic.
- `bootstrap` - Application bootstrapping logic.
- `config` - Configuration files.