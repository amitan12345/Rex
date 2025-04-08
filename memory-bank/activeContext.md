# Active Context: Rex

## Current Work Focus

The Rex project is currently in its initial setup phase. The basic Laravel project structure has been established, but the clean architecture layers need to be implemented according to the project guidelines.

### Current Priorities
1. Implement the clean architecture directory structure
2. Define core domain models for the recruitment system
3. Set up Docker containers for development
4. Establish testing patterns and examples

## Recent Changes

The project has been initialized with Laravel 12.0, and the basic directory structure is in place. The memory bank has been created to document the project's architecture, context, and progress.

## Next Steps

### Immediate Tasks
1. Create the clean architecture directory structure in the app folder
2. Define initial domain models for job postings and candidates
3. Implement repository interfaces for these domain models
4. Create Docker configuration files
5. Set up initial test examples for each layer

### Upcoming Work
1. Implement basic CRUD operations for job postings
2. Create the candidate application workflow
3. Develop the interview scheduling system
4. Implement user roles and permissions
5. Create reporting and analytics features

## Active Decisions and Considerations

### Architecture Decisions
- **Clean Architecture Implementation**: Following the structure defined in the project guidelines
- **Layer Separation**: Strict adherence to dependency rules between layers
- **Repository Pattern**: Used for data access across the application
- **Use Case Pattern**: Encapsulating business operations

### Technical Decisions
- **Docker-based Development**: Using Docker for consistent development environments
- **Testing Strategy**: Unit tests for business logic, feature tests for integration points
- **Static Analysis**: PHPStan Level 9 for strict type checking
- **Code Style**: PHP_CodeSniffer for consistent code formatting

## Important Patterns and Preferences

### Coding Patterns
- **Value Objects**: Immutable objects for representing concepts without identity
- **Entities**: Objects with identity and lifecycle
- **Aggregations**: Clusters of domain objects treated as a unit
- **Use Cases**: Single-responsibility classes for business operations
- **Repositories**: Collection-like interfaces for data access

### Naming Conventions
- **Classes**: PascalCase, descriptive names
- **Methods**: camelCase, verb phrases
- **Variables**: camelCase, noun phrases
- **Interfaces**: PascalCase, prefixed with 'I' or suffixed with 'Interface'
- **Tests**: PascalCase, suffixed with 'Test'

### File Organization
- **Domain Layer**: Core business logic and entities
- **Application Layer**: Use cases and application services
- **Infrastructure Layer**: External systems and data access
- **Presentation Layer**: Controllers and API endpoints
- **Framework Layer**: Framework-specific components

## Learnings and Project Insights

### Key Insights
- Clean architecture provides clear separation of concerns
- Domain-driven design helps model complex business processes
- Repository pattern abstracts data access from business logic
- Use case pattern encapsulates business operations

### Challenges
- Maintaining strict layer separation requires discipline
- Balancing flexibility and complexity in domain modeling
- Ensuring comprehensive test coverage across all layers
- Managing dependencies between components

### Best Practices
- Write tests before implementing features
- Use value objects for immutable concepts
- Keep domain logic independent of frameworks
- Use dependency injection for loose coupling
- Document architectural decisions and patterns
