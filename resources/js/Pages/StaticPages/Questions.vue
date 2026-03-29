<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">الأسئلة الشائعة</h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.75); font-size:14px">إجابات على أكثر الأسئلة شيوعاً</p>
        </div>

        <div style="max-width:800px; margin:32px auto; padding:0 16px">
            <v-expansion-panels variant="accordion" rounded="xl">
                <v-expansion-panel
                    v-for="q in questions"
                    :key="q.id"
                    rounded="xl"
                    class="mb-2"
                    elevation="1"
                >
                    <v-expansion-panel-title class="font-weight-bold" style="font-size:14px">
                        {{ q.title }}
                    </v-expansion-panel-title>
                    <v-expansion-panel-text style="font-size:13px; color:#6b7280; line-height:1.8">
                        {{ q.description }}
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>

            <div v-if="!questions.length" class="text-center py-8 text-grey">
                لا توجد أسئلة متاحة
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({ questions: Array });
</script>
