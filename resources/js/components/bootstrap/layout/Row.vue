<template>
  <div :class="rowClass">
    <slot />
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  cols: { type: [String, Number], default: null }, // Auto columns
  align: { type: String, default: '' }, // start, center, end, baseline, stretch
  justify: { type: String, default: '' }, // start, center, end, around, between, evenly
  noGutters: { type: Boolean, default: false },
  gutter: { type: [String, Number], default: '' } // 0-5
});

const rowClass = computed(() => {
  const classes = ['row'];

  if (props.cols) {
    classes.push(`row-cols-${props.cols}`);
  }

  if (props.align) {
    classes.push(`align-items-${props.align}`);
  }

  if (props.justify) {
    classes.push(`justify-content-${props.justify}`);
  }

  if (props.noGutters) {
    classes.push('g-0');
  } else if (props.gutter) {
    classes.push(`g-${props.gutter}`);
  }

  return classes.join(' ');
});
</script>
