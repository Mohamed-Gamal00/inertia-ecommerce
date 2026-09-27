import { ref } from 'vue';

// Global toast state
const toasts = ref([]);

export function useToast() {
  const show = (message, variant = 'info', duration = 3000) => {
    const id = Date.now() + Math.random();
    const toast = {
      id,
      message,
      variant,
      show: true
    };

    toasts.value.push(toast);

    if (duration > 0) {
      setTimeout(() => {
        remove(id);
      }, duration);
    }

    return id;
  };

  const remove = (id) => {
    const index = toasts.value.findIndex(t => t.id === id);
    if (index > -1) {
      toasts.value.splice(index, 1);
    }
  };

  const clear = () => {
    toasts.value = [];
  };

  return {
    toasts,
    show,
    remove,
    clear,
    // Shortcuts
    success: (msg, duration) => show(msg, 'success', duration),
    error: (msg, duration) => show(msg, 'danger', duration),
    warning: (msg, duration) => show(msg, 'warning', duration),
    info: (msg, duration) => show(msg, 'info', duration),
  };
}
