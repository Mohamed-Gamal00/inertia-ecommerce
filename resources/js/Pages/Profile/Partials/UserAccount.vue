<template>
    <div>
        <h3>بيانات الحساب</h3>
        <v-form>
            <v-text-field
                label="الاسم"
                v-model="form.name"
                outlined
            ></v-text-field>
            <v-text-field
                label="رقم الهاتف"
                v-model="form.phone_number"
                outlined
            ></v-text-field>
            <v-btn color="primary" @click="updateInfo">حفظ</v-btn>
        </v-form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({ user: Object });

const form = useForm({
    name: props.user.first_name,
    phone_number: props.user.phone_number,
});

const updateInfo = () => {
    form.put(route("update_user_info"));
};
</script>
