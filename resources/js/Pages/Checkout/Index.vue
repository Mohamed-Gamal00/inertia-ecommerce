<template>
    <div class="co-page" dir="rtl">
        <v-container class="py-8">
            <v-row>

                <!-- ===== LEFT col (8): Shipping + Payment + Cart + Confirm ===== -->
                <v-col cols="12" md="8">

                    <!-- Row 1: Shipping + Payment (side by side) -->
                    <v-row class="mb-4">

                        <!-- Shipping method -->
                        <v-col cols="12" sm="6">
                            <div class="co-card h-100">
                                <div class="co-card-title">طريقة الشحن</div>
                                <v-divider class="mb-3" />

                                <div class="co-radio-group">
                                    <label v-if="shipping?.add_pickup_from_store" class="co-radio-item" :class="{ active: shippingOption === 'noShipping' }">
                                        <input type="radio" v-model="shippingOption" value="noShipping" />
                                        <span>الاستلام من المتجر</span>
                                    </label>
                                    <label v-if="shipping?.add_normal_price" class="co-radio-item" :class="{ active: shippingOption === 'fixed_shipping' }">
                                        <input type="radio" v-model="shippingOption" value="fixed_shipping" />
                                        <span>تكلفة ثابتة للشحن - {{ shipping.normal_shipping_price }} ر.س</span>
                                    </label>
                                    <label v-if="shipping?.add_wight_price" class="co-radio-item" :class="{ active: shippingOption === 'shipping_based_on_weight' }">
                                        <input type="radio" v-model="shippingOption" value="shipping_based_on_weight" />
                                        <span>الشحن بناءً على الوزن</span>
                                    </label>
                                    <label v-if="shipping?.add_price_based_on_city" class="co-radio-item" :class="{ active: shippingOption === 'shipping_based_on_city' }">
                                        <input type="radio" v-model="shippingOption" value="shipping_based_on_city" />
                                        <span>الشحن بناءً على المنطقة - {{ cityShippingPrice }} ر.س</span>
                                    </label>
                                </div>
                            </div>
                        </v-col>

                        <!-- Payment method -->
                        <v-col cols="12" sm="6">
                            <div class="co-card h-100">
                                <div class="co-card-title">طريقة الدفع أو السداد</div>
                                <v-divider class="mb-3" />

                                <div class="co-radio-group">
                                    <label class="co-radio-item" :class="{ active: form.payment_method === 'cash_on_delivery' }">
                                        <input type="radio" v-model="form.payment_method" value="cash_on_delivery" />
                                        <span>الدفع عند الاستلام</span>
                                    </label>
                                    <label class="co-radio-item" :class="{ active: form.payment_method === 'card_payment' }">
                                        <input type="radio" v-model="form.payment_method" value="card_payment" />
                                        <span>بطاقة دفع</span>
                                    </label>
                                </div>
                            </div>
                        </v-col>
                    </v-row>

                    <!-- Discount code -->
                    <div class="co-card mb-4">
                        <div class="co-card-title">كود الخصم</div>
                        <v-divider class="mb-3" />

                        <!-- Applied badge -->
                        <div v-if="appliedDiscount" class="co-discount-applied mb-3">
                            <v-icon size="18" color="success" class="me-1">mdi-check-circle</v-icon>
                            <span>تم تطبيق كود <strong>{{ appliedDiscount.code }}</strong> —
                                خصم {{ appliedDiscount.type === 'percentage' ? appliedDiscount.value + '%' : appliedDiscount.value + ' ر.س' }}
                            </span>
                            <button class="co-discount-remove" @click="removeDiscount">
                                <v-icon size="14">mdi-close</v-icon>
                            </button>
                        </div>

                        <div v-else class="co-discount-input-row">
                            <v-text-field
                                v-model="discountInput"
                                placeholder="أدخل كود الخصم"
                                variant="outlined"
                                density="compact"
                                hide-details
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                style="flex:1"
                                dir="ltr"
                                :error="!!discountError"
                                @keyup.enter="applyDiscount"
                            />
                            <v-btn
                                color="primary"
                                rounded="lg"
                                height="40"
                                style="text-transform:none; min-width:90px"
                                :loading="discountLoading"
                                @click="applyDiscount"
                            >
                                تطبيق
                            </v-btn>
                        </div>
                        <div v-if="discountError" class="mt-2">
                            <div v-if="discountError === '__login__'" class="co-discount-login-msg">
                                <v-icon size="16" color="warning" class="me-1">mdi-account-lock-outline</v-icon>
                                يجب
                                <a href="/login" class="text-primary fw-bold mx-1">تسجيل الدخول</a>
                                أو
                                <a href="/register" class="text-primary fw-bold mx-1">إنشاء حساب</a>
                                لاستخدام كود الخصم
                            </div>
                            <div v-else class="text-red text-caption">{{ discountError }}</div>
                        </div>
                    </div>

                    <!-- Cart items -->
                    <div class="co-card mb-4">
                        <a href="/products" class="text-decoration-none">
                            <div class="co-card-title text-primary" style="cursor:pointer">سلة المشتريات</div>
                        </a>
                        <v-divider class="mb-3" />

                        <div v-for="item in cartItems" :key="item.id" class="co-item">
                            <img :src="item.image" class="co-item-img" alt="product" />
                            <div class="co-item-info">
                                <div class="co-item-name">{{ item.name }}</div>
                            </div>
                            <div class="co-item-qty">
                                <span>{{ item.quantity }}</span>
                            </div>
                            <div class="co-item-total">
                                {{ Math.ceil((Number(item.discount_price) || Number(item.price)) * Number(item.quantity)) }} ر.س
                            </div>
                        </div>

                        <v-divider class="my-3" />

                        <div class="co-sum-row">
                            <span>مجموع المنتجات</span>
                            <span>{{ totalItemsCount }} قطعة</span>
                        </div>
                        <div v-if="appliedDiscount" class="co-sum-row" style="color:#16a34a">
                            <span>
                                <v-icon size="14" color="success" class="me-1">mdi-tag-outline</v-icon>
                                خصم ({{ appliedDiscount.code }})
                            </span>
                            <span>- {{ discountSaving }} ر.س</span>
                        </div>
                        <div class="co-sum-row co-sum-total">
                            <span>الإجمالي</span>
                            <span>{{ grandTotal }} ر.س</span>
                        </div>
                    </div>

                    <!-- Confirm + Note -->
                    <div class="co-card">
                        <div class="co-card-title">تأكيد</div>
                        <v-divider class="mb-3" />

                        <div class="co-card-title mt-2" style="font-weight:500; color:#6b7280; font-size:13px">الملاحظة</div>
                        <v-textarea v-model="form.note" variant="outlined" density="compact" hide-details rows="3" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-4" />

                        <div class="d-flex flex-column mb-4" style="gap:10px">
                            <label class="co-check">
                                <input type="checkbox" v-model="joinNews" />
                                <span>أريد الاشتراك في القائمة البريدية</span>
                            </label>
                            <label class="co-check">
                                <input type="checkbox" v-model="form.terms" />
                                <span>لقد قرأت وأوافق على <a href="#" class="text-primary">الخصوصية والسياسة</a></span>
                            </label>
                        </div>

                        <div v-if="errors.terms" class="text-red text-caption mb-2">{{ errors.terms }}</div>
                        <div v-if="errors.general" class="text-red text-caption mb-2">{{ errors.general }}</div>

                        <v-btn block color="primary" height="48" rounded="lg" style="text-transform:none; font-size:15px; font-weight:600" :loading="submitting" @click="submit">
                            تأكيد الطلب
                        </v-btn>
                    </div>

                </v-col>

                <!-- ===== RIGHT col (4): Address / Contact ===== -->
                <v-col cols="12" md="4">
                    <div class="co-card">

                        <!-- Validation summary from backend -->
                        <v-alert
                            v-if="Object.keys(errors).length && !errors.terms"
                            type="error"
                            variant="tonal"
                            rounded="lg"
                            density="compact"
                            class="mb-4"
                        >
                            <div class="font-weight-bold mb-1">يرجى تصحيح الأخطاء التالية:</div>
                            <ul class="mb-0 ps-3" style="font-size:13px">
                                <li v-for="(msgs, field) in errors" :key="field">
                                    {{ Array.isArray(msgs) ? msgs[0] : msgs }}
                                </li>
                            </ul>
                        </v-alert>

                        <!-- Guest: login or guest toggle -->
                        <template v-if="!user">
                            <div class="co-card-title">تسجيل الدخول أو التسجيل</div>
                            <v-divider class="mb-3" />
                            <div class="co-radio-group mb-4">
                                <label class="co-radio-item" :class="{ active: guestMode === 'login' }">
                                    <input type="radio" v-model="guestMode" value="login" />
                                    <span>تسجيل الدخول</span>
                                </label>
                                <label class="co-radio-item" :class="{ active: guestMode === 'guest' }">
                                    <input type="radio" v-model="guestMode" value="guest" />
                                    <span>زائر</span>
                                </label>
                            </div>
                        </template>

                        <!-- Logged in: saved addresses -->
                        <template v-if="user && userAddresses.length">
                            <div class="co-card-title">اختر عنوان الشحن</div>
                            <v-divider class="mb-3" />
                            <div class="mb-3">
                                <label
                                    v-for="addr in userAddresses"
                                    :key="addr.id"
                                    class="co-addr-opt"
                                    :class="{ active: form.user_address === String(addr.id) }"
                                    @click="form.user_address = String(addr.id)"
                                >
                                    <v-icon size="15" :color="form.user_address === String(addr.id) ? 'primary' : 'grey'">mdi-map-marker-outline</v-icon>
                                    <div style="flex:1">
                                        <div style="font-size:13px; font-weight:600">{{ addr.address_title || 'عنوان' }}</div>
                                        <div style="font-size:12px; color:#9ca3af">{{ addr.address }}</div>
                                    </div>
                                    <v-chip v-if="addr.main_address" size="x-small" color="primary" variant="flat">رئيسي</v-chip>
                                </label>
                            </div>
                        </template>

                        <!-- Add new address toggle -->
                        <template v-if="user">
                            <label
                                class="co-addr-opt mb-4"
                                :class="{ active: form.user_address === 'add_address' }"
                                @click="form.user_address = 'add_address'"
                            >
                                <v-icon size="15" color="grey">mdi-plus-circle-outline</v-icon>
                                <span style="font-size:13px">إضافة عنوان جديد</span>
                            </label>
                        </template>

                        <!-- Address form: shown for guests always, for users when add_address selected -->
                        <template v-if="!user || form.user_address === 'add_address'">
                            <div class="co-card-title">التفاصيل</div>
                            <v-divider class="mb-3" />

                            <div class="co-field-group">
                                <div class="co-field">
                                    <label class="co-label">الاسم الأول</label>
                                    <v-text-field v-model="addrForm.first_name" placeholder="الاسم الأول" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" :error-messages="errors['addr.shipping.first_name'] || errors['addr.billing.first_name']" />
                                </div>
                                <div class="co-field">
                                    <label class="co-label">اسم العائلة</label>
                                    <v-text-field v-model="addrForm.last_name" placeholder="اسم العائلة" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" :error-messages="errors['addr.shipping.last_name'] || errors['addr.billing.last_name']" />
                                </div>
                                <div v-if="!user" class="co-field co-field--full">
                                    <label class="co-label">البريد الإلكتروني</label>
                                    <v-text-field v-model="addrForm.email" placeholder="البريد الإلكتروني" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" dir="ltr" :error-messages="errors['guest_email']" />
                                </div>
                                <div class="co-field co-field--full">
                                    <label class="co-label">رقم الجوال</label>
                                    <v-text-field v-model="addrForm.phone_number" placeholder="رقم الجوال" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" dir="ltr" :error-messages="errors['addr.shipping.phone_number'] || errors['addr.billing.phone_number']" />
                                </div>
                                <div class="co-field co-field--full">
                                    <label class="co-label">الدولة</label>
                                    <v-select v-model="addrForm.country_id" :items="countries" item-title="name_ar" item-value="id" placeholder="اختر الدولة" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" :error-messages="errors['addr.shipping.country_id'] || errors['addr.billing.country_id']" @update:model-value="addrForm.city_id = null" />
                                </div>
                                <div class="co-field co-field--full">
                                    <label class="co-label">المدينة</label>
                                    <v-select v-model="addrForm.city_id" :items="filteredCities" item-title="name_ar" item-value="id" placeholder="اختر المدينة" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" :error-messages="errors['addr.shipping.city_id'] || errors['addr.billing.city_id']" />
                                </div>
                                <div class="co-field co-field--full">
                                    <label class="co-label">العنوان</label>
                                    <v-text-field v-model="addrForm.address" placeholder="ادخل العنوان" variant="outlined" density="compact" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1" :error-messages="errors['addr.shipping.address'] || errors['addr.billing.address']" />
                                </div>
                            </div>
                        </template>

                    </div>
                </v-col>

            </v-row>
        </v-container>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

