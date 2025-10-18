<template>
  <UserProfileLayout>
    <template #default>
      <div>
        <h2 class="text-h5 mb-4">بيانات الحساب</h2>
        <v-form>
          <v-btn color="primary" @click="updateInfo">حفظ</v-btn>
        </v-form>
      </div>
    </template>
  </UserProfileLayout>
</template>

<script setup>
import UserProfileLayout from '@/Layouts/UserProfileLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ user: Object })

</script>
