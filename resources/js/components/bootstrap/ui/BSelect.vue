<template>
  <div class="mb-3">
    <label v-if="label" :for="id" class="form-label">
      {{ label }}
      <span v-if="required" class="text-danger">*</span>
    </label>

    <select
      :id="id"
      :value="modelValue"
      :disabled="disabled"
      :required="required"
      :class="selectClasses"
      :multiple="multiple"
      @change="handleChange"
    >
      <option v-if="placeholder && !multiple" value="" disabled>
        {{ placeholder }}
      </option>

      <option
        v-for="option in options"
        :key="getOptionValue(option)"
        :value="getOptionValue(option)"
        :disabled="option.disabled"
      >
        {{ getOptionLabel(option) }}
      </option>
    </select>

    <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
    <div v-else-if="hint" class="form-text">{{ hint }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: { type: [String, Number, Array], default: '' },
  label: { type: String, default: '' },
  placeholder: { type: String, default: 'Select an option' },
  options: { type: Array, required: true }, // Array of objects {label, value} or primitive values
  disabled: { type: Boolean, default: false },
  required: { type: Boolean, default: false },
  multiple: { type: Boolean, default: false },
  error: { type: String, default: '' },
  hint: { type: String, default: '' },
  size: { type: String, default: 'md' }, // sm, md, lg
  valueKey: { type: String, default: 'value' },
  labelKey: { type: String, default: 'label' },
  id: {
    type: String,
    default: () => `select-${Math.random().toString(36).substr(2, 9)}`
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const selectClasses = computed(() => {
  const classes = ['form-select'];

  if (props.error) {
    classes.push('is-invalid');
  }

  if (props.size === 'sm') {
    classes.push('form-select-sm');
  } else if (props.size === 'lg') {
    classes.push('form-select-lg');
  }

  return classes.join(' ');
});

const getOptionValue = (option) => {
  if (typeof option === 'object' && option !== null) {
    return option[props.valueKey];
  }
  return option;
};

const getOptionLabel = (option) => {
  if (typeof option === 'object' && option !== null) {
    return option[props.labelKey];
  }
  return option;
};

const handleChange = (event) => {
  let value;

  if (props.multiple) {
    value = Array.from(event.target.selectedOptions).map(opt => opt.value);
  } else {
    value = event.target.value;
  }

  emit('update:modelValue', value);
  emit('change', value);
};
</script>
