<template>
    <div>
        <v-row>
            <v-col cols="12" md="6">
                <label class="field-label">الاسم الأول</label>
                <v-text-field
                    v-model="form.first_name"
                    variant="outlined"
                    density="comfortable"
                    rounded="lg"
                    bg-color="grey-lighten-5"
                    hide-details="auto"
                    class="mt-1 mb-4"
                    :error-messages="form.errors.first_name"
                />
            </v-col>
            <v-col cols="12" md="6">
                <label class="field-label">اسم العائلة</label>
                <v-text-field
                    v-model="form.family_name"
                    variant="outlined"
                    density="comfortable"
                    rounded="lg"
                    bg-color="grey-lighten-5"
                    hide-details="auto"
                    class="mt-1 mb-4"
                />
            </v-col>
            <v-col cols="12" md="6">
                <label class="field-label">رقم الهاتف</label>
                <v-text-field
                    v-model="form.phone_number"
                    variant="outlined"
                    density="comfortable"
                    rounded="lg"
                    bg-color="grey-lighten-5"
                    hide-details="auto"
                    class="mt-1 mb-4"
                    prepend-inner-icon="mdi-phone-outline"
                    dir="ltr"
                />
            </v-col>
            <v-col cols="12" md="6">
                <label class="field-label">البريد الإلكتروني</label>
                <v-text-field
                    :model-value="props.user.email"
                    variant="outlined"
                    density="comfortable"
                    rounded="lg"
                    bg-color="grey-lighten-5"
                    hide-details
                    class="mt-1 mb-4"
                    prepend-inner-icon="mdi-email-outline"
                    dir="ltr"
                    readonly
                />
            </v-col>
        </v-row>

        <v-divider class="mb-5" />

        <div class="d-flex justify-end">
            <v-btn
                color="primary"
                rounded="lg"
                height="44"
                style="text-transform:none; min-width:140px"
                :loading="form.processing"
                @click="updateInfo"
            >
                <v-icon start>mdi-content-save-outline</v-icon>
                حفظ التغييرات
            </v-btn>
        </div>

        <v-snackbar v-model="snackbar" color="success" location="top right" timeout="2500">
            تم تحديث البيانات بنجاح
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ user: Object });

const form = useForm({
    first_name:   props.user.first_name,
    family_name:  props.user.family_name,
    phone_number: props.user.phone_number,
});

const snackbar = ref(false);

const updateInfo = () => {
    form.put(route('update_user_info'), {
        onSuccess: () => { snackbar.value = true; },
    });
};
</script>

<style scoped>
.field-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}
</style>
