<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div v-role="['admin']">
            admin role
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg min-h-56">
                    <div class="p-5">
                        <p>大學科研項目預算管理系統主要包括四大類項目：校內項目是由大學內部資金支持的科研活動，旨在促進校內的學術研究與創新，通常具有靈活的預算管理和較快的資金撥付流程；澳門科技發展基金項目則是透過澳門特區政府的基金進行資助，旨在推動本地科技創新，申請流程較為正式，需要提交詳細的計劃書和預算；校外委託項目是由外部機構如企業或政府部門委託的研究，強調與業界的合作，有明確的合同管理和成果交付要求；此外，其他項目則涵蓋了不符合上述類別的科研項目，可能涉及自籌資金或特殊資助，靈活應對不同的研究需求，並需根據具體情況制定相應的預算管理策略。</p>
                        <div>
                            <inertia-link :href="route('staff.funds.index')">{{ $t('my_project') }}</inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
