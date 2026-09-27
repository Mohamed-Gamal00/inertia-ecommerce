<template>
  <div
    v-if="modelValue"
    :class="alertClasses"
    role="alert"
  >
    <div class="d-flex align-items-start">
      <i v-if="icon" :class="`bi bi-${icon} me-2 flex-shrink-0`" style="font-size: 1.25rem;"></i>
      <div class="flex-grow-1">
        <slot />
      </div>
      <button
        v-if="dismissible"
        type="button"
        class="btn-close"
        aria-label="Close"
        @click="$emit('update:modelValue', false)"
      ></button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: { type: Boolean, default: true },
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => [
      'primary', 'secondary', 'success', 'danger',
      'warning', 'info', 'light', 'dark'
    ].includes(value)
  },
  dismissible: { type: Boolean, default: false },
  icon: { type: String, default: '' }
});

defineEmits(['update:modelValue']);

const alertClasses = computed(() => {
  const classes = ['alert'];
  classes.push(`alert-${props.variant}`);

  if (props.dismissible) {
    classes.push('alert-dismissible fade show');
  }

  return classes.join(' ');
});
</script>
