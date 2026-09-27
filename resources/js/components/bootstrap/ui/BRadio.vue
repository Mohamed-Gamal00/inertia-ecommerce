<template>
  <div class="form-check" :class="{ 'form-check-inline': inline }">
    <input
      :id="id"
      type="radio"
      :class="radioClasses"
      :name="name"
      :checked="isChecked"
      :disabled="disabled"
      :value="value"
      @change="handleChange"
    >
    <label v-if="label || $slots.default" :for="id" class="form-check-label">
      <slot>{{ label }}</slot>
    </label>
    <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
    <div v-else-if="hint" class="form-text">{{ hint }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: { type: [String, Number, Boolean], default: null },
  label: { type: String, default: '' },
  value: { type: [String, Number, Boolean], required: true },
  name: { type: String, required: true },
  disabled: { type: Boolean, default: false },
  inline: { type: Boolean, default: false },
  error: { type: String, default: '' },
  hint: { type: String, default: '' },
  id: {
    type: String,
    default: () => `radio-${Math.random().toString(36).substr(2, 9)}`
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const radioClasses = computed(() => {
  const classes = ['form-check-input'];

  if (props.error) {
    classes.push('is-invalid');
  }

  return classes.join(' ');
});

const isChecked = computed(() => {
  return props.modelValue === props.value;
});

const handleChange = (event) => {
  if (event.target.checked) {
    emit('update:modelValue', props.value);
    emit('change', props.value);
  }
};
</script>
