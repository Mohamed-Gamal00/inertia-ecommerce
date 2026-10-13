# Project Overview

## Business Purpose

This is a **full-featured e-commerce platform** designed to facilitate online retail operations with comprehensive product management, order processing, and customer management capabilities. The platform serves both Arabic and English-speaking markets with full bilingual support.

## Business Objectives

The platform aims to:

1. **Enable Online Sales**: Provide a complete online shopping experience for customers
2. **Multi-Channel Access**: Support both web-based shopping (Inertia.js SPA) and mobile/external integrations (REST API)
3. **Guest Shopping**: Allow purchases without mandatory user registration
4. **Business Operations**: Provide bulk ordering and representative (reseller) ordering capabilities
5. **Administrative Control**: Full-featured admin dashboard for catalog, order, and customer management
6. **Payment Processing**: Integrated payment gateway (Moyasar) for online card payments
7. **Inventory Management**: Track product quantities, availability, and automatic stock updates

## Technology Stack

### Backend Framework
- **Laravel**: 10.x
- **PHP**: 8.1+
- **Authentication**: Laravel Sanctum 3.2
- **Development Tools**: Laravel Telescope 5.19

### Frontend Technologies
- **Vue.js**: 3.5.22
- **Inertia.js**: 2.2.0 (Server-side rendering via Vue)
- **UI Framework**: Vuetify 3.10.3
- **Icons**: Material Design Icons (@mdi/font 7.2.96)
- **Internationalization**: vue-i18n 11.1.12
- **Carousel**: Swiper 10.1.0
- **Event Bus**: mitt 3.0.1
- **Routing**: Ziggy 2.6 (Laravel routes in JavaScript)

### Build Tools
- **Vite**: 7.1.7
- **Laravel Vite Plugin**: 2.0.1
- **Vue Plugin**: @vitejs/plugin-vue 6.0.1
- **Vuetify Plugin**: vite-plugin-vuetify 2.1.2

### Database
- **Database System**: MySQL (VERIFIED from .env.example)
- **ORM**: Eloquent
- **Migrations**: Fully structured migration system

### External Services
- **Payment Gateway**: Moyasar (Saudi payment processor)
- **SMS Gateway**: Custom SMS service (identified: moraSms)
- **Translation**: Google Translate PHP (stichoza/google-translate-php 5.1)

### Development & Testing
- **Testing Framework**: PHPUnit 10.0
- **Code Quality**: Laravel Pint 1.0
- **Debugging**: Laravel Telescope, Spatie Ignition 2.0
- **Local Development**: Laravel Sail 1.18

## Project Type

**E-Commerce SaaS Platform** with:
- B2C (Business-to-Consumer) primary focus
- B2B features (bulk orders, representative orders)
- Multi-tenant potential (single installation serving one business)

## Target Market

- **Primary Market**: Saudi Arabia (payment gateway, currency, SMS service)
- **Languages**: Arabic (primary), English (secondary)
- **Payment Methods**: 
  - Online card payment (Moyasar)
  - Cash on delivery

## Key Differentiators

1. **Dual Frontend Architecture**: 
   - Inertia.js SPA for modern web experience
   - REST API for mobile apps or third-party integrations

2. **Guest-Friendly Checkout**: 
   - Complete shopping experience without registration
   - Cookie-based cart management
   - Guest order tracking

3. **Flexible Shipping Options**:
   - Pickup from store
   - Fixed shipping rate
   - Weight-based shipping
   - City-based shipping rates

4. **Comprehensive Product Management**:
   - Multi-level categories
   - Product choices/variants
   - Color variants
   - Multiple images per product
   - Product features/specifications

5. **Multi-Language Content**:
   - Database-level bilingual support
   - Dynamic translation helpers
   - Google Translate API integration

## Deployment Model

- **INFERRED**: Self-hosted deployment (no SaaS multi-tenancy detected)
- **Environment**: Linux/Unix (based on standard Laravel deployment)
- **Web Server**: UNKNOWN (Nginx/Apache not specified in repository)
- **Session Storage**: File-based (default, configurable)
- **Queue System**: Synchronous by default (QUEUE_CONNECTION=sync)

## Development Status

**VERIFIED Evidence**:
- Complete database migrations (2024-2026 timestamps)
- Functional API and web routes
- Payment integration implemented
- Order management system operational
- Multi-guard authentication in place

**INFERRED Maturity**: Production-ready or near-production (based on feature completeness and recent migrations dated 2026)

## Business Model

- **Revenue**: Direct product sales
- **Order Types**: 
  - Standard customer orders
  - Bulk orders (wholesale inquiries)
  - Representative orders (reseller program)
- **Pricing**: Product-based pricing with optional discount codes
