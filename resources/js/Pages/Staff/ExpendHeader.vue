
<script setup>
defineProps({
    expend:Object
});
</script>
<template>
    <div class="p-5">
        <table>
            <tr><th>{{ $t('fund_title') }}</th><td>{{ expend.fund.title }}</td></tr>
            <tr><th>{{ $t('expend_code') }}</th><td>{{ expend.fund.project_code }}</td></tr>
            <tr><th>{{ $t('fund_responsible') }}</th><td>{{ expend.fund.responsible }}</td></tr>
            <tr><th>{{ $t('amount') }}</th><td>{{ expend.fund.amount }}</td></tr>
            <tr><th>{{ $t('expend_title') }}</th><td>{{ expend.title }}</td></tr>
        </table>
    </div>
</template>

<style scoped>
th{
    text-align: left;
    width:150px;
}
</style>
