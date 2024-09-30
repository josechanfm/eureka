
<script setup>
defineProps({
    expend:Object
});
</script>
<template>
    <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <div class="border-orange-500 border-solid">
            <table class="min-w-full bg-white border border-gray-200">
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_title') }}</th>
                        <td>{{ expend.fund.title }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_code') }}</th>
                        <td>{{ expend.fund.project_code }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('project_responsible') }}</th>
                        <td>{{ expend.fund.responsible }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('amount') }}</th>
                        <td>{{ expend.fund.amount }}</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="py-1 px-4 font-medium text-gray-700">{{ $t('expend_title') }}</th>
                        <td>{{ expend.title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
th{
    text-align: left;
    width:150px;
}
</style>
