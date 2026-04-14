<template>
    <a
        v-if="vendor && vendor.store_slug"
        :href="`/store/${vendor.store_slug}`"
        class="vendor-badge"
        :style="`background: ${vendor.banner_color || '#1a237e'}15; color: ${vendor.banner_color || '#1a237e'}`"
        @click.stop
    >
        <v-icon size="14" :color="vendor.banner_color || '#1a237e'">mdi-store</v-icon>
        <span>{{ vendor.name }}</span>
    </a>
</template>

<script setup>
defineProps({
    vendor: {
        type: Object,
        required: true
    }
});
</script>

<style scoped>
.vendor-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.vendor-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    opacity: 0.9;
}
</style>
