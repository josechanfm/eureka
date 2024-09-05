
<script setup>
defineProps({
    fund:Object
});
</script>
<template>
    <div class="p-5">
        <div>Title: {{ fund.title }}</div>
        <div>Project code: {{ fund.project_code }}</div>
        <div>Responsible: {{ fund.responsible }}</div>
        <div>Amount: {{ fund.amount }}</div>
        <div>Type: {{ fund.type }}</div>
        <div>Duration: {{ fund.duration }}</div>
    </div>
</template>
