<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    stat: Array

});
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a-button type="primary" :href="route('admin.funds.index')">Funds</a-button>
                <div class="mx-auto flex flex-col md:flex-row space-x-4 py-5">
                    <!-- Status List -->
                    <div class="bg-white rounded-lg shadow-lg w-full md:w-1/3">
                        <h2 class="text-xl font-semibold text-center p-4">Status List</h2>
                        <ul>
                            <li class="flex justify-between p-2 hover:bg-gray-100 border-b border-gray-200">
                                <span class="font-medium">Preparing</span>
                                <span class="text-gray-500">{{ stat['budgetStatus']['S1'] }}</span>
                            </li>
                            <li class="flex justify-between p-2 hover:bg-gray-100 border-b border-gray-200">
                                <span class="font-medium">Return</span>
                                <span class="text-gray-500">{{ stat['budgetStatus']['S2'] }}</span>
                            </li>
                            <li class="flex justify-between p-2 hover:bg-gray-100 border-b border-gray-200">
                                <span class="font-medium">Accepted</span>
                                <span class="text-gray-500">{{ stat['budgetStatus']['S3'] }}</span>
                            </li>
                            <li class="flex justify-between p-2 hover:bg-gray-100 border-b border-gray-200">
                                <span class="font-medium">Accepted</span>
                                <span class="text-gray-500">{{ stat['budgetStatus']['S4'] }}</span>
                            </li>
                            <li class="flex justify-between p-2 hover:bg-gray-100 border-b border-gray-200">
                                <span class="font-medium">Proposed</span>
                                <span class="text-gray-500">{{ stat['budgetStatus']['S5'] }}</span>
                            </li>
                            <li class="flex justify-between p-2 hover:bg-gray-100">
                                <span class="font-medium">Archived</span>
                                <span class="text-gray-500">{{ stat['budgetStatus']['S6'] }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Statistics -->
                    <div class="bg-white rounded-lg shadow-lg w-full md:w-2/3 p-4">
                        <h2 class="text-xl font-semibold text-center mb-4">Statistics</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg text-center">
                                <h3 class="font-medium">Fund Submitted</h3>
                                <p class="text-2xl font-bold">{{ stat['fundSubmitted'] }}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg text-center">
                                <h3 class="font-medium">Fund Closed</h3>
                                <p class="text-2xl font-bold">{{ stat['fundClosed'] }}</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg text-center">
                                <h3 class="font-medium">Budget Count</h3>
                                <p class="text-2xl font-bold">{{ stat['budgetCount'] }}</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg text-center">
                                <h3 class="font-medium">Budget Total</h3>
                                <p class="text-2xl font-bold">{{ stat['budgetTotal'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>
