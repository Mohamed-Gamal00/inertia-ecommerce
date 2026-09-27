<template>
  <div :class="colClass">
    <slot />
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  // Responsive column sizes
  cols: { type: [String, Number], default: null }, // 1-12 or 'auto'
  sm: { type: [String, Number], default: null },
  md: { type: [String, Number], default: null },
  lg: { type: [String, Number], default: null },
  xl: { type: [String, Number], default: null },
  xxl: { type: [String, Number], default: null },

  // Offset
  offset: { type: [String, Number], default: null },
  offsetSm: { type: [String, Number], default: null },
  offsetMd: { type: [String, Number], default: null },
  offsetLg: { type: [String, Number], default: null },
  offsetXl: { type: [String, Number], default: null },
  offsetXxl: { type: [String, Number], default: null },

  // Order
  order: { type: [String, Number], default: null },
  orderSm: { type: [String, Number], default: null },
  orderMd: { type: [String, Number], default: null },
  orderLg: { type: [String, Number], default: null },
  orderXl: { type: [String, Number], default: null },
  orderXxl: { type: [String, Number], default: null }
});

const colClass = computed(() => {
  const classes = [];

  // Base column
  if (props.cols) {
    if (props.cols === 'auto') {
      classes.push('col-auto');
    } else {
      classes.push(`col-${props.cols}`);
    }
  } else if (!props.sm && !props.md && !props.lg && !props.xl && !props.xxl) {
    classes.push('col');
  }

  // Responsive columns
  const breakpoints = ['sm', 'md', 'lg', 'xl', 'xxl'];
  breakpoints.forEach(bp => {
    const value = props[bp];
    if (value) {
      if (value === 'auto') {
        classes.push(`col-${bp}-auto`);
      } else {
        classes.push(`col-${bp}-${value}`);
      }
    }
  });

  // Offsets
  if (props.offset) classes.push(`offset-${props.offset}`);
  breakpoints.forEach(bp => {
    const key = `offset${bp.charAt(0).toUpperCase() + bp.slice(1)}`;
    const value = props[key];
    if (value) classes.push(`offset-${bp}-${value}`);
  });

  // Order
  if (props.order) classes.push(`order-${props.order}`);
  breakpoints.forEach(bp => {
    const key = `order${bp.charAt(0).toUpperCase() + bp.slice(1)}`;
    const value = props[key];
    if (value) classes.push(`order-${bp}-${value}`);
  });

  return classes.join(' ');
});
</script>