const { props } = usePage();
const user          = computed(() => props.auth?.user);
const cartItems     = ref(props.cartItems || []);
const totalBefore   = computed(() =>
    cartItems.value.reduce((sum, item) => {
        return sum + Number(item.price) * item.quantity;
    }, 0)
);

const totalItemsCount = computed(() => cartItems.value.length);

const cartTotal = computed(() =>
    cartItems.value.reduce((sum, item) => {
        const price = item.discount_price && Number(item.discount_price) < Number(item.price)
            ? Number(item.discount_price)
            : Number(item.price);
        const qty = Number(item.quantity);
        return sum + price * qty;
    }, 0)
);
const countries     = ref(props.countries || []);
const cities        = ref(props.cities || []);
const shipping      = ref(props.shipping);
const discountPrice = ref(props.discountPrice || 0);
const userAddresses = ref(props.userAddresses || []);

const submitting     = ref(false);
const errors         = ref({});
const discountInput  = ref('');
const discountError  = ref('');
const discountLoading = ref(false);
const appliedDiscount = ref(null); // { code, value, type }
const joinNews       = ref(false);
const guestMode      = ref('guest');
const shippingOption = ref(
    props.shipping?.add_pickup_from_store ? 'noShipping' :
    props.shipping?.add_normal_price      ? 'fixed_shipping' :
    props.shipping?.add_wight_price       ? 'shipping_based_on_weight' :
    props.shipping?.add_price_based_on_city ? 'shipping_based_on_city' : 'fixed_shipping'
);

