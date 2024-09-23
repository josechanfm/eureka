<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary" class="float-right m-5" :href="route('admin.funds.create')">{{ $t('create') }}</a-button>
          <a-table :dataSource="funds" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button :href="route('admin.funds.edit',record.id)" >{{ $t('edit') }}</a-button>
                <a-button :href="route('admin.fund.expends.index',record.id)" type="edit">{{ $t('expend_item') }}</a-button>
                <a-button :href="route('admin.funds.show',record.id)" >{{ $t('expend_summary') }}</a-button>
                <a-button :href="route('admin.fund.export',record.id)">{{ $t('export') }}</a-button>
                <a-button @click="toggleClose(record)">
                  <span v-if="record.is_closed">{{ $t('reopen') }}</span>
                  <span v-else>{{ $t('archive') }}</span>
                </a-button>

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
        labelCol: {
          style: {
            width: "150px",
          },
        },
      };
    },
    created() {
    },
    computed:{
      columns(){
        return [
          {
            title: this.$t('project_title'),
            i18n: "title",
            dataIndex: "title",
          },{
            title: this.$t('operation'),
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
          },
        ]
      }
    },
    mounted(){

    },
    methods: {
      toggleClose(record){
        this.$inertia.post(route('admin.fund.toggleClose',record.id));
      }

    },
  };
  </script>
  