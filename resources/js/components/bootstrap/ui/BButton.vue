<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="$emit('click', $event)"
  >
    <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
    <i v-if="icon && !loading" :class="`bi bi-${icon} me-2`"></i>
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => [
      'primary', 'secondary', 'success', 'danger',
      'warning', 'info', 'light', 'dark', 'link'
    ].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  disabled: { type: Boolean, default: false },
  loading: { type: Boolean, default: false },
  outline: { type: Boolean, default: false },
  block: { type: Boolean, default: false },
  icon: { type: String, default: '' },
  type: { type: String, default: 'button' },
  rounded: { type: String, default: '' } // '', 'pill', 'circle'
});

defineEmits(['click']);

const buttonClasses = computed(() => {
  const classes = ['btn'];

  // Variant
  if (props.outline) {
    classes.push(`btn-outline-${props.variant}`);
  } else {
    classes.push(`btn-${props.variant}`);
  }

  // Size
  if (props.size === 'sm') {
    classes.push('btn-sm');
  } else if (props.size === 'lg') {
    classes.push('btn-lg');
  }

  // Block
  if (props.block) {
    classes.push('w-100');
  }

  // Rounded
  if (props.rounded === 'pill') {
    classes.push('rounded-pill');
  } else if (props.rounded === 'circle') {
    classes.push('rounded-circle');
  }

  return classes.join(' ');
});
</script>

<style scoped>
/* Additional button styling to match Vuetify */
.btn {
  font-weight: 500;
  letter-spacing: 0.0892857143em;
  text-transform: uppercase;
}
</style>
