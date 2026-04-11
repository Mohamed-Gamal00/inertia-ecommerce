<template>
    <div>
        <!-- Header -->
        <div class="d-flex align-center justify-space-between mb-5">
            <div>
                <p class="text-grey-darken-1 mt-1" style="font-size:13px">
                    {{ addresses.length }} {{ t('profile_address_label') }}
                </p>
            </div>
            <v-btn color="primary" rounded="lg" style="text-transform:none" prepend-icon="mdi-plus" @click="openAdd">
                {{ t('add_new_address') }}
            </v-btn>
        </div>

        <!-- Address cards -->
        <v-row v-if="addresses.length">
            <v-col v-for="addr in addresses" :key="addr.id" cols="12" sm="6">
                <v-card
                    rounded="xl"
                    :elevation="addr.main_address ? 4 : 1"
                    class="address-card"
                    :class="{ 'address-card--main': addr.main_address }"
                >
                    <!-- Top bar -->
                    <div class="address-card-top">
                        <div class="d-flex align-center" style="gap:8px">
                            <v-icon size="18" :color="addr.main_address ? 'primary' : 'grey'">
                                mdi-map-marker{{ addr.main_address ? '' : '-outline' }}
                            </v-icon>
                            <span class="font-weight-bold" style="font-size:14px">
                                {{ addr.address_title || t('address_title') }}
                            </span>
                        </div>
                        <v-chip v-if="addr.main_address" color="primary" size="x-small" variant="flat">
                            {{ t('main_address') }}
                        </v-chip>
                    </div>

                    <v-divider />

                    <!-- Body -->
                    <div class="pa-4">
                        <div class="info-row">
                            <v-icon size="15" color="grey">mdi-account-outline</v-icon>
                            <span>{{ addr.first_name }} {{ addr.family_name }}</span>
                        </div>
                        <div class="info-row">
                            <v-icon size="15" color="grey">mdi-phone-outline</v-icon>
                            <span dir="ltr">{{ addr.phone_number }}</span>
                        </div>
                        <div class="info-row">
                            <v-icon size="15" color="grey">mdi-home-outline</v-icon>
                            <span>{{ addr.address }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="address-card-actions">
                        <v-btn
                            v-if="!addr.main_address"
                            size="small"
                            variant="text"
                            color="primary"
                            style="text-transform:none; font-size:12px"
                            prepend-icon="mdi-star-outline"
                            @click="setMain(addr.id)"
                        >
                            {{ t('set_main_address') }}
                        </v-btn>
                        <v-spacer v-if="!addr.main_address" />
                        <v-btn icon size="small" variant="text" color="grey" @click="openEdit(addr)">
                            <v-icon size="18">mdi-pencil-outline</v-icon>
                        </v-btn>
                        <v-btn icon size="small" variant="text" color="error" @click="remove(addr.id)">
                            <v-icon size="18">mdi-delete-outline</v-icon>
                        </v-btn>
                    </div>
                </v-card>
            </v-col>
        </v-row>

        <!-- Empty state -->
        <div v-else class="empty-state">
            <v-icon size="64" color="grey-lighten-1">mdi-map-marker-off-outline</v-icon>
            <p class="mt-3 text-grey-darken-1" style="font-size:15px">{{ t('no_addresses') }}</p>
            <v-btn color="primary" rounded="lg" class="mt-3" style="text-transform:none" @click="openAdd">
                {{ t('add_first_address') }}
            </v-btn>
        </div>

        <!-- Add / Edit Dialog -->
        <v-dialog v-model="dialog" max-width="520" persistent>
            <v-card rounded="xl" class="pa-2">
                <v-card-title class="d-flex align-center justify-space-between pa-4 pb-2">
                    <span class="font-weight-bold" style="font-size:16px">
                        {{ editing ? t('edit_address') : t('add_new_address') }}
                    </span>
                    <v-btn icon size="small" variant="text" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-divider />

                <v-card-text class="pa-4">
                    <v-form @submit.prevent="save">
                        <v-row dense>
                            <v-col cols="12">
                                <label class="field-label">{{ t('address_name') }}</label>
                                <v-text-field
                                    v-model="form.address_title"
                                    :placeholder="t('address_name_placeholder')"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    bg-color="grey-lighten-5"
                                    hide-details="auto"
                                    class="mt-1 mb-3"
                                />
                            </v-col>
                            <v-col cols="6">
                                <label class="field-label">{{ t('first_name') }}</label>
                                <v-text-field
                                    v-model="form.first_name"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    bg-color="grey-lighten-5"
                                    hide-details="auto"
                                    class="mt-1 mb-3"
                                />
                            </v-col>
                            <v-col cols="6">
                                <label class="field-label">{{ t('last_name') }}</label>
                                <v-text-field
                                    v-model="form.family_name"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    bg-color="grey-lighten-5"
                                    hide-details="auto"
                                    class="mt-1 mb-3"
                                />
                            </v-col>
                            <v-col cols="12">
                                <label class="field-label">{{ t('phone') }}</label>
                                <v-text-field
                                    v-model="form.phone_number"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    bg-color="grey-lighten-5"
                                    hide-details="auto"
                                    class="mt-1 mb-3"
                                    prepend-inner-icon="mdi-phone-outline"
                                    dir="ltr"
                                />
                            </v-col>
                            <v-col cols="12">
                                <label class="field-label">{{ t('address_detail') }}</label>
                                <v-textarea
                                    v-model="form.address"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    bg-color="grey-lighten-5"
                                    hide-details="auto"
                                    rows="2"
                                    class="mt-1 mb-3"
                                    prepend-inner-icon="mdi-home-outline"
                                />
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>

                <v-card-actions class="pa-4 pt-0">
                    <v-btn variant="text" rounded="lg" style="text-transform:none" @click="close">{{ t('cancel') }}</v-btn>
                    <v-spacer />
                    <v-btn
                        color="primary"
                        rounded="lg"
                        style="text-transform:none; min-width:120px"
                        :loading="saving"
                        @click="save"
                    >
                        {{ editing ? t('update') : t('save') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Confirm delete -->
        <v-dialog v-model="confirmDelete" max-width="360">
            <v-card rounded="xl" class="pa-4 text-center">
                <v-icon size="48" color="error" class="mb-3">mdi-delete-alert-outline</v-icon>
                <p class="font-weight-bold mb-1">{{ t('delete_address') }}</p>
                <p class="text-grey-darken-1 text-caption mb-4">{{ t('delete_address_confirm') }}</p>
                <div class="d-flex justify-center" style="gap:12px">
                    <v-btn variant="text" rounded="lg" style="text-transform:none" @click="confirmDelete = false">{{ t('cancel') }}</v-btn>
                    <v-btn color="error" rounded="lg" style="text-transform:none" :loading="deleting" @click="confirmRemove">{{ t('delete') }}</v-btn>
                </div>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useLocale } from '../../../composables/useLocale';

const { t } = useLocale();
const props = defineProps({ user: { type: Object, required: true } });

const addresses = computed(() => props.user?.addresses ?? []);

const dialog        = ref(false);
const editing       = ref(null);
const saving        = ref(false);
const confirmDelete = ref(false);
const deleting      = ref(false);
const deleteId      = ref(null);

const emptyForm = () => ({ address_title: '', first_name: '', family_name: '', phone_number: '', address: '' });
const form = ref(emptyForm());

function openAdd() {
    editing.value = null;
    form.value = emptyForm();
    dialog.value = true;
}

function openEdit(addr) {
    editing.value = addr;
    form.value = { ...addr };
    dialog.value = true;
}

function close() {
    dialog.value = false;
    editing.value = null;
}

function save() {
    saving.value = true;
    if (editing.value) {
        router.put(route('user.addresses.update', editing.value.id), form.value, {
            onFinish: () => { saving.value = false; close(); },
        });
    } else {
        router.post(route('user.addresses.store'), form.value, {
            onFinish: () => { saving.value = false; close(); },
        });
    }
}

function remove(id) {
    deleteId.value = id;
    confirmDelete.value = true;
}

function confirmRemove() {
    deleting.value = true;
    router.delete(route('user.addresses.destroy', deleteId.value), {
        onFinish: () => { deleting.value = false; confirmDelete.value = false; },
    });
}

function setMain(id) {
    router.post(route('user.addresses.setMain', id));
}
</script>

<style scoped>
.address-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid #e5e7eb;
}

.address-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
}

.address-card--main {
    border: 1.5px solid #3949ab;
}

.address-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
}

.address-card-actions {
    display: flex;
    align-items: center;
    padding: 4px 8px 8px;
    border-top: 1px solid #f3f4f6;
}

.info-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #4b5563;
    margin-bottom: 6px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.field-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}
</style>
