<template>
  <div :class="containerClass">
    <slot />
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  fluid: { type: [Boolean, String], default: false }, // true, sm, md, lg, xl, xxl
  tag: { type: String, default: 'div' }
});

const containerClass = computed(() => {
  if (props.fluid === true) {
    return 'container-fluid';
  } else if (props.fluid === false) {
    return 'container';
  } else {
    return `container-${props.fluid}`;
  }
});
</script>
