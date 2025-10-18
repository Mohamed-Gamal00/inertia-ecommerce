<template>
  <div>
    <h3 class="mb-2">طلباتي</h3>
    <p class="mb-6 text-gray-600">قائمة الطلبات السابقة والجارية.</p>

    <!-- في حالة وجود طلبات -->
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
          <td class="text-center">{{ order.order_number }}</td>
          <td class="text-center">{{ formatDate(order.created_at) }}</td>
          <td class="text-center">
            <v-chip :color="statusColor(order.status)" size="small" label>
              {{ statusText(order.status) }}
            </v-chip>
          </td>
          <td class="text-center">{{ order.total }} ر.س</td>
          <td class="text-center">
            <v-btn size="small" color="primary" variant="tonal" @click="viewOrder(order)">
              عرض التفاصيل
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>

    <!-- في حالة عدم وجود طلبات -->
    <div v-else class="text-center py-10">
      <v-icon color="grey" size="48">mdi-cube-outline</v-icon>
      <p class="mt-3 text-gray-500">لا توجد طلبات حالياً.</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

// console.log(props.user);
// الطلبات تأتي مباشرة من المستخدم
const orders = computed(() => props.user.orders || [])

// تحويل الحالة إلى نص
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

// تلوين الحالة
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

// تنسيق التاريخ
const formatDate = (dateStr) => {
  if (!dateStr) return '-'
  const date = new Date(dateStr)
  return date.toLocaleDateString('ar-EG')
}

const viewOrder = (order) => {
  console.log('عرض تفاصيل الطلب:', order)
  // يمكنك الانتقال لاحقًا إلى صفحة تفاصيل الطلب
}
</script>
