<template>
    <StaffLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="funds" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button :href="route('staff.funds.show',record.id)">
                    {{ $t('view') }}
                </a-button>
                <a-button :href="route('staff.fund.items.index',record.id)" type="fund">{{ $t('funding_items') }}</a-button>
                <a-button :href="route('staff.fund.budgets.index',record.id)" type="budget" class="ml-5">{{ $t('budgets') }}</a-button>
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
  