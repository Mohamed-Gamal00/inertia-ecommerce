<template>
  <div>
    <h3 class="mb-2">طلباتي</h3>
    <p class="mb-6 text-gray-600">قائمة الطلبات السابقة والجارية.</p>

    <!-- جدول الطلبات -->
    <v-table v-if="orders.length" class="elevation-2 rounded-lg">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">رقم الطلب</th>
          <th class="text-center">التاريخ</th>
          <th class="text-center">الحالة</th>
          <th class="text-center">الإجمالي</th>
          <th class="text-center">الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(order, index) in orders" :key="order.id">
          <td class="text-center">{{ index + 1 }}</td>
          <td class="text-center">{{ order.number }}</td>
          <td class="text-center">{{ formatDate(order.created_at) }}</td>
          <td class="text-center">
            <v-chip :color="statusColor(order.status)" size="small" label>
              {{ statusText(order.status) }}
            </v-chip>
          </td>
          <td class="text-center">{{ order.total_price }} ر.س</td>
          <td class="text-center">
            <v-btn size="small" color="primary" variant="tonal" @click="viewOrder(order)">
              عرض التفاصيل
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>

    <!-- لو مفيش طلبات -->
    <div v-else class="text-center py-10">
      <v-icon color="grey" size="48">mdi-cube-outline</v-icon>
      <p class="mt-3 text-gray-500">لا توجد طلبات حالياً.</p>
    </div>

    <!-- مودال تفاصيل الطلب -->
    <v-dialog v-model="dialog" max-width="700px">
      <v-card>
        <v-card-title class="text-h6">تفاصيل الطلب رقم {{ selectedOrder?.number }}</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <p><strong>التاريخ:</strong> {{ formatDate(selectedOrder?.created_at) }}</p>
          <p><strong>الحالة:</strong>
            <v-chip :color="statusColor(selectedOrder?.status)" size="small">
              {{ statusText(selectedOrder?.status) }}
            </v-chip>
          </p>

          <v-divider class="my-3"></v-divider>

          <h4 class="text-h6 mb-2">المنتجات</h4>

          <v-table>
            <thead>
              <tr>
                <th class="text-center">المنتج</th>
                <th class="text-center">الكمية</th>
                <th class="text-center">السعر</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in selectedOrder?.order_items || []" :key="item.id">
                <td class="text-center">{{ item.product_name }}</td>
                <td class="text-center">{{ item.quantity }}</td>
                <td class="text-center">{{ item.price }} ر.س</td>
              </tr>
            </tbody>
          </v-table>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" text @click="dialog = false">إغلاق</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const orders = computed(() => props.user.orders || [])
const dialog = ref(false)
const selectedOrder = ref(null)

const viewOrder = (order) => {
  selectedOrder.value = order
  dialog.value = true
}

// دوال الحالة والتاريخ
const statusText = (status) => {
  switch (status) {
    case 'pending': return 'قيد الانتظار'
    case 'approved': return 'تمت الموافقة'
    case 'in_progress': return 'قيد التنفيذ'
    case 'completed': return 'مكتمل'
    case 'rejected': return 'مرفوض'
    default: return status
  }
}

const statusColor = (status) => {
  switch (status) {
    case 'pending': return 'orange'
    case 'approved': return 'blue'
    case 'in_progress': return 'amber'
    case 'completed': return 'green'
    case 'rejected': return 'red'
    default: return 'grey'
  }
}

const formatDate = (dateStr) => {
  if (!dateStr) return '-'
  const date = new Date(dateStr)
  return date.toLocaleDateString('ar-EG')
}
</script>
