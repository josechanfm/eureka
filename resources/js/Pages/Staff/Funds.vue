<template>
    <StaffLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary" class="float-right m-5" :href="route('staff.funds.create',{id:selectedCategory})">{{ $t('create') }}</a-button>
          <a-select v-model:value="selectedCategory" :options="categories" :fieldNames="{value:'id',label:'title_zh'}" class="float-right m-5" style="width:200px"/>
          <a-table :dataSource="funds" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button :href="route('staff.funds.edit',record.id)">
                  <span v-if="record.is_submitted">
                    {{ $t('view') }}
                  </span>
                  <span v-else>
                    {{ $t('edit') }}  
                  </span>
                </a-button>
                <a-button :href="route('staff.fund.items.index',record.id)" type="fund">{{ $t('funding_items') }}</a-button>
                <a-button :href="route('staff.fund.expends.index',record.id)" type="expend" class="ml-5">{{ $t('expends') }}</a-button>
              </template>
              <template v-else-if="column.dataIndex=='is_submitted'">
                <span v-if="record.is_submitted">{{ $t('submitted') }}</span>
                <span v-else>{{ $t('preparing') }}</span>
              </template>
              <template v-else>
                {{ record[column.dataIndex] }}
              </template>
            </template>
          </a-table>
        </div>
      </div>
    </StaffLayout>
  </template>
  
  <script>
  import StaffLayout from "@/Layouts/StaffLayout.vue";
  import { defineComponent, reactive } from "vue";
  
  export default {
    components: {
      StaffLayout,
    },
    props: ["categories","funds"],
    data() {
      return {
        selectedCategory:this.categories[0].id,
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
        return[
          {
            title: this.$t('project_title'),
            i18n: "title",
            dataIndex: "title",
          },{
            title: this.$t('submitted'),
            i18n: "submitted",
            dataIndex: "is_submitted",
          },{
            title: this.$t('operation'),
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
          },
        ]
      }
    },
    methods: {
    },
  };
  </script>
  