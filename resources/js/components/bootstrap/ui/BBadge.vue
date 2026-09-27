<template>
  <span :class="badgeClasses">
    <i v-if="icon" :class="`bi bi-${icon} me-1`"></i>
    <slot />
    <button
      v-if="closeable"
      type="button"
      class="btn-close btn-close-white ms-2"
      style="font-size: 0.5rem;"
      @click="$emit('close')"
    ></button>
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => [
      'primary', 'secondary', 'success', 'danger',
      'warning', 'info', 'light', 'dark'
    ].includes(value)
  },
  pill: { type: Boolean, default: false },
  closeable: { type: Boolean, default: false },
  icon: { type: String, default: '' },
  outlined: { type: Boolean, default: false }
});

defineEmits(['close']);

const badgeClasses = computed(() => {
  const classes = ['badge'];

  if (props.outlined) {
    classes.push(`border border-${props.variant} text-${props.variant}`);
    classes.push('bg-transparent');
  } else {
    classes.push(`bg-${props.variant}`);
  }

  if (props.pill) {
    classes.push('rounded-pill');
  }

  if (props.closeable) {
    classes.push('d-inline-flex align-items-center');
  }

  return classes.join(' ');
});
</script>

<style scoped>
.badge {
  font-weight: 500;
  font-size: 0.75rem;
  padding: 0.35em 0.65em;
}

.badge.border {
  padding: 0.25em 0.55em;
}
</style>
