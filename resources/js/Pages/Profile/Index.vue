<template>
  <UserProfileLayout>
    <template #default>
      <div>
        <h2 class="text-h5 mb-4">بيانات الحساب</h2>
        <v-form>
          <v-text-field label="الاسم" v-model="form.name" outlined></v-text-field>
          <v-text-field label="رقم الهاتف" v-model="form.phone_number" outlined></v-text-field>
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

const form = useForm({
  name: props.user.first_name,
  phone_number: props.user.phone_number,
})

const updateInfo = () => {
  form.put(route('user.update_info'))
}
</script>
