<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    message:String

});
</script>

<template>
    <div class="p-5 bg-gray-200">
        <div class="shrink-0 flex items-center">
            <Link :href="route('home')">
                <ApplicationMark class="block h-9 w-auto" />
            </Link>
        </div>
    </div>
    <div v-html="message"/>
</template>
