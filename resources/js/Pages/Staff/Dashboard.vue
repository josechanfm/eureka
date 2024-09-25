<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <StaffLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('dashboard')}}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg min-h-56 p-5">
                    <p class="text-gray-700 leading-relaxed ">
                        {{ $t('dashboard_intro') }}
                    </p>
                    <a-button type="primary" as="link" :href="route('staff.funds.index')">{{ $t('my_project') }}</a-button>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
