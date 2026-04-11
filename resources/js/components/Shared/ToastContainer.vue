<template>
    <div class="toast-container">
        <TransitionGroup name="toast">
            <div
                v-for="toast in toasts"
                :key="toast.id"
                class="toast"
                :class="`toast--${toast.type}`"
            >
                <v-icon size="18" class="me-2">
                    {{ toast.type === 'success' ? 'mdi-check-circle' : toast.type === 'error' ? 'mdi-alert-circle' : 'mdi-information' }}
                </v-icon>
                <span>{{ toast.message }}</span>
            </div>
        </TransitionGroup>
    </div>
</template>

<script setup>
import { useToast } from '../../composables/useToast';
const { toasts } = useToast();
</script>

<style scoped>
.toast-container {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
}

.toast {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 10px;
    padding: 12px 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    font-size: 13px;
    font-weight: 600;
    min-width: 260px;
    border-left: 3px solid;
}

.toast--success { border-color: #16a34a; color: #166534; }
.toast--error   { border-color: #ef4444; color: #991b1b; }
.toast--info    { border-color: #3b82f6; color: #1e40af; }

.toast-enter-active, .toast-leave-active { transition: all 0.3s ease; }
.toast-enter-from { opacity: 0; transform: translateX(100px); }
.toast-leave-to   { opacity: 0; transform: translateX(100px) scale(0.8); }
</style>
