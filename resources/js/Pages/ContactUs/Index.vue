<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">{{ t('contact_title') }}</h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.75); font-size:14px">{{ t('contact_subtitle') }}</p>
        </div>

        <div style="max-width:800px; margin:32px auto; padding:0 16px">
            <v-row>
                <!-- Contact info -->
                <v-col cols="12" md="4">
                    <v-card rounded="xl" elevation="1" class="pa-5 mb-4">
                        <div v-for="info in contactInfo" :key="info.label" class="d-flex align-center mb-4">
                            <div style="width:44px; height:44px; background:#e8eaf6; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0">
                                <v-icon color="primary" size="20">{{ info.icon }}</v-icon>
                            </div>
                            <div class="ms-3">
                                <div style="font-size:11px; color:#9ca3af">{{ info.label }}</div>
                                <div style="font-size:13px; font-weight:600; color:#111827">{{ info.value }}</div>
                            </div>
                        </div>
                    </v-card>
                </v-col>

                <!-- Form -->
                <v-col cols="12" md="8">
                    <v-card rounded="xl" elevation="1" class="pa-5">
                        <v-alert v-if="success" type="success" variant="tonal" rounded="lg" class="mb-4" density="compact">{{ success }}</v-alert>

                        <v-form @submit.prevent="submit">
                            <v-row dense>
                                <v-col cols="12">
                                    <label class="field-label">{{ t('contact_full_name') }}</label>
                                    <v-text-field v-model="form.full_name" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" class="mt-1 mb-3" :error-messages="form.errors.full_name" />
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <label class="field-label">{{ t('email') }}</label>
                                    <v-text-field v-model="form.contact_email" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" class="mt-1 mb-3" dir="ltr" :error-messages="form.errors.contact_email" />
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <label class="field-label">{{ t('phone') }}</label>
                                    <v-text-field v-model="form.phone_number" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" class="mt-1 mb-3" dir="ltr" :error-messages="form.errors.phone_number" />
                                </v-col>
                                <v-col cols="12">
                                    <label class="field-label">{{ t('contact_message') }}</label>
                                    <v-textarea v-model="form.text" variant="outlined" density="comfortable" rounded="lg" bg-color="grey-lighten-5" hide-details="auto" rows="4" class="mt-1 mb-4" :error-messages="form.errors.text" />
                                </v-col>
                            </v-row>
                            <v-btn type="submit" color="primary" block height="48" rounded="lg" style="text-transform:none; font-size:15px; font-weight:600" :loading="form.processing">
                                {{ t('contact_send') }}
                            </v-btn>
                        </v-form>
                    </v-card>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';
const { t } = useLocale();

const form = useForm({ full_name: '', contact_email: '', phone_number: '', text: '' });
const success = computed(() => usePage().props.flash?.success);

const contactInfo = computed(() => [
    { icon: 'mdi-phone-outline',      label: t('contact_phone_label'),  value: '+966 50 000 0000' },
    { icon: 'mdi-email-outline',      label: t('contact_email_label'),  value: 'info@store.com' },
    { icon: 'mdi-map-marker-outline', label: t('contact_address_label'), value: 'الرياض، المملكة العربية السعودية' },
    { icon: 'mdi-clock-outline',      label: t('contact_hours_label'),  value: 'السبت - الخميس، 9ص - 6م' },
]);

const submit = () => form.post('/contact-us');
</script>

<style scoped>
.field-label { font-size:13px; font-weight:600; color:#374151; }
</style>
