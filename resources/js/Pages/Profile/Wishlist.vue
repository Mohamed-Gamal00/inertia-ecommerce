<template>
  <UserProfileLayout>
    <template #default>
      <div>
        <h2 class="text-h5 mb-4">المفضلة</h2>
      </div>
    </template>
  </UserProfileLayout>
</template>

<script setup>
import UserProfileLayout from '@/Layouts/UserProfileLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ user: Object })
</script>
