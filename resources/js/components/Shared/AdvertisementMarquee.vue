<template>
  <div v-if="advertisements.length" class="marquee-bar" :dir="locale === 'ar' ? 'rtl' : 'ltr'">

    <!-- Left badge -->
    <div class="marquee-badge">
      <span class="badge-icon">🔥</span>
      <span class="badge-text">{{ locale === 'ar' ? 'عروض' : 'Deals' }}</span>
    </div>

    <!-- Scrolling viewport -->
    <div class="marquee-viewport" ref="viewport">
      <div class="marquee-track" ref="track" :style="trackStyle">

        <!-- Original set -->
        <span v-for="(ad, i) in advertisements" :key="`a-${i}`" class="marquee-item">
          <span class="marquee-star">✦</span>
          <span class="marquee-text">{{ ad.title }}</span>
          <span class="marquee-divider">|</span>
        </span>

        <!-- Duplicate set — makes the loop seamless -->
        <span v-for="(ad, i) in advertisements" :key="`b-${i}`" class="marquee-item" aria-hidden="true">
          <span class="marquee-star">✦</span>
          <span class="marquee-text">{{ ad.title }}</span>
          <span class="marquee-divider">|</span>
        </span>

      </div>
    </div>

    <!-- Shimmer -->
    <div class="marquee-shimmer" />

    <!-- Right badge -->
    <div class="marquee-badge marquee-badge-right">
      <span class="badge-icon pulse">⚡</span>
    </div>

  </div>
</template>

<script setup>
import { computed, ref, onMounted, onBeforeUnmount, nextTick, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const advertisements = computed(() => usePage().props.advertisements ?? []);
const locale         = computed(() => usePage().props.locale ?? 'ar');

const track    = ref(null);
const viewport = ref(null);

// px/second — increase for faster scroll
const SPEED = 80;

let animId   = null;
let position = 0;
let halfWidth = 0;
let lastTime  = null;
let paused    = false;

const trackStyle = ref({ transform: 'translateX(0px)', transition: 'none' });

function measure() {
  if (!track.value || !viewport.value) return;
  halfWidth = track.value.scrollWidth / 2;
  // For LTR: start at 0 so first item is at left edge
  // For RTL: start at -halfWidth so first item is at right edge
  position = locale.value === 'ar' ? -halfWidth : 0;
}

function step(ts) {
  if (!lastTime) lastTime = ts;
  const delta = (ts - lastTime) / 1000; // seconds
  lastTime = ts;

  if (!paused) {
    const dir = locale.value === 'ar' ? 1 : -1;
    position += dir * SPEED * delta;

    // Reset exactly when one full set has scrolled — zero visual jump
    if (locale.value !== 'ar' && position <= -halfWidth) position += halfWidth;
    if (locale.value === 'ar'  && position >= halfWidth)  position -= halfWidth;

    trackStyle.value = { transform: `translateX(${position}px)`, transition: 'none' };
  }

  animId = requestAnimationFrame(step);
}

function pause() { paused = true; }
function resume() { paused = false; lastTime = null; }

onMounted(async () => {
  await nextTick();
  measure();
  animId = requestAnimationFrame(step);

  track.value?.parentElement?.addEventListener('mouseenter', pause);
  track.value?.parentElement?.addEventListener('mouseleave', resume);
});

onBeforeUnmount(() => {
  cancelAnimationFrame(animId);
  track.value?.parentElement?.removeEventListener('mouseenter', pause);
  track.value?.parentElement?.removeEventListener('mouseleave', resume);
});

// Re-measure if ads change
watch(advertisements, async () => {
  await nextTick();
  measure();
});
</script>

<style scoped>
.marquee-bar {
  position: sticky;
  top: 0;
  z-index: 100;
  display: flex;
  align-items: center;
  height: 38px;
  overflow: hidden;
  background: linear-gradient(90deg, #0f0c29, #302b63, #24243e);
  background-size: 200% 200%;
  animation: gradientShift 6s ease infinite;
  box-shadow: 0 2px 12px rgba(0,0,0,0.35);
}

@keyframes gradientShift {
  0%   { background-position: 0% 50%; }
  50%  { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.marquee-badge {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 0 16px;
  height: 100%;
  background: rgba(255,255,255,0.08);
  border-inline-end: 1px solid rgba(255,255,255,0.15);
}

.marquee-badge-right {
  border-inline-end: none;
  border-inline-start: 1px solid rgba(255,255,255,0.15);
}

.badge-icon {
  font-size: 15px;
  animation: iconBounce 1.8s ease-in-out infinite;
  display: inline-block;
}

.badge-text {
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: linear-gradient(90deg, #f9d423, #ff4e50);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

@keyframes iconBounce {
  0%, 100% { transform: translateY(0) scale(1); }
  40%       { transform: translateY(-4px) scale(1.2); }
  60%       { transform: translateY(1px) scale(0.95); }
}

.pulse {
  animation: pulseGlow 1.4s ease-in-out infinite !important;
}

@keyframes pulseGlow {
  0%, 100% { transform: scale(1);    filter: brightness(1); }
  50%       { transform: scale(1.3); filter: brightness(1.6) drop-shadow(0 0 4px #ffe066); }
}

.marquee-viewport {
  flex: 1;
  overflow: hidden;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  -webkit-mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
  mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
}

.marquee-track {
  display: inline-flex;
  align-items: center;
  white-space: nowrap;
  will-change: transform;
  flex-shrink: 0;
}

.marquee-item {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 0 22px;
}

.marquee-text {
  font-size: 13px;
  font-weight: 600;
  color: rgba(255,255,255,0.92);
  letter-spacing: 0.3px;
  transition: color 0.2s;
}

.marquee-item:hover .marquee-text {
  color: #f9d423;
}

.marquee-star {
  font-size: 9px;
  color: #f9d423;
  animation: starSpin 3s linear infinite;
  display: inline-block;
}

@keyframes starSpin {
  0%   { transform: rotate(0deg) scale(1); }
  50%  { transform: rotate(180deg) scale(1.4); }
  100% { transform: rotate(360deg) scale(1); }
}

.marquee-divider {
  color: rgba(255,255,255,0.2);
  font-size: 12px;
}

.marquee-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    105deg,
    transparent 40%,
    rgba(255,255,255,0.06) 50%,
    transparent 60%
  );
  background-size: 200% 100%;
  animation: shimmerSweep 3.5s linear infinite;
  pointer-events: none;
}

@keyframes shimmerSweep {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
</style>
