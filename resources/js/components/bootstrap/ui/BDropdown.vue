<template>
  <div class="dropdown" :class="{ show: isOpen }">
    <button
      :class="buttonClasses"
      type="button"
      :id="id"
      @click="toggle"
    >
      <i v-if="icon" :class="`bi bi-${icon} me-2`"></i>
      <slot name="button">{{ text }}</slot>
      <i v-if="!hideArrow" class="bi bi-chevron-down ms-2"></i>
    </button>

    <ul
      :class="menuClasses"
      :aria-labelledby="id"
      @click="handleMenuClick"
    >
      <slot />
    </ul>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  text: { type: String, default: 'Dropdown' },
  icon: { type: String, default: '' },
  variant: { type: String, default: 'primary' },
  size: { type: String, default: 'md' }, // sm, md, lg
  split: { type: Boolean, default: false },
  hideArrow: { type: Boolean, default: false },
  align: { type: String, default: 'start' }, // start, end
  direction: { type: String, default: 'down' }, // up, down, start, end
  autoClose: { type: Boolean, default: true },
  id: {
    type: String,
    default: () => `dropdown-${Math.random().toString(36).substr(2, 9)}`
  }
});

const emit = defineEmits(['show', 'hide']);

const isOpen = ref(false);

const buttonClasses = computed(() => {
  const classes = ['btn', `btn-${props.variant}`, 'dropdown-toggle'];

  if (props.size === 'sm') {
    classes.push('btn-sm');
  } else if (props.size === 'lg') {
    classes.push('btn-lg');
  }

  return classes.join(' ');
});

const menuClasses = computed(() => {
  const classes = ['dropdown-menu'];

  if (isOpen.value) {
    classes.push('show');
  }

  if (props.align === 'end') {
    classes.push('dropdown-menu-end');
  }

  return classes.join(' ');
});

const toggle = () => {
  isOpen.value = !isOpen.value;

  if (isOpen.value) {
    emit('show');
  } else {
    emit('hide');
  }
};

const close = () => {
  if (isOpen.value) {
    isOpen.value = false;
    emit('hide');
  }
};

const handleMenuClick = (event) => {
  // Close dropdown when clicking on an item (unless it's disabled)
  if (props.autoClose && !event.target.classList.contains('disabled')) {
    close();
  }
};

const handleClickOutside = (event) => {
  const dropdown = event.target.closest('.dropdown');
  if (!dropdown && isOpen.value) {
    close();
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  min-width: 10rem;
  margin: 0.125rem 0 0;
}

.dropdown-menu.show {
  display: block;
}
</style>
