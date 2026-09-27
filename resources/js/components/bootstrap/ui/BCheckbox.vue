<template>
  <div class="form-check" :class="{ 'form-switch': isSwitch, 'form-check-inline': inline }">
    <input
      :id="id"
      type="checkbox"
      :class="checkboxClasses"
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
  modelValue: { type: [Boolean, Array], default: false },
  label: { type: String, default: '' },
  value: { type: [String, Number, Boolean], default: true },
  disabled: { type: Boolean, default: false },
  isSwitch: { type: Boolean, default: false },
  inline: { type: Boolean, default: false },
  error: { type: String, default: '' },
  hint: { type: String, default: '' },
  id: {
    type: String,
    default: () => `checkbox-${Math.random().toString(36).substr(2, 9)}`
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const checkboxClasses = computed(() => {
  const classes = ['form-check-input'];

  if (props.error) {
    classes.push('is-invalid');
  }

  return classes.join(' ');
});

const isChecked = computed(() => {
  if (Array.isArray(props.modelValue)) {
    return props.modelValue.includes(props.value);
  }
  return props.modelValue === true;
});

const handleChange = (event) => {
  const isChecked = event.target.checked;

  if (Array.isArray(props.modelValue)) {
    const newValue = [...props.modelValue];

    if (isChecked) {
      newValue.push(props.value);
    } else {
      const index = newValue.indexOf(props.value);
      if (index > -1) {
        newValue.splice(index, 1);
      }
    }

    emit('update:modelValue', newValue);
    emit('change', newValue);
  } else {
    emit('update:modelValue', isChecked);
    emit('change', isChecked);
  }
};
</script>