const form = ref({
    payment_method: 'cash_on_delivery',
    user_address: userAddresses.value.find(a => a.main_address)
        ? String(userAddresses.value.find(a => a.main_address).id)
        : (userAddresses.value.length ? String(userAddresses.value[0].id) : 'add_address'),
    note: '',
    terms: false,
});

const addrForm = ref({
    first_name:   user.value?.first_name || '',
    last_name:    '',
    email:        user.value?.email || '',
    phone_number: '',
    country_id:   null,
    city_id:      null,
    address:      '',
});

const filteredCities = computed(() =>
    addrForm.value.country_id
        // eslint-disable-next-line eqeqeq
        ? cities.value.filter(c => c.country_id == addrForm.value.country_id)
        : cities.value
);

const cityShippingPrice = computed(() => {
    if (!addrForm.value.city_id) return 0;
    // eslint-disable-next-line eqeqeq
    const city = cities.value.find(c => c.id == addrForm.value.city_id);
    return city?.shipping_price || 0;
});

const shippingCost = computed(() => {
    if (shippingOption.value === 'noShipping') return 0;
    if (shippingOption.value === 'fixed_shipping') return Number(shipping.value?.normal_shipping_price) || 0;
    if (shippingOption.value === 'shipping_based_on_city') return Number(cityShippingPrice.value) || 0;
    if (shippingOption.value === 'shipping_based_on_weight') return Number(shipping.value?.weight_price) || 0;
    return 0;
});

