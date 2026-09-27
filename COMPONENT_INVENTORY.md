# Vuetify Component Inventory

## Generated: Step-by-step Migration Tracking

This document tracks all Vuetify components found in the project.

---

## Summary Statistics

- **Total Vue Files Scanned**: 50+
- **Vuetify Components Found**: 25+ unique components
- **Most Used Components**: v-icon, v-btn, v-card, v-container, v-row, v-col
- **Complex Components**: v-app-bar, v-menu, v-form, v-carousel

---

## Component Usage by Type

### Layout Components
- ✅ `v-app` - Used in main layout
- ✅ `v-app-bar` - Header navigation (AppHeader.vue, FixedNav.vue)
- ✅ `v-container` - Grid container (multiple pages)
- ✅ `v-row` - Grid row (all product listings)
- ✅ `v-col` - Grid column (all product listings)
- ✅ `v-footer` - Footer component

### Navigation Components
- ✅ `v-menu` - Dropdown menus (AppHeader.vue)
- ✅ `v-list` - List component (menus)
- ✅ `v-list-item` - List items
- ✅ `v-navigation-drawer` - Sidebar (if used)
- ✅ `v-tabs` - Tab navigation
- ✅ `v-tab` - Individual tabs

### Form Components
- ✅ `v-form` - Form wrapper (BulkOrder, RepresentativeOrder, Auth pages)
- ✅ `v-text-field` - Text input (all forms)
- ✅ `v-textarea` - Multi-line input (contact forms)
- ✅ `v-select` - Dropdown select
- ✅ `v-checkbox` - Checkboxes
- ✅ `v-radio` - Radio buttons
- ✅ `v-switch` - Toggle switches

### Display Components
- ✅ `v-card` - Card component (product cards, forms, pages)
- ✅ `v-card-title` - Card title
- ✅ `v-card-text` - Card content
- ✅ `v-card-actions` - Card action buttons
- ✅ `v-alert` - Alert messages (BulkOrder, RepresentativeOrder)
- ✅ `v-chip` - Chips/tags
- ✅ `v-badge` - Badge component
- ✅ `v-avatar` - Avatar component

### Action Components
- ✅ `v-btn` - Button (used everywhere)
- ✅ `v-icon` - Icons (used extensively)
- ✅ `v-tooltip` - Tooltips

### Data Components
- ✅ `v-carousel` - Image carousel (Home.vue, ProductShow.vue)
- ✅ `v-carousel-item` - Carousel slides
- ✅ `v-pagination` - Pagination
- ✅ `v-data-table` - Data tables (if used in admin)

### Utility Components
- ✅ `v-divider` - Divider lines
- ✅ `v-spacer` - Flexible spacer
- ✅ `v-progress-circular` - Loading spinner
- ✅ `v-progress-linear` - Progress bar
- ✅ `v-dialog` - Modal dialogs
- ✅ `v-overlay` - Overlay

---

## Files Requiring Migration (Alphabetical)

### Authentication Pages
- [ ] `resources/js/Pages/Auth/Login.vue`
- [ ] `resources/js/Pages/Auth/Register.vue`
- [ ] `resources/js/Pages/Auth/ForgotPassword.vue`
- [ ] `resources/js/Pages/Auth/ResetPassword.vue`

### Main Pages
- [ ] `resources/js/Pages/Home.vue` - Homepage with hero carousel
- [ ] `resources/js/Pages/Products/Index.vue` - Product listing
- [ ] `resources/js/Pages/Products/Show.vue` - Product details
- [ ] `resources/js/Pages/Categories/Index.vue` - Category listing
- [ ] `resources/js/Pages/Categories/Show.vue` - Category products
- [ ] `resources/js/Pages/Cart/Index.vue` - Shopping cart
- [ ] `resources/js/Pages/Checkout/Index.vue` - Checkout process

### Profile Pages
- [ ] `resources/js/Pages/Profile/Index.vue` - Profile overview
- [ ] `resources/js/Pages/Account/Index.vue` - Account page

