<template>
  <nav :class="navbarClasses">
    <div :class="containerClass">
      <!-- Brand -->
      <a v-if="brand || $slots.brand" :href="brandHref" class="navbar-brand">
        <slot name="brand">{{ brand }}</slot>
      </a>

      <!-- Toggler for mobile -->
      <button
        v-if="!noCollapse"
        class="navbar-toggler"
        type="button"
        @click="isCollapsed = !isCollapsed"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar content -->
      <div
        :class="collapseClasses"
        :id="id"
      >
        <slot />
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  brand: { type: String, default: '' },
  brandHref: { type: String, default: '/' },
  variant: { type: String, default: 'light' }, // light, dark
  bg: { type: String, default: '' }, // primary, secondary, dark, light, etc.
  expand: { type: String, default: 'lg' }, // sm, md, lg, xl, xxl
  fixed: { type: String, default: '' }, // top, bottom
  sticky: { type: String, default: '' }, // top
  container: { type: [String, Boolean], default: true }, // true, false, sm, md, lg, xl, xxl, fluid
  noCollapse: { type: Boolean, default: false },
  id: {
    type: String,
    default: () => `navbar-${Math.random().toString(36).substr(2, 9)}`
  }
});

const isCollapsed = ref(true);

const navbarClasses = computed(() => {
  const classes = ['navbar'];

  // Expand breakpoint
  if (props.expand) {
    classes.push(`navbar-expand-${props.expand}`);
  }

  // Variant
  if (props.variant) {
    classes.push(`navbar-${props.variant}`);
  }

  // Background
  if (props.bg) {
    classes.push(`bg-${props.bg}`);
  }

  // Fixed
  if (props.fixed) {
    classes.push(`fixed-${props.fixed}`);
  }

  // Sticky
  if (props.sticky) {
    classes.push(`sticky-${props.sticky}`);
  }

  return classes.join(' ');
});

const containerClass = computed(() => {
  if (props.container === true) {
    return 'container';
  } else if (props.container === false) {
    return '';
  } else if (props.container === 'fluid') {
    return 'container-fluid';
  } else {
    return `container-${props.container}`;
  }
});

const collapseClasses = computed(() => {
  const classes = [];

  if (!props.noCollapse) {
    classes.push('collapse', 'navbar-collapse');
    if (!isCollapsed.value) {
      classes.push('show');
    }
  }

  return classes.join(' ');
});
</script>