const grandTotal = computed(() =>
    Math.ceil(Number(cartTotal.value) + Number(shippingCost.value) - Number(discountSaving.value))
);

async function applyDiscount() {
    if (!discountInput.value.trim()) return;
    discountError.value   = '';
    discountLoading.value = true;
    try {
        const { data } = await axios.post('/checkout/apply-discount', {
            discount_code: discountInput.value.trim(),
        });
        appliedDiscount.value = {
            code:  data.discount_code,
            value: data.discount_value,
            type:  data.discount_type,
        };
        discountPrice.value = data.discount_type === 'percentage'
            ? Math.ceil(cartTotal.value * data.discount_value / 100)
            : data.discount_value;
        discountInput.value = '';
    } catch (e) {
        const res = e.response?.data;
        if (res?.requires_login) {
            discountError.value = '__login__';
        } else {
            discountError.value = res?.message || 'حدث خطأ';
        }
    } finally {
        discountLoading.value = false;
    }
}

function removeDiscount() {
    appliedDiscount.value = null;
    discountPrice.value   = 0;
    discountInput.value   = '';
    discountError.value   = '';
}

const discountSaving = computed(() => {
    if (!appliedDiscount.value) return 0;
    if (appliedDiscount.value.type === 'percentage') {
        return Math.ceil(cartTotal.value * appliedDiscount.value.value / 100);
    }
    return appliedDiscount.value.value;
});

