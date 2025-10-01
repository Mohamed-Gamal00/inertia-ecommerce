<template>
    <div>
        <div class="layout">
            <v-layout class="position-relative">
<!--                <CartDrawer />-->
                <v-main style="padding-top: 160px">
                    <slot></slot>
                </v-main>
                <AppHeader />
<!--                <FixedNav />-->
                <AppFooter />
            </v-layout>
        </div>
    </div>
</template>
<script setup>
import AppHeader from '../components/layout/AppHeader.vue'
import AppFooter from '../components/layout/AppFooter.vue'
</script>
