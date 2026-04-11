<template>
  <v-container fluid class="py-6">
    <v-row>
      <!-- Sidebar -->
      <v-col cols="12" md="3">
        <v-card class="pa-4 rounded-xl elevation-3">
          <div class="text-center mb-4">
            <v-avatar size="80" class="mx-auto">
              <v-img :src="user?.profile_image || '/images/default-avatar.png'" />
            </v-avatar>
            <h4 class="mt-3">{{ user?.name }}</h4>
            <p class="text-grey text-sm">{{ user?.first_name }}</p>
          </div>

          <v-divider class="my-3"></v-divider>

          <v-list nav dense>
            <v-list-item
                v-for="item in menuItems"
                :key="item.route"
                class="rounded-lg mb-1"
            >
                <Link
                :href="route(item.route)"
                class="flex items-center w-full py-2 px-3 rounded-lg"
                :class="{ 'bg-primary text-white': route().current(item.route) }"
                >
                <v-icon class="mr-2">{{ item.icon }}</v-icon>
                <span>{{ item.label }}</span>
                </Link>
            </v-list-item>


            <v-list-item @click="logout" class="rounded-lg mb-1">
              <v-list-item-icon>
                <v-icon>mdi-logout</v-icon>
              </v-list-item-icon>
              <v-list-item-title>{{ t('logout') }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>

      <!-- Main content -->
      <v-col cols="12" md="9">
        <v-card class="pa-4 rounded-xl elevation-3">
          <slot />
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useLocale } from '../composables/useLocale'

const { t } = useLocale()
const page = usePage()
const user = computed(() => page.props.auth.user)

const menuItems = computed(() => [
  { label: t('profile_wishlist'), icon: 'mdi-heart', route: 'user.wishlist' },
  { label: t('profile_addresses'), icon: 'mdi-map-marker', route: 'user.addresses' },
  { label: t('profile_account'), icon: 'mdi-account', route: 'user.profile' },
])

const logout = () => {
  router.post(route('logout'))
}
</script>

<style scoped>
.v-list-item--active {
  background-color: #1976d2 !important;
  color: white !important;
}
</style>
