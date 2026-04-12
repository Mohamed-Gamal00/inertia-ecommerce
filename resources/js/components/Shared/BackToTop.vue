<template>
    <Transition name="btt">
        <button v-if="visible" class="btt-btn" @click="scrollTop" aria-label="العودة للأعلى">
            <v-icon size="20">mdi-chevron-up</v-icon>
        </button>
    </Transition>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const visible = ref(false);

function onScroll() { visible.value = window.scrollY > 400; }
function scrollTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>

<style scoped>
.btt-btn {
    position: fixed;
    bottom: 28px;
    left: 20px;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #1a237e;
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(26,35,126,0.35);
    z-index: 500;
    transition: transform 0.2s, opacity 0.2s;
}

.btt-btn:hover { transform: translateY(-3px); }

.btt-enter-active, .btt-leave-active { transition: opacity 0.25s, transform 0.25s; }
.btt-enter-from, .btt-leave-to { opacity: 0; transform: translateY(12px); }
</style>
