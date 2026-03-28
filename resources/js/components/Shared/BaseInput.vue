<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: [String, Number, Boolean, Array, Object],
  label: String,
  type: {
    type: String,
    default: 'text', // text, email, password, number, select
  },
  items: Array, // في حالة select
  itemTitle: {
    type: String,
    default: 'name',
  },
  itemValue: {
    type: String,
    default: 'id',
  },
  outlined: {
    type: Boolean,
    default: true,
  },
  dense: {
    type: Boolean,
    default: true,
  },
  error: {
    type: [String, Array],
    default: '',
  },
})

// v-model
const emit = defineEmits(['update:modelValue'])
const model = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
})
</script>

<template>
  <div>
    <!-- في حالة انه select -->
    <v-select
      v-if="type === 'select'"
      v-model="model"
      :items="items"
      :item-title="itemTitle"
      :item-value="itemValue"
      :label="label"
      :outlined="outlined"
      :dense="dense"
      :error="!!error"
      :error-messages="error"
    />

    <!-- باقي الأنواع -->
    <v-text-field
      v-else
      v-model="model"
      :type="type"
      :label="label"
      :outlined="outlined"
      :dense="dense"
      :error="!!error"
      :error-messages="error"
    />
  </div>
</template>
