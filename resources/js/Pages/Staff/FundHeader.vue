<script setup>
defineProps({
    fund: Object
});
</script>
<template>
    <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <div class="border-green-500 border-solid">
            <table class="min-w-full bg-white border border-gray-200">
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_code') }}:</th>
                        <td class="py-1 px-4">{{ fund.project_code }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_title') }}:</th>
                        <td class="py-1 px-4">{{ fund.title }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_responsible') }}:</th>
                        <td class="py-1 px-4">{{ fund.responsible }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_amount') }}:</th>
                        <td class="py-1 px-4">{{ fund.amount }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_type') }}:</th>
                        <td class="py-1 px-4">
                            <span v-if="fund.type == 'P'">{{ $t('compensated') }}</span>
                            <span v-if="fund.type == 'U'">{{ $t('non_compensated') }}</span>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_duration') }}:</th>
                        <td class="py-1 px-4">{{ fund.duration }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_grant') }}:</th>
                        <td class="py-1 px-4">{{ fund.grant }}{{ $t('month') }}</td>
                    </tr>
                    <template v-for="idx in fund.grant">
                        <tr class="border-b hover:bg-gray-50">
                            <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_phase'+(idx)) }}:</th>
                            <td class="py-1 px-4">{{ fund.grants[idx] }}</td>
                        </tr>
                    </template>
                    <template v-if="fund.type == 'P'">
                        <tr class="border-b hover:bg-gray-50">
                            <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_repayment') }}:</th>
                            <td class="py-1 px-4">{{ fund.repayment }}{{ $t('month') }}</td>
                        </tr>
                        <template v-for="idx in fund.repayment">
                            <tr class="border-b hover:bg-gray-50">
                                <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_phase'+(idx)) }}:</th>
                                <td class="py-1 px-4">{{ fund.repayments[idx] }}</td>
                            </tr>   
                        </template>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
th {

    text-align: left;

    width: 150px;

}
</style>