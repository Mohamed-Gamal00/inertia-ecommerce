<template>
  <span
    :class="spinnerClasses"
    :role="role"
    :style="sizeStyle"
  >
    <span v-if="sr" class="visually-hidden">{{ sr }}</span>
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  type: {
    type: String,
    default: 'border',
    validator: (value) => ['border', 'grow'].includes(value)
  },
  size: { type: String, default: 'md' }, // sm, md, lg, or custom like '2rem'
  variant: { type: String, default: 'primary' },
  sr: { type: String, default: 'Loading...' }, // Screen reader text
  role: { type: String, default: 'status' }
});

const spinnerClasses = computed(() => {
  const classes = [];

  if (props.type === 'border') {
    classes.push('spinner-border');
  } else {
    classes.push('spinner-grow');
  }

  if (props.size === 'sm') {
    classes.push(props.type === 'border' ? 'spinner-border-sm' : 'spinner-grow-sm');
  }

  if (props.variant) {
    classes.push(`text-${props.variant}`);
  }

  return classes.join(' ');
});

const sizeStyle = computed(() => {
  if (props.size !== 'sm' && props.size !== 'md') {
    return {
      width: props.size,
      height: props.size
    };
  }
  return {};
});
</script>
