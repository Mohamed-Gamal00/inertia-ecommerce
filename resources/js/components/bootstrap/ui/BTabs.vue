<template>
  <div>
    <!-- Nav Tabs -->
    <ul :class="navClasses" role="tablist">
      <li
        v-for="(tab, index) in tabs"
        :key="index"
        class="nav-item"
        role="presentation"
      >
        <button
          :class="['nav-link', { active: modelValue === index }]"
          :id="`${id}-tab-${index}`"
          type="button"
          role="tab"
          :aria-controls="`${id}-panel-${index}`"
          :aria-selected="modelValue === index"
          @click="changeTab(index)"
        >
          <i v-if="tab.icon" :class="`bi bi-${tab.icon} me-2`"></i>
          {{ tab.title }}
          <BBadge v-if="tab.badge" :variant="tab.badgeVariant || 'primary'" class="ms-2">
            {{ tab.badge }}
          </BBadge>
        </button>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" :class="contentClass">
      <div
        v-for="(tab, index) in tabs"
        :key="index"
        :class="['tab-pane fade', { 'show active': modelValue === index }]"
        :id="`${id}-panel-${index}`"
        role="tabpanel"
        :aria-labelledby="`${id}-tab-${index}`"
      >
        <slot :name="`tab-${index}`">
          {{ tab.content }}
        </slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import BBadge from './BBadge.vue';

const props = defineProps({
  modelValue: { type: Number, default: 0 }, // Active tab index
  tabs: {
    type: Array,
    required: true,
    // Array of objects: { title, icon?, badge?, badgeVariant?, content? }
  },
  variant: { type: String, default: 'tabs' }, // tabs, pills
  justified: { type: Boolean, default: false },
  fill: { type: Boolean, default: false },
  vertical: { type: Boolean, default: false },
  contentClass: { type: String, default: 'p-3' },
  id: {
    type: String,
    default: () => `tabs-${Math.random().toString(36).substr(2, 9)}`
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const navClasses = computed(() => {
  const classes = ['nav'];

  if (props.variant === 'tabs') {
    classes.push('nav-tabs');
  } else if (props.variant === 'pills') {
    classes.push('nav-pills');
  }

  if (props.justified) {
    classes.push('nav-justified');
  }

  if (props.fill) {
    classes.push('nav-fill');
  }

  if (props.vertical) {
    classes.push('flex-column');
  }

  return classes.join(' ');
});

const changeTab = (index) => {
  emit('update:modelValue', index);
  emit('change', index);
};
</script>

<style scoped>
.nav-link {
  cursor: pointer;
  user-select: none;
}

.tab-content {
  border: 1px solid #dee2e6;
  border-top: none;
  border-radius: 0 0 0.375rem 0.375rem;
}

.nav-pills + .tab-content {
  border: 1px solid #dee2e6;
  border-radius: 0.375rem;
  margin-top: 1rem;
}
</style>
