<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">{{ t('rep_title') }}</h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.75); font-size:14px">{{ t('rep_subtitle') }}</p>
        </div>

        <div style="max-width:600px; margin:32px auto; padding:0 16px">
            <v-card rounded="xl" elevation="1" class="pa-6">
                <v-alert v-if="success" type="success" variant="tonal" rounded="lg" class="mb-4" density="compact">{{ success }}</v-alert>

                <p class="text-grey-darken-1 mb-5" style="font-size:14px; line-height:1.8">{{ t('rep_desc') }}</p>
                <v-form @submit.prevent="submit">
                    <label class="field-label">{{ t('rep_name') }}</label>
                    <v-text-field v-model="form.name" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" class="mt-1 mb-3" :error-messages="form.errors.name" />
                    <label class="field-label">{{ t('rep_phone') }}</label>
                    <v-text-field v-model="form.phone" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" class="mt-1 mb-3" dir="ltr" :error-messages="form.errors.phone" />
                    <label class="field-label">{{ t('rep_details') }}</label>
                    <v-textarea v-model="form.description" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" rows="4" class="mt-1 mb-5" :error-messages="form.errors.description" />
                    <v-btn type="submit" color="primary" block height="48" rounded="lg" style="text-transform:none; font-size:15px; font-weight:600" :loading="form.processing">{{ t('rep_send') }}</v-btn>
                </v-form>
            </v-card>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';
const { t } = useLocale();
const form = useForm({ name: '', phone: '', description: '' });
const success = computed(() => usePage().props.flash?.success);
const submit = () => form.post('/representative-order');
</script>

<style scoped>
.field-label { font-size:13px; font-weight:600; color:#374151; }
</style>
