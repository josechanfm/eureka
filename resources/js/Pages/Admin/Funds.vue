<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('admin') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary" class="float-right m-5" :href="route('admin.funds.create',{id:selectedCategory})">{{ $t('create') }}</a-button>
          <a-select v-model:value="selectedCategory" :options="categories" :fieldNames="{value:'id',label:'title_zh'}" class="float-right m-5" style="width:200px"/>

          <a-table :dataSource="funds" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <!-- <a-button :href="route('admin.funds.index')" :disabled="record.is_submitted==false || record.expends_count>0 || record.is_close==true">{{ $t('return') }}</a-button> -->
                 <template v-if="record.is_submitted">
                  <a-popconfirm :ok-text="$t('yes')" :cancel-text="$t('no')"
                      @confirm="toggleSubmit(record)" @cancel="() => { }">
                      <template #title>
                          <div v-html="$t('unlock_popup')"/>
                      </template>
                      <a-button type="primary" danger>{{ $t('unlock') }}</a-button>
                  </a-popconfirm>

                  <a-button @click="toggleSubmit(record)" >{{ $t('unlock') }}</a-button>
                 </template>
                 <template v-else>
                  <a-button :href="route('admin.funds.edit',record.id)" >{{ $t('edit') }}</a-button>
                 </template>
                <a-button :href="route('admin.fund.items.index',record.id)" type="fund">{{ $t('funding_items') }}</a-button>
                <a-button :href="route('admin.fund.expends.index',record.id)" type="expend">{{ $t('expend_item') }}</a-button>
                <a-button :href="route('admin.funds.show',record.id)" >{{ $t('expend_summary') }}</a-button>
                <a-button :href="route('admin.fund.export',record.id)">{{ $t('export') }}</a-button>

                <!-- <a-button @click="toggleSubmit(record)">
                  <span v-if="record.is_submitted">{{ $t('unlock') }}</span>
                  <span v-else>{{ $t('lock') }}</span>
                </a-button> -->

                <a-button @click="toggleClose(record)">
                  <span v-if="record.is_closed">{{ $t('reopen') }}</span>
                  <span v-else>{{ $t('archived') }}</span>
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
    props: ["categories","funds"],
    data() {
      return {
        selectedCategory:this.categories[0].id,        
        // modal: {
        //   isOpen: false,
        //   data: {},
        //   title: "Modal",
        //   mode: "",
        // },
        // labelCol: {
        //   style: {
        //     width: "150px",
        //   },
        // },
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
      toggleSubmit(record){
        this.$inertia.post(route('admin.fund.toggleSubmit',record.id));
      },
      toggleClose(record){
        this.$inertia.post(route('admin.fund.toggleClose',record.id));
      }

    },
  };
  </script>
  