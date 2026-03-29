<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">

        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">الماركات والشركات</h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.75); font-size:14px">
                {{ brands.length }} ماركة متاحة
            </p>
        </div>

        <div style="padding:32px 16px; max-width:1200px; margin:0 auto">
            <div v-if="brands.length" style="display:flex; flex-wrap:wrap; justify-content:center; gap:16px">
                <a
                    v-for="brand in brands"
                    :key="brand.id"
                    :href="`/brands/${brand.id}`"
                    style="display:block; width:180px; text-decoration:none; flex-shrink:0"
                >
                    <div class="brand-card">
                        <div class="brand-logo">
                            <img v-if="brand.image_url && !brand.image_url.includes('no-image')" :src="brand.image_url" :alt="brand.name" />
                            <span v-else class="brand-initials">{{ brand.name_en?.charAt(0) || brand.name?.charAt(0) }}</span>
                        </div>
                        <div class="brand-name">{{ brand.name }}</div>
                        <div class="brand-count">{{ brand.products_count }} منتج</div>
                    </div>
                </a>
            </div>

            <div v-else style="text-align:center; padding:64px 0">
                <v-icon size="64" color="grey-lighten-1">mdi-store-outline</v-icon>
                <p style="margin-top:12px; color:#9ca3af">لا توجد ماركات متاحة</p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({ brands: Array });
</script>

<style scoped>
.brand-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px 16px;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    cursor: pointer;
}

.brand-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(57,73,171,0.12);
    border-color: #3949ab;
}

.brand-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #e8eaf6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    transition: border-color 0.2s;
}

.brand-card:hover .brand-logo { border-color: #3949ab; }

.brand-logo img { width: 100%; height: 100%; object-fit: contain; padding: 8px; }

.brand-initials {
    font-size: 28px;
    font-weight: 800;
    color: #1a237e;
}

.brand-name {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}

.brand-count {
    font-size: 11px;
    color: #9ca3af;
}
</style>
