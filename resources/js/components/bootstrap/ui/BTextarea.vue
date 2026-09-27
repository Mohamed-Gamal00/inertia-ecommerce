<template>
  <div class="mb-3">
    <label v-if="label" :for="id" class="form-label">
      {{ label }}
      <span v-if="required" class="text-danger">*</span>
    </label>

    <textarea
      :id="id"
      :value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :required="required"
      :rows="rows"
      :maxlength="maxlength"
      :class="textareaClasses"
      @input="$emit('update:modelValue', $event.target.value)"
      @blur="$emit('blur', $event)"
      @focus="$emit('focus', $event)"
    ></textarea>

    <div v-if="showCount && maxlength" class="form-text text-end">
      {{ characterCount }} / {{ maxlength }}
    </div>

    <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
    <div v-else-if="hint" class="form-text">{{ hint }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: { type: [String, Number], default: '' },
  label: { type: String, default: '' },
  placeholder: { type: String, default: '' },
  disabled: { type: Boolean, default: false },
  required: { type: Boolean, default: false },
  error: { type: String, default: '' },
  hint: { type: String, default: '' },
  rows: { type: [Number, String], default: 3 },
  maxlength: { type: [Number, String], default: null },
  showCount: { type: Boolean, default: false },
  size: { type: String, default: 'md' }, // sm, md, lg
  autoGrow: { type: Boolean, default: false },
  id: {
    type: String,
    default: () => `textarea-${Math.random().toString(36).substr(2, 9)}`
  }
});

defineEmits(['update:modelValue', 'blur', 'focus']);

const textareaClasses = computed(() => {
  const classes = ['form-control'];

  if (props.error) {
    classes.push('is-invalid');
  }

  if (props.size === 'sm') {
    classes.push('form-control-sm');
  } else if (props.size === 'lg') {
    classes.push('form-control-lg');
  }

  return classes.join(' ');
});

const characterCount = computed(() => {
  return String(props.modelValue || '').length;
});
</script>
