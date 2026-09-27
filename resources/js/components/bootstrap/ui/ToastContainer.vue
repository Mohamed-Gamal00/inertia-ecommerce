<template>
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div
      v-for="toast in toasts"
      :key="toast.id"
      :class="['toast show', `bg-${toast.variant}`, 'text-white']"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
    >
      <div class="d-flex align-items-center p-3">
        <div class="toast-body flex-grow-1">
          {{ toast.message }}
        </div>
        <button
          type="button"
          class="btn-close btn-close-white me-2"
          @click="remove(toast.id)"
        ></button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useToast } from '../../../composables/useToast';

const { toasts, remove } = useToast();
</script>

<style scoped>
.toast {
  min-width: 300px;
  margin-bottom: 0.5rem;
}

.toast-body {
  word-wrap: break-word;
}
</style>