async function submit() {
    if (!form.value.terms) {
        errors.value = { terms: 'يجب الموافقة على الشروط والأحكام' };
        return;
    }

    // Validate guest / new address fields
    const isGuest = !user.value;
    const needsAddressForm = isGuest || form.value.user_address === 'add_address';

    if (needsAddressForm) {
        const fieldErrors = {};
        if (!addrForm.value.first_name?.trim())   fieldErrors['addr.billing.first_name']   = ['الاسم الأول مطلوب'];
        if (!addrForm.value.last_name?.trim())    fieldErrors['addr.billing.last_name']    = ['اسم العائلة مطلوب'];
        if (!addrForm.value.phone_number?.trim()) fieldErrors['addr.billing.phone_number'] = ['رقم الجوال مطلوب'];
        if (!addrForm.value.address?.trim())      fieldErrors['addr.billing.address']      = ['العنوان مطلوب'];
        if (!addrForm.value.country_id)           fieldErrors['addr.billing.country_id']   = ['الدولة مطلوبة'];
        if (!addrForm.value.city_id)              fieldErrors['addr.billing.city_id']      = ['المدينة مطلوبة'];
        if (isGuest && !addrForm.value.email?.trim()) fieldErrors['guest_email'] = ['البريد الإلكتروني مطلوب'];

        if (Object.keys(fieldErrors).length) {
            errors.value = fieldErrors;
            // Scroll to the form
            document.querySelector('.co-field-group')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
    }

    submitting.value = true;
    errors.value = {};

    const addrType = isGuest ? 'billing' : 'shipping';

    const payload = {
        payment_method:  form.value.payment_method,
        note:            form.value.note,
        terms:           1,
        shipping_price:  shippingCost.value,
        join_news:       joinNews.value ? 1 : 0,
    };

    if (shippingOption.value === 'noShipping') {
        payload.pickup_from_store = true;
    } else if (shippingOption.value === 'fixed_shipping') {
        payload.fixed_shipping = true;
    } else if (shippingOption.value === 'shipping_based_on_weight') {
        payload.shipping_based_on_weight = true;
    } else if (shippingOption.value === 'shipping_based_on_city') {
        payload.shipping_based_on_city = true;
    }

    if (user.value && form.value.user_address !== 'add_address') {
        payload.user_address = form.value.user_address;
    } else {
        payload.addr = {
            [addrType]: {
                first_name:   addrForm.value.first_name,
                last_name:    addrForm.value.last_name,
                phone_number: addrForm.value.phone_number,
                country_id:   addrForm.value.country_id,
                city_id:      addrForm.value.city_id,
                address:      addrForm.value.address,
            }
        };
        if (isGuest) payload.guest_email = addrForm.value.email;
    }

    try {
        const { data } = await axios.post('/checkout', payload);
        if (data.redirect) window.location.href = data.redirect;
        else router.visit('/');
    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors || {};
        } else {
            errors.value = { general: e.response?.data?.message || e.message || 'حدث خطأ' };
            console.error('Checkout error:', e.response?.data);
        }
    } finally {
        submitting.value = false;
    }
}
</script>

<style scoped>
.co-page { background: #f5f6fa; min-height: 100vh; }

.co-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px;
}

.co-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

/* Radio */
.co-radio-group { display: flex; flex-direction: column; gap: 8px; }

.co-radio-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #374151;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    transition: border-color 0.15s, background 0.15s;
}

.co-radio-item.active { border-color: #3949ab; background: #f0f2ff; }
.co-radio-item input { accent-color: #3949ab; }

/* Discount */
.co-discount-login-msg {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 2px;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #92400e;
}

.co-discount-input-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.co-discount-applied {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 13px;
    color: #15803d;
}

.co-discount-remove {
    margin-right: auto;
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    display: flex;
    align-items: center;
    padding: 0;
}
.co-discount-remove:hover { color: #ef4444; }

/* Cart item */
.co-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
}

.co-item-img {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.co-item-info { flex: 1; }
.co-item-name { font-size: 13px; font-weight: 600; color: #111827; }

.co-item-qty {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 4px 14px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.co-item-total { font-size: 13px; font-weight: 700; color: #1a237e; min-width: 70px; text-align: left; }

.co-sum-row { display: flex; justify-content: space-between; font-size: 13px; color: #6b7280; padding: 4px 0; }
.co-sum-total { font-size: 15px; font-weight: 700; color: #111827; padding-top: 8px; border-top: 1px solid #e5e7eb; margin-top: 4px; }

/* Address option */
.co-addr-opt {
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 12px;
    cursor: pointer;
    margin-bottom: 8px;
    transition: border-color 0.15s, background 0.15s;
    font-size: 13px;
}

.co-addr-opt.active { border-color: #3949ab; background: #f0f2ff; }

/* Contact form grid */
.co-field-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.co-field { display: flex; flex-direction: column; }
.co-field--full { grid-column: 1 / -1; }
.co-label { font-size: 12px; font-weight: 600; color: #374151; }

/* Checkbox */
.co-check { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #374151; cursor: pointer; }
.co-check input { accent-color: #3949ab; width: 15px; height: 15px; }
</style>
