
<script setup>
defineProps({
    expend:Object
});
</script>
<template>
    <div class="p-5">
        <div>Title:{{ expend.fund.title }}</div>
        <div>Code: {{ expend.fund.project_code }}</div>
        <div>Responsible: {{ expend.fund.responsible }}</div>
        <div>Amount: {{ expend.fund.amount }}</div>
        <div>Expenditure: {{ expend.title }}</div>
    </div>
</template>
