<template>
  <v-container fluid class="py-6">
    <v-row>
      <!-- Sidebar Tabs -->
      <v-col cols="12" md="3">
        <v-card class="pa-4 rounded-xl elevation-3">
          <div class="text-center mb-4">
            <v-avatar size="80" class="mx-auto">
              <v-img :src="user?.image_url" />
            </v-avatar>
        <h4 class="mt-3">مرحبا {{ user?.first_name }}</h4>
          </div>

          <v-divider class="my-3"></v-divider>

          <v-tabs
            v-model="tab"
            direction="vertical"
            color="primary"
            class="w-100"
          >
            <v-tab value="account" prepend-icon="mdi-account">الحساب</v-tab>
            <v-tab value="wishlist" prepend-icon="mdi-heart">المفضلة</v-tab>
            <v-tab value="orders" prepend-icon="mdi-cube">الطلبات</v-tab>
            <v-tab value="returns" prepend-icon="mdi-undo-variant">المرتجعات</v-tab>
            <v-tab value="addresses" prepend-icon="mdi-map-marker">العناوين</v-tab>
          </v-tabs>

          <v-divider class="my-3"></v-divider>

          <v-btn color="error" block @click="logout">
            <v-icon start>mdi-logout</v-icon>
              تسجيل خروج
          </v-btn>
        </v-card>
      </v-col>

      <!-- Main Content -->
      <v-col cols="12" md="9">
        <v-card class="pa-4 rounded-xl elevation-3">
          <v-tabs-window v-model="tab">

            <v-tabs-window-item value="account">
              <UserAccount :user="user" />
            </v-tabs-window-item>

            <v-tabs-window-item value="wishlist">
              <UserWishlist :user="user" />
            </v-tabs-window-item>

            <v-tabs-window-item value="orders">
              <UserOrders :user="user" />
            </v-tabs-window-item>

            <v-tabs-window-item value="returns">
              <UserReturns :user="user" />
            </v-tabs-window-item>

            <v-tabs-window-item value="addresses">
              <UserAddresses :user="user" />
            </v-tabs-window-item>


          </v-tabs-window>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed, onMounted,watch } from 'vue'

import { usePage, router } from '@inertiajs/vue3'

import UserWishlist from './Partials/UserWishlist.vue'
import UserOrders from './Partials/UserOrders.vue'
import UserAddresses from './Partials/UserAddresses.vue'
import UserAccount from './Partials/UserAccount.vue'
import UserReturns from './Partials/UserReturns.vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const tab = ref('account')

onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search)
  const initialTab = urlParams.get('tab')
  if (initialTab) tab.value = initialTab
})

watch(tab, (newTab) => {
  const url = new URL(window.location.href)
  url.searchParams.set('tab', newTab)
  window.history.replaceState({}, '', url)
})
const logout = () => router.post(route('logout'))
</script>
