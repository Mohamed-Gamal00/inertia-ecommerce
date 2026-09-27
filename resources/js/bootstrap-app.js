/**
 * Bootstrap Framework Initialization
 *
 * This file initializes Bootstrap 5 and Bootstrap Icons
 * for use throughout the application.
 */

// Import Custom Bootstrap SCSS (includes all Bootstrap with our customizations)
import '../scss/custom-bootstrap.scss';

// Import Bootstrap Icons
import 'bootstrap-icons/font/bootstrap-icons.css';

// Import Bootstrap JavaScript (includes Popper.js)
import * as bootstrap from 'bootstrap';

// Make Bootstrap available globally (for components that need direct access)
window.bootstrap = bootstrap;

// Log successful initialization (dev only)
if (import.meta.env.DEV) {
    console.log('✓ Bootstrap 5 initialized with custom theme');
    console.log('✓ Bootstrap Icons loaded');
}
