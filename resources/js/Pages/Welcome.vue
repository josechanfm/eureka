<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
            <Link v-if="$page.props.auth.user" :href="route('staff.dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ $t('dashboard') }}</Link>
            <template v-else>
                <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ $t('login') }}</Link>
                <!-- <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ $t('register') }}</Link> -->
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <a-typography-title>科研申報及預算管理系統</a-typography-title>
            </div>
            <div class="flex justify-center">
                <ApplicationMark />
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="800px" width="800px" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path class="st0" d="M480.077,132.02c-23.996-41.568-76.299-41.765-128.908-27.608C344.548,61.842,323.763,0,260.719,0   c-47.99,0-74.289,45.078-88.348,97.686C132.215,82.225,68.165,69.275,36.641,123.98c-23.991,41.568,1.911,86.942,40.46,125.392   c-33.529,27.011-76.701,76-45.176,130.608c23.996,41.568,76.299,41.765,128.804,27.608C167.454,450.156,188.233,512,251.283,512   c47.986,0,74.289-45.176,88.343-97.784c40.26,15.559,104.206,28.411,135.73-26.196c23.996-41.471-1.906-86.843-40.455-125.294   C468.43,235.617,511.596,186.627,480.077,132.02z M446.743,375.166c-20.882,36.04-70.573,24.892-101.396,13.549   c6.828-35.736,8.936-72.284,8.936-98.382h-18.672c0,22.991-3.715,56.52-11.848,89.147c-2.107,8.334-4.515,16.569-7.225,24.598   c-13.956,41.862-36.245,76.696-68.367,76.696c-41.662,0-56.922-48.588-62.447-80.911c34.436-11.952,67.064-28.412,89.652-41.559   l-9.338-16.166c-19.877,11.44-50.798,25-83.122,34.235c-8.334,2.412-16.667,4.52-25.001,6.118   c-43.167,8.844-84.426,7.03-100.49-20.882c-20.784-36.039,13.554-73.48,38.853-94.568c27.608,23.794,58.122,43.872,80.814,56.921   l9.338-16.157c-19.878-11.45-47.089-31.529-71.279-55.019c-6.123-5.922-12.049-12.039-17.672-18.373   c-29.314-33.029-48.289-69.667-32.226-97.578c20.785-36.04,70.476-24.892,101.3-13.549c-6.828,35.735-8.937,72.284-8.937,98.382   h18.775c0-22.991,3.711-56.52,11.842-89.147c2.108-8.334,4.52-16.667,7.231-24.696c13.956-41.862,36.24-76.598,68.367-76.598   c41.662,0,56.921,48.589,62.441,80.912c-34.43,11.95-67.161,28.412-89.75,41.559l9.436,16.166c19.78-11.44,50.701-25,83.128-34.235   c8.23-2.412,16.564-4.52,24.897-6.118c43.27-8.844,84.529-7.03,100.593,20.882c20.779,36.039-13.554,73.48-38.853,94.568   c-27.608-23.794-58.226-43.872-80.814-56.921l-9.338,16.156c19.775,11.452,47.084,31.53,71.177,55.02   c6.225,5.921,12.146,12.148,17.769,18.47C443.832,310.617,462.807,347.254,446.743,375.166z"/>
                                        <path class="st0" d="M256.003,220.02c-19.868,0-35.975,16.098-35.975,35.97c0,19.872,16.108,35.98,35.975,35.98   c19.864,0,35.971-16.108,35.971-35.98C291.974,236.117,275.867,220.02,256.003,220.02z"/>
                                    </g>
                                </svg>
                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">澳門科技發展基金項目</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                是通過澳門特區政府的科技發展基金進行資助的科研項目，旨在推動本地科技創新和發展。這類項目通常需提交詳細的計劃書和預算，並遵循特定的資金使用規定，申請流程相對正式。
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </div>

                    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg width="100px" height="100px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="var(--ci-primary-color, #000000)" d="M247.759,14.358,16,125.946V184H496V125.638ZM464,152H48v-5.946L248.241,49.642,464,146.362Z" class="ci-primary"></path> <path fill="var(--ci-primary-color, #000000)" d="M16,496H496V392H16Zm32-72H464v40H48Z" class="ci-primary"></path> <rect width="32" height="160" x="72" y="208" fill="var(--ci-primary-color, #000000)" class="ci-primary"></rect> <rect width="32" height="160" x="408" y="208" fill="var(--ci-primary-color, #000000)" class="ci-primary"></rect> <rect width="32" height="160" x="184" y="208" fill="var(--ci-primary-color, #000000)" class="ci-primary"></rect> <rect width="32" height="160" x="296" y="208" fill="var(--ci-primary-color, #000000)" class="ci-primary"></rect> </g></svg>                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">校內項目 </h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                是指由大學內部資金支持的科研活動，旨在促進校內的學術研究與創新。這些項目通常具有靈活的預算管理，並且資金撥付流程較快，有助於滿足教職員的研究需求，提升學校的學術影響力。
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </div>
                    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg fill="#000000" width="100px" height="100px" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title>collaborate</title>
                                        <path d="M6,21V20H4v1a7,7,0,0,0,7,7h3V26H11A5,5,0,0,1,6,21Z" fill="#000000" transform="translate(0)"></path>
                                        <path d="M24,11v1h2V11a7,7,0,0,0-7-7H16V6h3A5,5,0,0,1,24,11Z" fill="#000000" transform="translate(0)"></path>
                                        <path d="M11,11H5a3,3,0,0,0-3,3v2H4V14a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v2h2V14A3,3,0,0,0,11,11Z" fill="#000000" transform="translate(0)"></path>
                                        <path d="M8,10A4,4,0,1,0,4,6,4,4,0,0,0,8,10ZM8,4A2,2,0,1,1,6,6,2,2,0,0,1,8,4Z" fill="#000000" transform="translate(0)"></path>
                                        <path d="M27,25H21a3,3,0,0,0-3,3v2h2V28a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v2h2V28A3,3,0,0,0,27,25Z" fill="#000000" transform="translate(0)"></path>
                                        <path d="M20,20a4,4,0,1,0,4-4A4,4,0,0,0,20,20Zm6,0a2,2,0,1,1-2-2A2,2,0,0,1,26,20Z" fill="#000000" transform="translate(0)"></path>
                                        <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" width="32" height="32" fill="none"></rect>
                                    </g>
                                </svg>
                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">校外委託項目</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                是由外部機構（如企業或政府部門）委託大學進行的研究工作。這些項目強調與業界的合作，通常涉及明確的合同管理和成果交付要求，並且資金使用需符合雙方的約定。
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </div>

                    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg width="100px" height="100px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M10 10H2V2h8zM3 9h6V3H3zm18 1h-8V2h8zm-7-1h6V3h-6zm3 13.657L11.343 17 17 11.343 22.657 17zM12.757 17L17 21.243 21.243 17 17 12.757zM10 21H2v-8h8zm-7-1h6v-6H3z"></path><path fill="none" d="M0 0h24v24H0z"></path></g></svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">其他項目</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                則涵蓋了不符合上述類別的科研項目，包括自籌資金或特殊資助來源。這些項目通常具有靈活性，能夠根據特定的研究需求進行調整，並需要根據具體情況制定相應的預算管理策略。
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>

                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                <div class="text-center text-sm sm:text-start">
                    MPU @2024&nbsp;
                </div>

                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-end sm:ms-0">
                    CSC
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
