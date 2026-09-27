<template>
  <teleport to="body">
    <div
      ref="modalElement"
      :class="['modal fade', { show: modelValue }]"
      :style="{ display: modelValue ? 'block' : 'none' }"
      tabindex="-1"
      @click.self="handleBackdropClick"
    >
      <div :class="modalDialogClasses">
        <div class="modal-content">
          <div v-if="$slots.header || title" class="modal-header">
            <h5 class="modal-title">
              <slot name="header">{{ title }}</slot>
            </h5>
            <button
              v-if="!hideClose"
              type="button"
              class="btn-close"
              @click="close"
            ></button>
          </div>

          <div class="modal-body">
            <slot />
          </div>

          <div v-if="$slots.footer" class="modal-footer">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </div>

    <!-- Backdrop -->
    <div
      v-if="modelValue"
      class="modal-backdrop fade show"
    ></div>
  </teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: { type: Boolean, default: false },
  title: { type: String, default: '' },
  size: { type: String, default: 'md' }, // sm, md, lg, xl
  centered: { type: Boolean, default: false },
  scrollable: { type: Boolean, default: false },
  hideClose: { type: Boolean, default: false },
  backdrop: { type: [Boolean, String], default: true } // true, false, 'static'
});

const emit = defineEmits(['update:modelValue', 'show', 'hide']);

const modalElement = ref(null);

const modalDialogClasses = computed(() => {
  const classes = ['modal-dialog'];

  if (props.size !== 'md') {
    classes.push(`modal-${props.size}`);
  }

  if (props.centered) {
    classes.push('modal-dialog-centered');
  }

  if (props.scrollable) {
    classes.push('modal-dialog-scrollable');
  }

  return classes.join(' ');
});

const close = () => {
  emit('update:modelValue', false);
  emit('hide');
};

const handleBackdropClick = () => {
  if (props.backdrop === true) {
    close();
  }
};

const handleEscape = (e) => {
  if (e.key === 'Escape' && props.modelValue && props.backdrop !== 'static') {
    close();
  }
};

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    document.body.classList.add('modal-open');
    emit('show');
  } else {
    document.body.classList.remove('modal-open');
  }
});

onMounted(() => {
  document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape);
  document.body.classList.remove('modal-open');
});
</script>
