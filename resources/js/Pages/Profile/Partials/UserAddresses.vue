<template>
  <div>
    <div class="d-flex justify-space-between align-center mb-4">
      <h3 class="text-h5">عناويني</h3>
      <v-btn color="primary" @click="showAddDialog = true">
        <v-icon start>mdi-plus</v-icon> إضافة عنوان جديد
      </v-btn>
    </div>

    <!-- قائمة العناوين -->
    <v-row v-if="addresses.length">
      <v-col
        v-for="address in addresses"
        :key="address.id"
        cols="12"
        sm="6"
        md="4"
      >
        <v-card class="pa-3 rounded-xl" :elevation="address.main_address ? 8 : 2">
          <div class="d-flex justify-space-between align-center">
            <strong>{{ address.address_title }}</strong>

            <v-chip
              v-if="address.main_address"
              color="green"
              text-color="white"
              size="small"
            >
              العنوان الرئيسي
            </v-chip>
          </div>

          <p class="mt-2">{{ address.address }}</p>
          <p class="text-caption text-muted">
            {{ address.first_name }} {{ address.family_name }} - {{ address.phone_number }}
          </p>

          <v-divider class="my-2"></v-divider>

          <div class="d-flex justify-space-between">
            <v-btn size="small" color="primary" variant="tonal" @click="editAddress(address)">
              <v-icon start>mdi-pencil</v-icon> تعديل
            </v-btn>

            <v-btn
              size="small"
              color="error"
              variant="tonal"
              @click="deleteAddress(address.id)"
            >
              <v-icon start>mdi-delete</v-icon> حذف
            </v-btn>
          </div>

          <v-btn
            v-if="!address.main_address"
            class="mt-2"
            color="success"
            block
            variant="tonal"
            @click="setMainAddress(address.id)"
          >
            <v-icon start>mdi-star</v-icon>
            تعيين كعنوان رئيسي
          </v-btn>
        </v-card>
      </v-col>
    </v-row>

    <v-alert
      v-else
      type="info"
      text="لا توجد عناوين بعد. أضف عنوانك الأول!"
      class="text-center mt-6"
    />

    <!-- نافذة إضافة / تعديل العنوان -->
    <v-dialog v-model="showAddDialog" max-width="600px" persistent>
      <v-card class="pa-4 rounded-xl">
        <h3 class="mb-4">
          {{ editingAddress ? 'تعديل العنوان' : 'إضافة عنوان جديد' }}
        </h3>

        <v-form @submit.prevent="saveAddress">
          <v-text-field
            v-model="form.address_title"
            label="اسم العنوان"
            required
          ></v-text-field>

          <v-text-field
            v-model="form.first_name"
            label="الاسم الأول"
            required
          ></v-text-field>

          <v-text-field
            v-model="form.family_name"
            label="اسم العائلة"
            required
          ></v-text-field>

          <v-text-field
            v-model="form.phone_number"
            label="رقم الهاتف"
            required
          ></v-text-field>

          <v-text-field
            v-model="form.address"
            label="العنوان بالتفصيل"
            required
          ></v-text-field>

          <div class="d-flex justify-end mt-4">
            <v-btn text @click="closeDialog">إلغاء</v-btn>
            <v-btn color="primary" type="submit">
              {{ editingAddress ? 'تحديث' : 'حفظ' }}
            </v-btn>
          </div>
        </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const addresses = computed(() => props.user?.addresses ?? []);

// popup states
const showAddDialog = ref(false);
const editingAddress = ref(null);

// form data
const form = ref({
  address_title: "",
  first_name: "",
  family_name: "",
  phone_number: "",
  address: "",
});

// functions
const closeDialog = () => {
  showAddDialog.value = false;
  editingAddress.value = null;
  Object.assign(form.value, {
    address_title: "",
    first_name: "",
    family_name: "",
    phone_number: "",
    address: "",
  });
};

const editAddress = (address) => {
  editingAddress.value = address;
  Object.assign(form.value, address);
  showAddDialog.value = true;
};

const saveAddress = () => {
  if (editingAddress.value) {
    // تحديث
    router.put(route("user.addresses.update", editingAddress.value.id), form.value, {
      onSuccess: closeDialog,
    });
  } else {
    // إضافة جديدة
    router.post(route("user.addresses.store"), form.value, {
      onSuccess: closeDialog,
    });
  }
};

const deleteAddress = (id) => {
  if (confirm("هل أنت متأكد من حذف هذا العنوان؟")) {
    router.delete(route("user.addresses.destroy", id));
  }
};

const setMainAddress = (id) => {
  router.post(route("user.addresses.setMain", id));
};
</script>

<style scoped>
.v-card {
  transition: all 0.3s;
}
.v-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
