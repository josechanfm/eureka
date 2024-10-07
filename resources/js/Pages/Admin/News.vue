<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                News
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-end mb-4">
                        <a-button type="primary" @click="$inertia.visit(route('admin.news.create'))">
                            Add News
                        </a-button>
                    </div>
                    
                    <div class="space-y-6">
                        <div v-for="item in news.data" :key="item.id" class="flex bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="w-1/4 min-w-[150px]">
                                <img :src="item.thumbnail_url || '/path/to/default/image.jpg'" :alt="item.title" class="w-full h-full object-cover">
                            </div>
                            <div class="w-3/4 p-4">
                                <h3 class="text-xl font-semibold mb-2">{{ item.title }}</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <span class="mr-3">{{ item.author }}</span>
                                    <span>{{ formatDate(item.published_at) }}</span>
                                </div>
                                <p class="text-gray-600 mb-2">{{ truncateContent(item.content) }}</p>
                                <div class="flex space-x-2">
                                    <a-button @click="$inertia.visit(route('admin.news.edit', item.id))">
                                        Edit
                                    </a-button>
                                    <a-popconfirm
                                        title="Are you sure you want to delete this news item?"
                                        @confirm="$inertia.delete(route('admin.news.destroy', item.id))"
                                        ok-text="Yes"
                                        cancel-text="No"
                                    >
                                        <a-button type="primary" danger>
                                            Delete
                                        </a-button>
                                    </a-popconfirm>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a-pagination
                            v-model:current="currentPage"
                            :total="news.total"
                            :pageSize="news.per_page"
                            @change="handlePageChange"
                            show-quick-jumper
                            show-size-changer
                            :pageSizeOptions="['10', '20', '30', '40']"
                            @showSizeChange="handleSizeChange"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

export default {
    components: {
        AppLayout,
    },
    props: {
        news: Object,
    },
    setup(props) {
        const currentPage = ref(props.news.current_page);

        const formatDate = (date) => {
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        };

        const truncateContent = (content, maxLength = 150) => {
            return content.length > maxLength ? content.substring(0, maxLength) + '...' : content;
        };

        const handlePageChange = (page) => {
            currentPage.value = page;
            fetchNews(page, props.news.per_page);
        };

        const handleSizeChange = (current, size) => {
            fetchNews(1, size);
        };

        const fetchNews = (page, perPage) => {
            this.$inertia.get(route('admin.news.index'), {
                page: page,
                per_page: perPage
            }, {
                preserveState: true,
                preserveScroll: true,
            });
        };

        return {
            currentPage,
            formatDate,
            truncateContent,
            handlePageChange,
            handleSizeChange,
        };
    },
};
</script>