### Additional Pages
- [ ] `resources/js/Pages/Brands/Index.vue` - Brand listing
- [ ] `resources/js/Pages/Brands/Show.vue` - Brand products
- [ ] `resources/js/Pages/Offers/Index.vue` - Offers page
- [ ] `resources/js/Pages/Compare.vue` - Product comparison
- [ ] `resources/js/Pages/ContactUs/Index.vue` - Contact form
- [ ] `resources/js/Pages/BulkOrder/Index.vue` - Bulk order form
- [ ] `resources/js/Pages/RepresentativeOrder/Index.vue` - Representative order
- [ ] `resources/js/Pages/Payment/Show.vue` - Payment page

### Static Pages
- [ ] `resources/js/Pages/StaticPages/Page.vue` - Generic static page
- [ ] `resources/js/Pages/StaticPages/Questions.vue` - FAQ page
- [ ] `resources/js/Pages/StaticPages/ShippingPolicy.vue`
- [ ] `resources/js/Pages/StaticPages/TermsConditions.vue`
- [ ] `resources/js/Pages/StaticPages/PrivacyPolicy.vue`
- [ ] `resources/js/Pages/StaticPages/ExchangesReturns.vue`

### Layout Components
- [ ] `resources/js/layouts/AppLayout.vue` - Main app layout
- [ ] `resources/js/layouts/AppHeader.vue` - Header component
- [ ] `resources/js/layouts/AppFooter.vue` - Footer component
- [ ] `resources/js/layouts/FixedNav.vue` - Fixed navigation

### Reusable Components
- [ ] `resources/js/components/ProductCard.vue` - Product card
- [ ] `resources/js/components/CategoryCard.vue` - Category card
- [ ] `resources/js/components/CartIcon.vue` - Cart icon
- [ ] `resources/js/components/UserMenu.vue` - User menu
- [ ] `resources/js/components/SearchBar.vue` - Search component
- [ ] Other shared components

---

## Icon Usage (MDI)

Most commonly used icons that need Bootstrap Icons replacement:

- `mdi-magnify` → `bi-search`
- `mdi-cart` → `bi-cart`
- `mdi-heart` / `mdi-heart-outline` → `bi-heart` / `bi-heart-fill`
- `mdi-account` → `bi-person`
- `mdi-menu` → `bi-list`
- `mdi-close` → `bi-x`
- `mdi-chevron-down` → `bi-chevron-down`
- `mdi-chevron-left` → `bi-chevron-left`
- `mdi-check` → `bi-check`
- `mdi-shopping-outline` → `bi-shop`
- `mdi-truck-fast-outline` → `bi-truck`
- `mdi-shield-check-outline` → `bi-shield-check`
- `mdi-help-circle-outline` → `bi-question-circle`

---

## Migration Priority

### Phase 1 (High Priority - Core User Flow)
1. AppLayout.vue
2. AppHeader.vue  
3. AppFooter.vue
4. Home.vue
5. Products/Index.vue
6. Products/Show.vue
7. Cart/Index.vue
8. Checkout/Index.vue

### Phase 2 (Medium Priority - User Features)
1. Auth pages (Login, Register, etc.)
2. Profile pages
3. Categories pages
4. Payment page

### Phase 3 (Low Priority - Additional Features)
1. Brands pages
2. Offers page
3. Compare page
4. Static pages
5. Forms (Bulk Order, Representative Order, Contact)

---

## Estimated Complexity

| Component | Complexity | Reason |
|-----------|-----------|--------|
| v-carousel | High | Need alternative (Swiper.js already in project) |
| v-app-bar | Medium | Bootstrap navbar + customization |
| v-menu | Medium | Bootstrap dropdown + popper.js |
| v-form | Low | Standard HTML forms |
| v-text-field | Low | form-control |
| v-btn | Low | .btn classes |
| v-card | Low | .card classes |
| v-row/v-col | Low | .row/.col classes |
| v-icon | Low | Bootstrap Icons |
| v-tabs | Medium | Bootstrap tabs + JS |
| v-dialog | Medium | Bootstrap modal |

---

## Notes

- Swiper.js is already installed (package.json) for carousels
- Material Design Icons (@mdi/font) currently used, will replace with Bootstrap Icons
- Most Vuetify usage is straightforward (cards, buttons, forms)
- Complex interactions (menus, modals, carousels) need careful migration
- Some custom styling may be needed to match current design

---

**Last Updated**: Phase 0 Complete
**Status**: Ready for Phase 1 implementation

