# E-Commerce Platform - Technical Documentation

## Overview

This is a comprehensive technical documentation for a full-stack Laravel e-commerce platform with dual frontend implementations (API + Inertia.js/Vue 3).

## Documentation Structure

This documentation is organized into multiple sections for easier navigation:

### Core Documentation

1. **[Project Overview](01-project-overview.md)** - Business purpose, technology stack, and project context
2. **[Architecture](02-architecture.md)** - System architecture, design patterns, and architectural decisions
3. **[Project Structure](03-project-structure.md)** - Directory organization and file structure
4. **[Business Modules](04-business-modules.md)** - Detailed breakdown of all business features
5. **[API Reference](05-api-reference.md)** - Complete API endpoint documentation
6. **[Database Schema](06-database-schema.md)** - Database structure, tables, and relationships
7. **[Authentication & Authorization](07-authentication-authorization.md)** - Identity and access control
8. **[Business Workflows](08-business-workflows.md)** - End-to-end process flows
9. **[Jobs, Events & Scheduling](09-jobs-events-scheduling.md)** - Asynchronous processing
10. **[External Integrations](10-external-integrations.md)** - Third-party services and APIs
11. **[Configuration Reference](11-configuration-reference.md)** - Environment variables and settings
12. **[Installation & Development](12-installation-development.md)** - Setup and development guide
13. **[Testing Strategy](13-testing-strategy.md)** - Testing approach and coverage
14. **[Security Review](14-security-review.md)** - Security analysis and recommendations
15. **[Performance & Maintainability](15-performance-maintainability.md)** - Code quality and optimization
16. **[Error Handling & Logging](16-error-handling-logging.md)** - Error management strategy
17. **[Deployment & Operations](17-deployment-operations.md)** - Deployment procedures
18. **[Known Limitations](18-known-limitations.md)** - Current limitations and technical debt
19. **[Glossary](19-glossary.md)** - Terms and definitions
20. **[Codebase File Inventory](20-codebase-file-inventory.md)** - File structure reference

### Diagrams

- System Architecture Diagram
- Database ERD
- Key Workflow Sequence Diagrams

## Quick Reference

### Technology Stack
- **Backend**: Laravel 10.x, PHP 8.1+
- **Frontend**: Vue 3 + Inertia.js 2.0, Vuetify 3
- **API Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Build Tools**: Vite

### Key Features
- Multi-channel sales (Web + Mobile API)
- Multi-language support (Arabic/English)
- Guest and authenticated checkout
- Payment gateway integration (Moyasar)
- Product catalog with categories, filters, and search
- Shopping cart and wishlist
- Order management with multiple statuses
- Admin dashboard
- SMS verification

## Navigation Tips

- Start with [Project Overview](01-project-overview.md) for context
- Review [Architecture](02-architecture.md) to understand system design
- Check [API Reference](05-api-reference.md) for endpoint details
- Refer to [Database Schema](06-database-schema.md) for data structure
- Use [Installation Guide](12-installation-development.md) for setup

## Document Version

- **Last Updated**: 2026
- **Laravel Version**: 10.x
- **Documentation Status**: Complete Initial Analysis

## Notes

This documentation is based on source code analysis and represents the actual implementation as of the analysis date. Where information could not be verified from the repository, it is clearly marked as INFERRED, UNKNOWN, or RECOMMENDED.
