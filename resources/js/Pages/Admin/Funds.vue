<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('welcome') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary" class="float-right m-5" :href="route('admin.funds.create')">Create</a-button>
          <a-table :dataSource="funds" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button @click="toggleClose(record)">
                  <span v-if="record.is_closed">Reopen</span>
                  <span v-else>Close</span>
                </a-button>
                <a-button :href="route('admin.fund.expends.index',record.id)" >Expends</a-button>
                <a-button :href="route('admin.funds.edit',record.id)" >Edit</a-button>
                <a-button :href="route('admin.funds.show',record.id)" >Summary</a-button>
              </template>
              <template v-else>
                {{ record[column.dataIndex] }}
              </template>
            </template>
          </a-table>
        </div>
      </div>
    </AdminLayout>
  </template>
  
  <script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import { defineComponent, reactive } from "vue";
  
  export default {
    components: {
      AdminLayout,
    },
    props: ["funds"],
    data() {
      return {
        modal: {
          isOpen: false,
          data: {},
          title: "Modal",
          mode: "",
        },
        teacherStateLabels: {},
        columns: [
          {
            title: "Title",
            i18n: "title",
            dataIndex: "title",
          },
          {
            title: "Operation",
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
          },
        ],
        labelCol: {
          style: {
            width: "150px",
          },
        },
      };
    },
    created() {
      
    },
    methods: {
      toggleClose(record){
        this.$inertia.post(route('admin.fund.toggleClose',record.id));
      }

    },
  };
  </script>
  