<template>
  <div :class="cardClasses">
    <img
      v-if="imgSrc"
      :src="imgSrc"
      class="card-img-top"
      :alt="imgAlt"
      :style="imgHeight ? `height: ${imgHeight}; object-fit: cover;` : ''"
    >

    <div v-if="$slots.header || header" class="card-header">
      <slot name="header">{{ header }}</slot>
    </div>

    <div class="card-body" :class="bodyClass">
      <h5 v-if="title" class="card-title">{{ title }}</h5>
      <h6 v-if="subtitle" class="card-subtitle mb-2 text-muted">{{ subtitle }}</h6>
      <slot />
    </div>

    <div v-if="$slots.footer || footer" class="card-footer" :class="footerClass">
      <slot name="footer">{{ footer }}</slot>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  header: { type: String, default: '' },
  footer: { type: String, default: '' },
  imgSrc: { type: String, default: '' },
  imgAlt: { type: String, default: '' },
  imgHeight: { type: String, default: '' },
  shadow: { type: Boolean, default: true },
  hoverable: { type: Boolean, default: false },
  fullHeight: { type: Boolean, default: false },
  rounded: { type: String, default: '' }, // '', 'sm', 'lg', 'xl'
  border: { type: Boolean, default: false },
  bodyClass: { type: String, default: '' },
  footerClass: { type: String, default: '' }
});

const cardClasses = computed(() => {
  const classes = ['card'];

  // Shadow
  if (props.shadow) {
    classes.push('shadow-sm');
  }

  // Hoverable
  if (props.hoverable) {
    classes.push('card-hoverable');
  }

  // Full height
  if (props.fullHeight) {
    classes.push('h-100');
  }

  // Rounded
  if (props.rounded) {
    classes.push(`rounded-${props.rounded}`);
  }

  // Border
  if (!props.border) {
    classes.push('border-0');
  }

  return classes.join(' ');
});
</script>

<style scoped>
.card {
  transition: all 0.3s ease;
}

.card-hoverable:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
}
</style>
