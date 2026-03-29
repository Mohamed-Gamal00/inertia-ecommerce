<template>
    <div style="background:#f5f6fa; min-height:100vh; display:flex; align-items:center; justify-content:center">
        <v-card rounded="xl" elevation="2" class="pa-8 text-center" style="max-width:400px; width:100%">
            <v-icon size="56" color="primary" class="mb-4">mdi-account-circle-outline</v-icon>
            <h2 class="font-weight-bold mb-2" style="font-size:20px">حسابي</h2>
            <p class="text-grey mb-6" style="font-size:14px">إدارة حسابك الشخصي وطلباتك</p>
            <v-btn block color="primary" rounded="lg" href="/user-profile" style="text-transform:none" class="mb-3">
                الذهاب للملف الشخصي
            </v-btn>
            <v-btn block variant="outlined" color="primary" rounded="lg" href="/" style="text-transform:none">
                العودة للرئيسية
            </v-btn>
        </v-card>
    </div>
</template>

<script setup></script>
