<template>
  <li>
    <component
      :is="tag"
      :class="itemClasses"
      :href="href"
      :disabled="disabled"
      @click="handleClick"
    >
      <i v-if="icon" :class="`bi bi-${icon} me-2`"></i>
      <slot />
    </component>
  </li>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  href: { type: String, default: '#' },
  disabled: { type: Boolean, default: false },
  active: { type: Boolean, default: false },
  divider: { type: Boolean, default: false },
  icon: { type: String, default: '' },
  tag: { type: String, default: 'a' }
});

const emit = defineEmits(['click']);

const itemClasses = computed(() => {
  if (props.divider) {
    return 'dropdown-divider';
  }

  const classes = ['dropdown-item'];

  if (props.active) {
    classes.push('active');
  }

  if (props.disabled) {
    classes.push('disabled');
  }

  return classes.join(' ');
});

const handleClick = (event) => {
  if (props.disabled) {
    event.preventDefault();
    return;
  }

  if (props.href === '#') {
    event.preventDefault();
  }

  emit('click', event);
};
</script>
