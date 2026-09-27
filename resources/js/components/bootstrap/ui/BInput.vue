<template>
  <div class="mb-3">
    <label v-if="label" :for="id" class="form-label">
      {{ label }}
      <span v-if="required" class="text-danger">*</span>
    </label>

    <div v-if="prependIcon || appendIcon || $slots.prepend || $slots.append" class="input-group">
      <span v-if="prependIcon" class="input-group-text">
        <i :class="`bi bi-${prependIcon}`"></i>
      </span>
      <slot name="prepend"></slot>

      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :required="required"
        :class="inputClasses"
        @input="$emit('update:modelValue', $event.target.value)"
        @blur="$emit('blur', $event)"
        @focus="$emit('focus', $event)"
      >

      <span v-if="appendIcon" class="input-group-text">
        <i :class="`bi bi-${appendIcon}`"></i>
      </span>
      <slot name="append"></slot>
    </div>

    <input
      v-else
      :id="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :required="required"
      :class="inputClasses"
      @input="$emit('update:modelValue', $event.target.value)"
      @blur="$emit('blur', $event)"
      @focus="$emit('focus', $event)"
    >

    <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
    <div v-else-if="hint" class="form-text">{{ hint }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: { type: [String, Number], default: '' },
  label: { type: String, default: '' },
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  disabled: { type: Boolean, default: false },
  required: { type: Boolean, default: false },
  error: { type: String, default: '' },
  hint: { type: String, default: '' },
  prependIcon: { type: String, default: '' },
  appendIcon: { type: String, default: '' },
  size: { type: String, default: 'md' }, // sm, md, lg
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substr(2, 9)}`
  }
});

defineEmits(['update:modelValue', 'blur', 'focus']);

const inputClasses = computed(() => {
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
</script>
