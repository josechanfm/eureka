
<script setup>
defineProps({
    fund:Object
});
</script>
<template>
    <div class="p-5">
        <table>
            <tr><th>{{ $t('project_code') }}:</th><td>{{ fund.project_code }}</td></tr>
            <tr><th>{{ $t('project_title') }}:</th><td>{{ fund.title }}</td></tr>
            <tr><th>{{ $t('project_responsible') }}:</th><td>{{ fund.responsible }}</td></tr>
            <tr><th>{{ $t('project_amount') }}:</th><td>{{ fund.amount }}</td></tr>
            <tr><th>{{ $t('project_type') }}:</th><td>
                <span v-if="fund.type=='P'">{{ $t('compensated') }}</span>
                <span v-if="fund.type=='U'">{{ $t('non_compensated') }}</span>
            </td></tr>
            <tr><th>{{ $t('project_duration') }}:</th><td>{{ fund.duration }}</td></tr>
            <tr><th>{{ $t('project_grant') }}:</th><td>{{ fund.grant }}{{ $t('month') }}</td></tr>
            <tr><th>{{ $t('project_phase1') }}:</th><td>{{ fund.grants[0] }}</td></tr>
            <tr><th>{{ $t('project_phase2') }}:</th><td>{{ fund.grants[1] }}</td></tr>
            <tr><th>{{ $t('project_phase3') }}:</th><td>{{ fund.grants[2] }}</td></tr>
            <tr><th>{{ $t('project_phase4') }}:</th><td>{{ fund.grants[3] }}</td></tr>
            <tr><th>{{ $t('project_phase5') }}:</th><td>{{ fund.grants[4] }}</td></tr>
            <tr><th>{{ $t('project_phase6') }}:</th><td>{{ fund.grants[5] }}</td></tr>
            <template v-if="fund.type=='P'">
                <tr><th>{{ $t('project_repayment') }}:</th><td>{{ fund.repayment }}</td></tr>
                <tr><th>{{ $t('project_phase1') }}:</th><td>{{ fund.repayments[0] }}</td></tr>
                <tr><th>{{ $t('project_phase2') }}:</th><td>{{ fund.repayments[1] }}</td></tr>
                <tr><th>{{ $t('project_phase3') }}:</th><td>{{ fund.repayments[2] }}</td></tr>
                <tr><th>{{ $t('project_phase4') }}:</th><td>{{ fund.repayments[3] }}</td></tr>
                <tr><th>{{ $t('project_phase5') }}:</th><td>{{ fund.repayments[4] }}</td></tr>
                <tr><th>{{ $t('project_phase6') }}:</th><td>{{ fund.repayments[5] }}</td></tr>
            </template>
        </table>
    </div>
</template>
<style scoped>
th{
    text-align: left;
    width:150px;
}
</style>
