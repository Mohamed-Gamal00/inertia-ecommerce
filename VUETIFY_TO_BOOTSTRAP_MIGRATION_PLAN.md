# Vuetify to Bootstrap UI Migration Plan

## Project Overview

**Objective**: Migrate the e-commerce platform frontend from Vuetify 3 (Material Design) to Bootstrap 5 + Vue 3

**Estimated Timeline**: 6-8 weeks

**Team Size**: 1-2 developers

**Risk Level**: Medium-High (Major UI overhaul affecting all customer-facing pages)

---

## Table of Contents

1. [Migration Strategy](#migration-strategy)
2. [Technology Stack Changes](#technology-stack-changes)
3. [Phase 0: Preparation](#phase-0-preparation)
4. [Phase 1: Setup & Configuration](#phase-1-setup--configuration)
5. [Phase 2: Component Library Creation](#phase-2-component-library-creation)
6. [Phase 3: Layout Migration](#phase-3-layout-migration)
7. [Phase 4: Page Migration](#phase-4-page-migration)
8. [Phase 5: Testing & QA](#phase-5-testing--qa)
9. [Phase 6: Cleanup & Optimization](#phase-6-cleanup--optimization)
10. [Rollback Plan](#rollback-plan)
11. [Component Mapping Reference](#component-mapping-reference)

---

## Migration Strategy

### Approach: Gradual Component-by-Component Migration

**Why not "Big Bang" replacement?**
- Too risky for production
- Hard to test incrementally
- No easy rollback

**Our Strategy:**
1. Set up Bootstrap alongside Vuetify (temporary parallel)
2. Create reusable Bootstrap components
3. Migrate pages one-by-one
4. Remove Vuetify when 100% complete

### Success Metrics

- [ ] All Vuetify components replaced
- [ ] No visual regression (compared to screenshots)
- [ ] Performance maintained or improved
- [ ] Mobile responsive on all pages
- [ ] Accessibility maintained (WCAG AA)
- [ ] Bundle size reduced by 30%+

---

## Technology Stack Changes

### Remove
```json
{
  "vuetify": "^3.10.3",
  "vite-plugin-vuetify": "^2.1.2",
  "@mdi/font": "^7.2.96",
  "sass": "^1.93.2" (if only for Vuetify)
}
```

### Add
```json
{
  "bootstrap": "^5.3.0",
  "bootstrap-vue-next": "^0.16.0",  // Bootstrap 5 + Vue 3
  "@popperjs/core": "^2.11.8",      // For tooltips/popovers
  "bootstrap-icons": "^1.11.0"      // Icon replacement
}
```

### Alternative: Use Custom Bootstrap Components
Instead of `bootstrap-vue-next`, you can use Bootstrap CSS + custom Vue components for more control.

---

## Phase 0: Preparation

### Week 0 (3-5 days)

#### 0.1 Project Backup & Branch Setup

- [x] Create full database backup
- [x] Backup current codebase
- [x] Create migration branch: `git checkout -b feature/bootstrap-migration` ✓ (using existing bootstrap-version branch)
- [ ] Document current state (screenshots of all pages)
- [x] Set up local development environment ✓

#### 0.2 Audit Current Components

- [x] List all Vuetify components currently used ✓
- [x] Identify custom Vuetify configurations ✓
- [x] Document all pages that need migration ✓
- [x] Create component inventory spreadsheet ✓

**Deliverable**: `COMPONENT_INVENTORY.md` with complete list ✓ **COMPLETED**

#### 0.3 Take Screenshots

- [ ] Homepage (desktop & mobile)
- [ ] Product listing
- [ ] Product details
- [ ] Cart
- [ ] Checkout flow (all steps)
- [ ] User profile
- [ ] All auth pages (login, register, forgot password)
- [ ] Static pages

**Tool**: Use automated screenshot tool like Percy or manual screenshots

#### 0.4 Stakeholder Alignment

- [ ] Review migration plan with team
- [ ] Get approval for timeline
- [ ] Set up progress tracking (Jira/Trello/GitHub Projects)
- [ ] Schedule weekly check-ins

---

## Phase 1: Setup & Configuration

### Week 1 (5 days) ✅ **COMPLETED**

#### 1.1 Install Bootstrap Dependencies ✅

```bash
npm install bootstrap@5.3.0 @popperjs/core bootstrap-icons
# Optional: Install bootstrap-vue-next if using pre-built components
npm install bootstrap-vue-next
```

- [x] Install Bootstrap packages ✅
- [x] Verify installation with `npm list` ✅
- [x] Check for peer dependency conflicts ✅

#### 1.2 Configure Bootstrap in Project ✅

**File: `resources/js/bootstrap-app.js`** (new file)

- [x] Create Bootstrap initialization file ✅
- [x] Import Bootstrap CSS ✅
- [x] Import Bootstrap JS ✅
- [x] Configure Bootstrap settings ✅

#### 1.3 Update Main App Entry ✅

**File: `resources/js/app.js`**

- [x] Import Bootstrap before Vuetify (parallel mode) ✅
- [x] Comment out Vuetify imports (don't remove yet) ✅
- [x] Test that app still runs ✅

#### 1.4 Update Vite Configuration ✅

**File: `vite.config.js`**

- [x] Ensure Bootstrap CSS is processed ✅
- [x] Configure CSS preprocessing if needed ✅
- [x] Test build process ✅

#### 1.5 Test Parallel Setup ✅

- [x] Run `npm run dev` ✅
- [x] Verify no console errors ✅
- [x] Check that existing Vuetify pages still work ✅
- [x] Verify Bootstrap CSS is loaded (inspect element) ✅

#### 1.6 Create Custom Bootstrap Theme (Optional) ✅

**File: `resources/scss/custom-bootstrap.scss`** (new file)

- [x] Create custom SCSS file ✅
- [x] Override Bootstrap variables to match current design ✅
- [x] Import in app.js ✅

**Status**: ✅ Phase 1 Complete - Bootstrap installed and configured successfully!

---

## Phase 2: Component Library Creation

### Week 2-3 (10 days) - **IN PROGRESS** ⏳

**Goal**: Create reusable Bootstrap components that match Vuetify functionality

#### 2.1 Create Component Directory Structure ✅

- [x] Create directory structure ✅
- [x] Set up index.js for auto-imports (optional)

#### 2.2 Core UI Components - **IN PROGRESS** ⏳

##### BButton.vue ✅
- [x] Create component ✅
- [x] Support variants (primary, secondary, success, danger, etc.) ✅
- [x] Support sizes (sm, md, lg) ✅
- [x] Support disabled state ✅
- [x] Support loading state ✅
- [x] Add icon support ✅

**Checklist**:
- [x] BButton.vue created and tested ✅

##### BCard.vue ✅
- [x] Create component ✅
- [x] Support header/footer slots ✅
- [x] Support image prop ✅
- [x] Support hover effect ✅

**Checklist**:
- [x] BCard.vue created and tested ✅

##### BInput.vue ✅
- [x] Create component ✅
- [x] Support v-model ✅
- [x] Support validation states ✅
- [x] Support help text ✅
- [x] Support prepend/append icons ✅

**Checklist**:
- [x] BInput.vue created and tested ✅

##### BAlert.vue ✅
- [x] Create component ✅
- [x] Support variants ✅
- [x] Support dismissible ✅
- [x] Support icons ✅

##### BModal.vue ✅
- [x] Create component ✅
- [x] Support sizes ✅
- [x] Support centered ✅
- [x] Support backdrop options ✅

##### BSpinner.vue ✅
- [x] Create component ✅
- [x] Support border/grow types ✅
- [x] Support sizes and variants ✅

##### Other Core Components - **TODO** 📋

- [ ] **BSelect.vue** - Dropdown select
- [ ] **BTextarea.vue** - Multi-line input
- [ ] **BCheckbox.vue** - Checkbox input
- [ ] **BRadio.vue** - Radio button
- [ ] **BBadge.vue** - Badge/chip component
- [ ] **BPagination.vue** - Pagination
- [ ] **BTabs.vue** - Tab navigation
- [ ] **BDropdown.vue** - Dropdown menu
- [ ] **BNavbar.vue** - Navigation bar
- [ ] **BTable.vue** - Data table (if needed)

#### 2.3 Register Components Globally (Optional) - TODO

- [ ] Create plugin file
- [ ] Auto-register all Bootstrap components
- [ ] Import in app.js

#### 2.4 Create Composables for Common Logic ✅

- [x] **useToast.js** - Toast notifications ✅
- [ ] **useModal.js** - Modal management
- [ ] **useBreakpoints.js** - Responsive breakpoints

**Status**: ⏳ Phase 2 In Progress - Core components created, form components pending

```bash
resources/js/
├── components/
│   ├── bootstrap/          # ← New folder
│   │   ├── ui/
│   │   │   ├── BButton.vue
│   │   │   ├── BCard.vue
│   │   │   ├── BInput.vue
│   │   │   ├── BSelect.vue
│   │   │   ├── BModal.vue
│   │   │   ├── BAlert.vue
│   │   │   └── ... more
│   │   ├── form/
│   │   │   ├── FormInput.vue
│   │   │   ├── FormTextarea.vue
│   │   │   └── FormSelect.vue
│   │   └── layout/
│   │       ├── Container.vue
│   │       ├── Row.vue
│   │       └── Col.vue
│   └── ... (existing components)
```

- [ ] Create directory structure
- [ ] Set up index.js for auto-imports

#### 2.2 Core UI Components

##### BButton.vue
- [ ] Create component
- [ ] Support variants (primary, secondary, success, danger, etc.)
- [ ] Support sizes (sm, md, lg)
- [ ] Support disabled state
- [ ] Support loading state
- [ ] Add icon support

```vue
<!-- resources/js/components/bootstrap/ui/BButton.vue -->
<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="$emit('click', $event)"
  >
    <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
    <i v-if="icon && !loading" :class="`bi bi-${icon} me-2`"></i>
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: { type: String, default: 'primary' },
  size: { type: String, default: 'md' },
  disabled: Boolean,
  loading: Boolean,
  outline: Boolean,
  block: Boolean,
  icon: String,
  type: { type: String, default: 'button' }
});

const buttonClasses = computed(() => {
  const classes = ['btn'];
  
  if (props.outline) {
    classes.push(`btn-outline-${props.variant}`);
  } else {
    classes.push(`btn-${props.variant}`);
  }
  
  if (props.size !== 'md') {
    classes.push(`btn-${props.size}`);
  }
  
  if (props.block) {
    classes.push('w-100');
  }
  
  return classes.join(' ');
});
</script>
```

**Checklist**:
- [ ] BButton.vue created and tested
- [ ] Storybook entry created (optional)

##### BCard.vue
- [ ] Create component
- [ ] Support header/footer slots
- [ ] Support image prop
- [ ] Support hover effect

```vue
<!-- resources/js/components/bootstrap/ui/BCard.vue -->
<template>
  <div class="card" :class="{ 'shadow-sm': shadow, 'h-100': fullHeight }">
    <img v-if="imgSrc" :src="imgSrc" class="card-img-top" :alt="imgAlt">
    
    <div v-if="$slots.header" class="card-header">
      <slot name="header" />
    </div>
    
    <div class="card-body">
      <h5 v-if="title" class="card-title">{{ title }}</h5>
      <h6 v-if="subtitle" class="card-subtitle mb-2 text-muted">{{ subtitle }}</h6>
      <slot />
    </div>
    
    <div v-if="$slots.footer" class="card-footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  subtitle: String,
  imgSrc: String,
  imgAlt: String,
  shadow: { type: Boolean, default: true },
  fullHeight: Boolean
});
</script>
```

**Checklist**:
- [ ] BCard.vue created and tested

##### BInput.vue (Form Input)
- [ ] Create component
- [ ] Support v-model
- [ ] Support validation states
- [ ] Support help text
- [ ] Support prepend/append icons

```vue
<!-- resources/js/components/bootstrap/ui/BInput.vue -->
<template>
  <div class="mb-3">
    <label v-if="label" :for="id" class="form-label">
      {{ label }}
      <span v-if="required" class="text-danger">*</span>
    </label>
    
    <div v-if="prependIcon || appendIcon" class="input-group">
      <span v-if="prependIcon" class="input-group-text">
        <i :class="`bi bi-${prependIcon}`"></i>
      </span>
      
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :required="required"
        :class="inputClasses"
        @input="$emit('update:modelValue', $event.target.value)"
      >
      
      <span v-if="appendIcon" class="input-group-text">
        <i :class="`bi bi-${appendIcon}`"></i>
      </span>
    </div>
    
    <input
      v-else
      :id="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :required="required"
      :class="inputClasses"
      @input="$emit('update:modelValue', $event.target.value)"
    >
    
    <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
    <div v-else-if="hint" class="form-text">{{ hint }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  label: String,
  type: { type: String, default: 'text' },
  placeholder: String,
  disabled: Boolean,
  required: Boolean,
  error: String,
  hint: String,
  prependIcon: String,
  appendIcon: String,
  id: { type: String, default: () => `input-${Math.random().toString(36).substr(2, 9)}` }
});

defineEmits(['update:modelValue']);

const inputClasses = computed(() => {
  const classes = ['form-control'];
  if (props.error) classes.push('is-invalid');
  return classes.join(' ');
});
</script>
```

**Checklist**:
- [ ] BInput.vue created and tested
- [ ] v-model working correctly
- [ ] Validation states working

##### Other Core Components

- [ ] **BSelect.vue** - Dropdown select
- [ ] **BTextarea.vue** - Multi-line input
- [ ] **BCheckbox.vue** - Checkbox input
- [ ] **BRadio.vue** - Radio button
- [ ] **BModal.vue** - Modal dialog
- [ ] **BAlert.vue** - Alert messages
- [ ] **BSpinner.vue** - Loading spinner
- [ ] **BBadge.vue** - Badge/chip component
- [ ] **BPagination.vue** - Pagination
- [ ] **BTabs.vue** - Tab navigation
- [ ] **BDropdown.vue** - Dropdown menu
- [ ] **BNavbar.vue** - Navigation bar
- [ ] **BTable.vue** - Data table (if needed)

#### 2.3 Register Components Globally (Optional)

**File: `resources/js/plugins/bootstrap-components.js`** (new file)

- [ ] Create plugin file
- [ ] Auto-register all Bootstrap components
- [ ] Import in app.js

```javascript
// resources/js/plugins/bootstrap-components.js
import BButton from '../components/bootstrap/ui/BButton.vue';
import BCard from '../components/bootstrap/ui/BCard.vue';
import BInput from '../components/bootstrap/ui/BInput.vue';
// ... import all components

export default {
  install(app) {
    app.component('BButton', BButton);
    app.component('BCard', BCard);
    app.component('BInput', BInput);
    // ... register all components
  }
};
```

```javascript
// resources/js/app.js
import bootstrapComponents from './plugins/bootstrap-components';

createInertiaApp({
  // ...
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });
    
    app.use(plugin);
    app.use(bootstrapComponents); // ← Register Bootstrap components
    // ... rest of setup
  },
});
```

#### 2.4 Create Composables for Common Logic

- [ ] **useToast.js** - Toast notifications
- [ ] **useModal.js** - Modal management
- [ ] **useBreakpoints.js** - Responsive breakpoints

```javascript
// resources/js/composables/useToast.js
import { ref } from 'vue';

const toasts = ref([]);

export function useToast() {
  const show = (message, variant = 'info', duration = 3000) => {
    const id = Date.now();
    toasts.value.push({ id, message, variant });
    
    setTimeout(() => {
      toasts.value = toasts.value.filter(t => t.id !== id);
    }, duration);
  };

  return {
    toasts,
    showToast: show,
    success: (msg) => show(msg, 'success'),
    error: (msg) => show(msg, 'danger'),
    warning: (msg) => show(msg, 'warning'),
    info: (msg) => show(msg, 'info'),
  };
}
```

---

## Phase 3: Layout Migration

### Week 3-4 (5 days)

#### 3.1 Main App Layout

**File: `resources/js/layouts/AppLayout.vue`**

- [ ] Backup original Vuetify version
- [ ] Create new Bootstrap version
- [ ] Test header navigation
- [ ] Test footer
- [ ] Test mobile responsiveness
- [ ] Test sidebar (if any)

**Before (Vuetify)**:
```vue
<v-app>
  <v-app-bar>...</v-app-bar>
  <v-main>
    <slot />
  </v-main>
  <v-footer>...</v-footer>
</v-app>
```

**After (Bootstrap)**:
```vue
<template>
  <div id="app" class="d-flex flex-column min-vh-100">
    <Navbar />
    
    <main class="flex-grow-1">
      <slot />
    </main>
    
    <Footer />
    
    <ToastContainer />
  </div>
</template>

<script setup>
import Navbar from '../components/layout/Navbar.vue';
import Footer from '../components/layout/Footer.vue';
import ToastContainer from '../components/bootstrap/ui/ToastContainer.vue';
</script>
```

**Checklist**:
- [ ] AppLayout.vue migrated
- [ ] Header/Navbar component created
- [ ] Footer component created
- [ ] Mobile menu working
- [ ] All navigation links working

#### 3.2 Navigation Bar

**File: `resources/js/components/layout/Navbar.vue`**

- [ ] Convert v-app-bar to Bootstrap navbar
- [ ] Migrate logo
- [ ] Migrate navigation links
- [ ] Migrate search bar
- [ ] Migrate user menu/cart icon
- [ ] Test mobile collapse menu
- [ ] Test dropdown menus

```vue
<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <Link :href="route('home')" class="navbar-brand">
        <img src="/logo.png" alt="Logo" height="40">
      </Link>
      
      <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarNav"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <Link :href="route('categories.index')" class="nav-link">
              Categories
            </Link>
          </li>
          <!-- More nav items -->
        </ul>
        
        <div class="d-flex">
          <SearchBar />
          <CartIcon />
          <UserMenu />
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import SearchBar from './SearchBar.vue';
import CartIcon from './CartIcon.vue';
import UserMenu from './UserMenu.vue';
</script>
```

**Checklist**:
- [ ] Navbar.vue created
- [ ] Mobile responsive
- [ ] All links functional

#### 3.3 Footer

**File: `resources/js/components/layout/Footer.vue`**

- [ ] Convert v-footer to Bootstrap footer
- [ ] Migrate all footer links
- [ ] Migrate newsletter subscription
- [ ] Test responsive layout

```vue
<template>
  <footer class="bg-dark text-white py-5 mt-auto">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>About Us</h5>
          <p>Your e-commerce description</p>
        </div>
        <div class="col-md-3">
          <h5>Quick Links</h5>
          <ul class="list-unstyled">
            <li><Link :href="route('about')">About</Link></li>
            <li><Link :href="route('contact.index')">Contact</Link></li>
          </ul>
        </div>
        <!-- More columns -->
      </div>
    </div>
  </footer>
</template>
```

**Checklist**:
- [ ] Footer.vue migrated
- [ ] All links working
- [ ] Newsletter form working

---

## Phase 4: Page Migration

### Week 4-7 (20 days)

**Strategy**: Migrate one page at a time, test thoroughly before moving to next

#### 4.1 Authentication Pages

##### Login Page
**File: `resources/js/Pages/Auth/Login.vue`**

- [ ] Backup original
- [ ] Replace v-card with BCard
- [ ] Replace v-text-field with BInput
- [ ] Replace v-btn with BButton
- [ ] Test form submission
- [ ] Test validation errors
- [ ] Test responsive layout
- [ ] Take comparison screenshot

##### Register Page
**File: `resources/js/Pages/Auth/Register.vue`**

- [ ] Migrate all form fields
- [ ] Test email verification flow
- [ ] Test validation
- [ ] Test responsive layout

##### Forgot Password
**File: `resources/js/Pages/Auth/ForgotPassword.vue`**

- [ ] Migrate form
- [ ] Test email sending
- [ ] Test validation

##### Reset Password
**File: `resources/js/Pages/Auth/ResetPassword.vue`**

- [ ] Migrate form
- [ ] Test password reset
- [ ] Test validation

**Auth Pages Checklist**:
- [ ] Login page migrated ✓
- [ ] Register page migrated ✓
- [ ] Forgot password migrated ✓
- [ ] Reset password migrated ✓
- [ ] All forms working ✓
- [ ] Validation working ✓
- [ ] Mobile responsive ✓

#### 4.2 Homepage

**File: `resources/js/Pages/Home.vue`**

- [ ] Backup original
- [ ] Migrate hero banner (v-carousel → Bootstrap carousel)
- [ ] Migrate category cards (v-card → BCard)
- [ ] Migrate product grids (v-row/v-col → row/col)
- [ ] Migrate featured products section
- [ ] Migrate special offers section
- [ ] Test all links
- [ ] Test image loading
- [ ] Test mobile layout
- [ ] Performance test

**Carousel Migration**:
```vue
<!-- Before: Vuetify -->
<v-carousel>
  <v-carousel-item v-for="banner in banners" :key="banner.id">
    <img :src="banner.image" />
  </v-carousel-item>
</v-carousel>

<!-- After: Bootstrap -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button 
      v-for="(banner, index) in banners" 
      :key="banner.id"
      type="button" 
      data-bs-target="#heroCarousel" 
      :data-bs-slide-to="index"
      :class="{ active: index === 0 }"
    ></button>
  </div>
  
  <div class="carousel-inner">
    <div 
      v-for="(banner, index) in banners" 
      :key="banner.id"
      class="carousel-item"
      :class="{ active: index === 0 }"
    >
      <img :src="banner.image" class="d-block w-100" :alt="banner.title">
    </div>
  </div>
  
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
```

**Homepage Checklist**:
- [ ] Hero carousel migrated ✓
- [ ] Categories section migrated ✓
- [ ] Featured products migrated ✓
- [ ] Special offers migrated ✓
- [ ] Newsletter signup migrated ✓
- [ ] All images loading ✓
- [ ] Mobile responsive ✓

#### 4.3 Product Pages

##### Product Listing
**File: `resources/js/Pages/Products/Index.vue`**

- [ ] Migrate filter sidebar (v-navigation-drawer → offcanvas)
- [ ] Migrate product grid (v-card → BCard)
- [ ] Migrate pagination (v-pagination → BPagination)
- [ ] Migrate sort dropdown (v-select → BSelect)
- [ ] Test filtering
- [ ] Test sorting
- [ ] Test pagination
- [ ] Test "Add to Cart" button
- [ ] Test wishlist button
- [ ] Mobile responsive

**Filter Sidebar Migration**:
```vue
<!-- Before: Vuetify -->
<v-navigation-drawer app>
  <v-list>...</v-list>
</v-navigation-drawer>

<!-- After: Bootstrap Offcanvas -->
<button 
  class="btn btn-primary d-lg-none mb-3" 
  type="button" 
  data-bs-toggle="offcanvas" 
  data-bs-target="#filterSidebar"
>
  <i class="bi bi-filter"></i> Filters
</button>

<div class="offcanvas offcanvas-start" tabindex="-1" id="filterSidebar">
  <div class="offcanvas-header">
    <h5>Filters</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <!-- Filter content -->
  </div>
</div>

<!-- Desktop: Always visible sidebar -->
<div class="d-none d-lg-block">
  <!-- Same filter content -->
</div>
```

##### Product Details
**File: `resources/js/Pages/Products/Show.vue`**

- [ ] Migrate image gallery (v-carousel → custom or Swiper.js)
- [ ] Migrate product info card
- [ ] Migrate color selector (v-chip → custom buttons)
- [ ] Migrate size selector
- [ ] Migrate quantity input
- [ ] Migrate tabs (v-tabs → Bootstrap tabs)
- [ ] Migrate reviews section
- [ ] Migrate related products
- [ ] Test "Add to Cart"
- [ ] Test image zoom
- [ ] Test review submission
- [ ] Mobile responsive

**Product Gallery** (Option: Keep Swiper.js):
```vue
<template>
  <div class="product-gallery">
    <swiper
      :modules="[Navigation, Pagination, Thumbs]"
      :navigation="true"
      :pagination="{ clickable: true }"
      :thumbs="{ swiper: thumbsSwiper }"
      class="main-swiper mb-3"
    >
      <swiper-slide v-for="image in product.images" :key="image.id">
        <img :src="image.url" class="img-fluid" />
      </swiper-slide>
    </swiper>
    
    <swiper
      @swiper="setThumbsSwiper"
      :slidesPerView="4"
      :spaceBetween="10"
      class="thumbs-swiper"
    >
      <swiper-slide v-for="image in product.images" :key="image.id">
        <img :src="image.url" class="img-fluid cursor-pointer" />
      </swiper-slide>
    </swiper>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
};
</script>
```

**Product Pages Checklist**:
- [ ] Product listing migrated ✓
- [ ] Filters working ✓
- [ ] Sorting working ✓
- [ ] Product details migrated ✓
- [ ] Image gallery working ✓
- [ ] Add to cart working ✓
- [ ] Reviews working ✓
- [ ] Mobile responsive ✓

#### 4.4 Categories Page

**File: `resources/js/Pages/Categories/Index.vue`**

- [ ] Migrate category grid
- [ ] Migrate category cards
- [ ] Test navigation to products

**File: `resources/js/Pages/Categories/Show.vue`**

- [ ] Migrate subcategory display
- [ ] Migrate product listing
- [ ] Test breadcrumbs

**Categories Checklist**:
- [ ] Category listing migrated ✓
- [ ] Category details migrated ✓
- [ ] Breadcrumbs working ✓

#### 4.5 Shopping Cart

**File: `resources/js/Pages/Cart/Index.vue`**

- [ ] Migrate cart items table/list
- [ ] Migrate quantity controls
- [ ] Migrate remove button
- [ ] Migrate cart summary card
- [ ] Migrate discount code input
- [ ] Test quantity update
- [ ] Test item removal
- [ ] Test discount application
- [ ] Test "Proceed to Checkout"
- [ ] Mobile responsive

**Cart Item Component**:
```vue
<template>
  <div class="card mb-3">
    <div class="row g-0">
      <div class="col-md-2">
        <img :src="item.product.image_url" class="img-fluid rounded-start" />
      </div>
      <div class="col-md-7">
        <div class="card-body">
          <h5 class="card-title">{{ item.product.name }}</h5>
          <p class="text-muted">{{ item.product.description }}</p>
          <p class="fw-bold">${{ item.price }}</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-body text-end">
          <div class="input-group mb-2" style="max-width: 120px;">
            <button class="btn btn-outline-secondary" @click="decreaseQty">-</button>
            <input type="number" class="form-control text-center" :value="item.quantity" readonly>
            <button class="btn btn-outline-secondary" @click="increaseQty">+</button>
          </div>
          <button class="btn btn-sm btn-danger" @click="removeItem">
            <i class="bi bi-trash"></i> Remove
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
```

**Cart Checklist**:
- [ ] Cart page migrated ✓
- [ ] Quantity controls working ✓
- [ ] Remove item working ✓
- [ ] Discount code working ✓
- [ ] Totals calculating correctly ✓
- [ ] Mobile responsive ✓

#### 4.6 Checkout Pages

**File: `resources/js/Pages/Checkout/Index.vue`**

- [ ] Migrate shipping address form
- [ ] Migrate payment method selection
- [ ] Migrate order summary
- [ ] Migrate step indicator (v-stepper → custom)
- [ ] Test form validation
- [ ] Test address selection
- [ ] Test payment integration
- [ ] Mobile responsive

**Step Indicator Migration**:
```vue
<!-- Bootstrap Progress Steps -->
<div class="checkout-steps mb-4">
  <div class="progress" style="height: 3px;">
    <div 
      class="progress-bar" 
      role="progressbar" 
      :style="{ width: `${(currentStep / totalSteps) * 100}%` }"
    ></div>
  </div>
  
  <div class="d-flex justify-content-between mt-2">
    <div 
      v-for="(step, index) in steps" 
      :key="index"
      class="text-center"
      :class="{ 'text-primary fw-bold': index + 1 === currentStep }"
    >
      <div 
        class="rounded-circle d-inline-flex align-items-center justify-content-center"
        :class="index + 1 <= currentStep ? 'bg-primary text-white' : 'bg-light'"
        style="width: 40px; height: 40px;"
      >
        {{ index + 1 }}
      </div>
      <div class="small mt-1">{{ step.title }}</div>
    </div>
  </div>
</div>
```

**Checkout Checklist**:
- [ ] Checkout page migrated ✓
- [ ] Shipping form working ✓
- [ ] Payment selection working ✓
- [ ] Order placement working ✓
- [ ] Step navigation working ✓
- [ ] Mobile responsive ✓

#### 4.7 User Profile Pages

**File: `resources/js/Pages/Profile/Index.vue`**

- [ ] Migrate profile tabs (v-tabs → Bootstrap tabs)
- [ ] Migrate profile info form
- [ ] Migrate password change form
- [ ] Migrate address management
- [ ] Migrate order history
- [ ] Test all forms
- [ ] Test address CRUD
- [ ] Mobile responsive

**Tabs Migration**:
```vue
<ul class="nav nav-tabs mb-4" role="tablist">
  <li class="nav-item" role="presentation">
    <button 
      class="nav-link active" 
      data-bs-toggle="tab" 
      data-bs-target="#profile"
      type="button"
    >
      Profile
    </button>
  </li>
  <li class="nav-item">
    <button 
      class="nav-link" 
      data-bs-toggle="tab" 
      data-bs-target="#orders"
      type="button"
    >
      Orders
    </button>
  </li>
  <!-- More tabs -->
</ul>

<div class="tab-content">
  <div class="tab-pane fade show active" id="profile">
    <!-- Profile content -->
  </div>
  <div class="tab-pane fade" id="orders">
    <!-- Orders content -->
  </div>
</div>
```

**Profile Pages Checklist**:
- [ ] Profile overview migrated ✓
- [ ] Edit profile migrated ✓
- [ ] Change password migrated ✓
- [ ] Address management migrated ✓
- [ ] Order history migrated ✓
- [ ] Wishlist migrated ✓
- [ ] All forms working ✓
- [ ] Mobile responsive ✓

#### 4.8 Additional Pages

##### Brands
**File: `resources/js/Pages/Brands/Index.vue`**
- [ ] Migrate brand grid
- [ ] Test brand navigation

**File: `resources/js/Pages/Brands/Show.vue`**
- [ ] Migrate brand products listing

##### Offers
**File: `resources/js/Pages/Offers/Index.vue`**
- [ ] Migrate offers grid
- [ ] Test filtering

##### Contact Us
**File: `resources/js/Pages/ContactUs/Index.vue`**
- [ ] Migrate contact form
- [ ] Test form submission

##### Static Pages
- [ ] Shipping Policy
- [ ] Terms & Conditions
- [ ] Privacy Policy
- [ ] FAQ
- [ ] Exchanges & Returns

##### Bulk Order
**File: `resources/js/Pages/BulkOrder/Index.vue`**
- [ ] Migrate bulk order form

##### Representative Order
**File: `resources/js/Pages/RepresentativeOrder/Index.vue`**
- [ ] Migrate representative order form

##### Compare
**File: `resources/js/Pages/Compare.vue`**
- [ ] Migrate product comparison table

##### Payment
**File: `resources/js/Pages/Payment/Show.vue`**
- [ ] Migrate payment page

**Additional Pages Checklist**:
- [ ] Brands pages migrated ✓
- [ ] Offers page migrated ✓
- [ ] Contact page migrated ✓
- [ ] Static pages migrated ✓
- [ ] Bulk order migrated ✓
- [ ] Representative order migrated ✓
- [ ] Compare page migrated ✓
- [ ] Payment page migrated ✓

---

## Phase 5: Testing & QA

### Week 7-8 (10 days)

#### 5.1 Functional Testing

- [ ] Test all user flows end-to-end
- [ ] Test guest checkout flow
- [ ] Test registered user checkout flow
- [ ] Test product search
- [ ] Test product filtering
- [ ] Test cart operations
- [ ] Test wishlist operations
- [ ] Test user registration
- [ ] Test password reset
- [ ] Test profile updates
- [ ] Test address management
- [ ] Test order placement
- [ ] Test payment integration
- [ ] Test discount codes
- [ ] Test newsletter subscription
- [ ] Test contact form

#### 5.2 Cross-Browser Testing

- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Chrome (Android)
- [ ] Mobile Safari (iOS)

#### 5.3 Responsive Testing

**Test on multiple screen sizes**:
- [ ] Desktop (1920x1080)
- [ ] Laptop (1366x768)
- [ ] Tablet Portrait (768x1024)
- [ ] Tablet Landscape (1024x768)
- [ ] Mobile Portrait (375x667)
- [ ] Mobile Landscape (667x375)
- [ ] Large Mobile (414x896)

#### 5.4 Performance Testing

- [ ] Run Lighthouse audit (target: 90+ on all metrics)
- [ ] Check bundle size (should be smaller than Vuetify version)
- [ ] Test page load times
- [ ] Test time to interactive
- [ ] Check for console errors
- [ ] Check for memory leaks

**Lighthouse Targets**:
- Performance: 90+
- Accessibility: 95+
- Best Practices: 95+
- SEO: 95+

#### 5.5 Accessibility Testing

- [ ] Test keyboard navigation on all pages
- [ ] Test screen reader compatibility (NVDA/JAWS)
- [ ] Verify proper heading hierarchy
- [ ] Verify form labels
- [ ] Verify ARIA attributes
- [ ] Test color contrast (WCAG AA minimum)
- [ ] Test focus indicators

**Tools**:
- axe DevTools extension
- WAVE browser extension
- Lighthouse accessibility audit

#### 5.6 Visual Regression Testing

- [ ] Compare screenshots with original Vuetify version
- [ ] Verify all colors match design
- [ ] Verify spacing/padding is consistent
- [ ] Verify typography is consistent
- [ ] Check for layout shifts

**Tools**:
- Percy.io (automated visual testing)
- Manual screenshot comparison

#### 5.7 Integration Testing

- [ ] Test API endpoints still work
- [ ] Test authentication flows
- [ ] Test payment gateway integration
- [ ] Test email notifications
- [ ] Test file uploads

#### 5.8 Bug Tracking

**Create bug tracker spreadsheet or use issue tracker**:

| ID | Page | Component | Issue | Priority | Status | Assigned |
|----|------|-----------|-------|----------|--------|----------|
| 1  | Cart | Quantity | Doesn't update | High | Open | Dev A |
| 2  | Product | Image | Zoom broken on mobile | Medium | Fixed | Dev B |

- [ ] Log all bugs found
- [ ] Prioritize bugs (Critical/High/Medium/Low)
- [ ] Assign bugs to developers
- [ ] Retest after fixes

---

## Phase 6: Cleanup & Optimization

### Week 8 (5 days)

#### 6.1 Remove Vuetify

**Only after 100% migration complete and tested**:

- [ ] Remove Vuetify imports from app.js
- [ ] Remove Vuetify plugin from vite.config.js
- [ ] Uninstall Vuetify packages
- [ ] Remove Material Design Icons (if not needed)
- [ ] Remove Vuetify SCSS files

```bash
npm uninstall vuetify vite-plugin-vuetify @mdi/font sass
```

- [ ] Remove Vuetify configuration
- [ ] Test that app still works
- [ ] Check bundle size reduction

#### 6.2 Code Cleanup

- [ ] Remove unused components
- [ ] Remove commented code
- [ ] Standardize code formatting
- [ ] Run ESLint and fix issues
- [ ] Update component documentation
- [ ] Remove console.log statements

```bash
# Format code
npm run lint --fix

# Or use Prettier
npx prettier --write "resources/js/**/*.{js,vue}"
```

#### 6.3 Optimize Bundle

- [ ] Analyze bundle size
- [ ] Code-split large components
- [ ] Lazy-load heavy pages
- [ ] Optimize images
- [ ] Minify CSS/JS

```bash
# Analyze bundle
npm run build -- --analyze

# Check gzipped size
npx vite-bundle-visualizer
```

#### 6.4 Performance Optimizations

- [ ] Add lazy loading for images
- [ ] Implement route-based code splitting
- [ ] Add service worker (optional)
- [ ] Implement caching strategies
- [ ] Optimize font loading

#### 6.5 Documentation

- [ ] Document new component library
- [ ] Create component usage guide
- [ ] Update README with Bootstrap info
- [ ] Document migration decisions
- [ ] Create style guide

**Create: `docs/BOOTSTRAP_COMPONENTS.md`**:
```markdown
# Bootstrap Component Library

## BButton

Usage:
\`\`\`vue
<BButton variant="primary" size="lg" @click="handleClick">
  Click Me
</BButton>
\`\`\`

Props:
- variant: primary | secondary | success | danger | warning | info
- size: sm | md | lg
- disabled: boolean
- loading: boolean
...
```

#### 6.6 Final Checklist

- [ ] All Vuetify code removed ✓
- [ ] All pages migrated and tested ✓
- [ ] No console errors ✓
- [ ] Bundle size reduced ✓
- [ ] Performance improved ✓
- [ ] Accessibility maintained ✓
- [ ] Documentation updated ✓
- [ ] Team trained on new components ✓

---

## Rollback Plan

### If Critical Issues Arise

**Preparation**:
- [ ] Tag current Vuetify version: `git tag -a v1.0-vuetify`
- [ ] Keep backup branch: `backup/vuetify-version`

**Rollback Steps**:
1. Stop deployment
2. Checkout backup branch: `git checkout backup/vuetify-version`
3. Reinstall dependencies: `npm install`
4. Rebuild: `npm run build`
5. Deploy previous version
6. Investigate issues
7. Fix and redeploy Bootstrap version

**Partial Rollback**:
- Keep Vuetify installed alongside Bootstrap
- Revert specific pages to Vuetify version
- Use feature flags to toggle between versions

---

## Component Mapping Reference

### Complete Vuetify → Bootstrap Mapping

| Vuetify Component | Bootstrap Equivalent | Notes |
|-------------------|---------------------|-------|
| `v-app` | `<div id="app">` | Main wrapper |
| `v-container` | `<div class="container">` | Container |
| `v-row` | `<div class="row">` | Grid row |
| `v-col` | `<div class="col">` | Grid column |
| `v-btn` | `<button class="btn">` | Button |
| `v-card` | `<div class="card">` | Card component |
| `v-card-title` | `<div class="card-title">` | Card title |
| `v-card-text` | `<div class="card-body">` | Card content |
| `v-card-actions` | `<div class="card-footer">` | Card actions |
| `v-text-field` | `<input class="form-control">` | Text input |
| `v-textarea` | `<textarea class="form-control">` | Textarea |
| `v-select` | `<select class="form-select">` | Dropdown |
| `v-checkbox` | `<input type="checkbox" class="form-check-input">` | Checkbox |
| `v-radio` | `<input type="radio" class="form-check-input">` | Radio button |
| `v-switch` | `<div class="form-check form-switch">` | Toggle switch |
| `v-alert` | `<div class="alert">` | Alert message |
| `v-chip` | `<span class="badge">` | Badge/chip |
| `v-avatar` | Custom component or `<img class="rounded-circle">` | Avatar |
| `v-badge` | `<span class="badge">` with positioning | Badge |
| `v-dialog` | `<div class="modal">` | Modal dialog |
| `v-menu` | `<div class="dropdown">` | Dropdown menu |
| `v-navigation-drawer` | `<div class="offcanvas">` | Sidebar |
| `v-app-bar` | `<nav class="navbar">` | Navigation bar |
| `v-toolbar` | `<nav class="navbar">` | Toolbar |
| `v-footer` | `<footer>` | Footer |
| `v-pagination` | `<nav><ul class="pagination">` | Pagination |
| `v-tabs` | `<ul class="nav nav-tabs">` | Tabs |
| `v-tab` | `<li class="nav-item">` | Tab item |
| `v-tab-item` | `<div class="tab-pane">` | Tab content |
| `v-carousel` | `<div class="carousel">` | Carousel |
| `v-carousel-item` | `<div class="carousel-item">` | Carousel slide |
| `v-data-table` | `<table class="table">` or custom | Data table |
| `v-list` | `<ul class="list-group">` | List |
| `v-list-item` | `<li class="list-group-item">` | List item |
| `v-divider` | `<hr>` | Divider |
| `v-spacer` | `<div class="flex-grow-1">` or `ms-auto` | Spacer |
| `v-progress-circular` | `<div class="spinner-border">` | Loading spinner |
| `v-progress-linear` | `<div class="progress">` | Progress bar |
| `v-tooltip` | Bootstrap Tooltip (needs JS) | Tooltip |
| `v-snackbar` | Bootstrap Toast (custom) | Toast notification |
| `v-form` | `<form>` | Form |
| `v-stepper` | Custom component | Stepper |
| `v-expansion-panel` | `<div class="accordion">` | Accordion |
| `v-rating` | Custom component | Star rating |
| `v-slider` | `<input type="range" class="form-range">` | Slider |

### Icon Mapping

| Material Design Icons | Bootstrap Icons |
|----------------------|-----------------|
| `mdi-home` | `bi-house` |
| `mdi-cart` | `bi-cart` |
| `mdi-heart` | `bi-heart` |
| `mdi-account` | `bi-person` |
| `mdi-magnify` | `bi-search` |
| `mdi-menu` | `bi-list` |
| `mdi-close` | `bi-x` |
| `mdi-check` | `bi-check` |
| `mdi-delete` | `bi-trash` |
| `mdi-pencil` | `bi-pencil` |
| `mdi-arrow-left` | `bi-arrow-left` |
| `mdi-arrow-right` | `bi-arrow-right` |
| `mdi-chevron-down` | `bi-chevron-down` |
| `mdi-chevron-up` | `bi-chevron-up` |
| `mdi-star` | `bi-star` |
| `mdi-star-outline` | `bi-star` |

Full icon list: https://icons.getbootstrap.com/

---

## Progress Tracking

### Overall Progress

- [ ] Phase 0: Preparation (0%)
- [ ] Phase 1: Setup & Configuration (0%)
- [ ] Phase 2: Component Library (0%)
- [ ] Phase 3: Layout Migration (0%)
- [ ] Phase 4: Page Migration (0%)
- [ ] Phase 5: Testing & QA (0%)
- [ ] Phase 6: Cleanup (0%)

### Weekly Goals

**Week 1**:
- [ ] Complete Phase 0 and Phase 1
- [ ] Start Phase 2 (core components)

**Week 2-3**:
- [ ] Complete Phase 2
- [ ] Complete Phase 3

**Week 4-7**:
- [ ] Complete Phase 4 (all pages)

**Week 7-8**:
- [ ] Complete Phase 5 (testing)
- [ ] Complete Phase 6 (cleanup)

---

## Team Communication

### Daily Standup Topics
- Pages migrated yesterday
- Pages to migrate today
- Blockers/issues

### Weekly Review
- Demo migrated pages
- Review test results
- Discuss challenges
- Adjust timeline if needed

---

## Risk Mitigation

### Identified Risks

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Breaking checkout flow | High | Medium | Thorough testing, feature flags |
| Performance regression | Medium | Low | Performance testing, monitoring |
| Accessibility issues | Medium | Medium | Accessibility audit, automated tests |
| Timeline overrun | Medium | High | Buffer time, prioritize pages |
| Team unfamiliar with Bootstrap | Low | High | Training, documentation, pair programming |

---

## Success Criteria

Migration is considered successful when:

1. ✅ All pages visually match original design
2. ✅ All functionality works as before
3. ✅ No console errors in production
4. ✅ Performance metrics maintained or improved
5. ✅ Accessibility standards maintained
6. ✅ Mobile responsive on all pages
7. ✅ Bundle size reduced
8. ✅ All tests passing
9. ✅ Team trained on new components
10. ✅ Documentation complete

---

## Post-Migration Tasks

After successful migration:

- [ ] Monitor production for issues
- [ ] Gather user feedback
- [ ] Create component library documentation
- [ ] Train customer support on any UI changes
- [ ] Celebrate with team! 🎉

---

**Plan Created**: January 2026  
**Last Updated**: January 2026  
**Version**: 1.0

