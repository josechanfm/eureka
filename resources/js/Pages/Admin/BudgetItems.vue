<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('budget_item') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <BudgetHeader :budget="budget"/>
        <a-divider/>
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="budget.items" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex=='account_code'">
                <template v-if="editableData.id==record.id">
                  <a-input v-model:value="editableData.account_code"/>
                </template>
              </template>
              <!-- <template v-if="column.dataIndex=='actural'">
                <template v-if="editableData.id==record.id">
                  <a-input v-model:value="editableData.actural"/>
                </template>
              </template> -->
              <template v-else-if="column.dataIndex=='fund_item_split'">
                {{ record.split.item.description }}<br>
                {{ record.split.description }}
              </template>
              <template v-else-if="column.dataIndex == 'operation'">
                <div>
                  <template v-if="editableData.id==record.id">
                    <a-button @click="onSaveRecord(record)" type="save">{{ $t('save') }}</a-button>
                  </template>
                  <template v-else>
                    <a-button @click="onEditRecord(record)">{{ $t('edit') }}</a-button>
                  </template>
                </div>
                <!-- <a-button :href="route('admin.fund.budgets.edit',{fund:record.fund_id,budget:record.id})" >Edit</a-button> -->
              </template>
            </template>
          </a-table>
        </div>
      </div>
    </AdminLayout>
  </template>
  

  <script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import BudgetHeader from "@/Pages/Staff/BudgetHeader.vue";
  
  export default {
    components: {
      AdminLayout,
      BudgetHeader
    },
    props: ["budget","availableSplits"],
    data() {
      return {
        splits:[],
        editableData:{
          id:null,
          account_code:null,
          actural:null
        },
        labelCol: {
          style: {
            width: "150px",
          },
        },
      };
    },
    created() {
      this.splits=this.availableSplits.map(a=> ({
          value:a.id,
          label:a.account_code+' '+a.description+' ('+a.available+')'
        })
      )
    },
    computed:{
      columns(){
        return[
          {
            title: this.$t('funding_description'),
            i18n: "fund_item_split",
            dataIndex: "fund_item_split",
          },{
            title: this.$t('budget_item_description'),
            i18n: "description",
            dataIndex: "description",
          },{
            title: this.$t('account_code'),
            i18n: "account_code",
            dataIndex: "account_code",
          },{
            title: this.$t('reference_code'),
            i18n: "reference",
            dataIndex: "reference_code",
          },{
            title: this.$t('amount'),
            i18n: "amount",
            dataIndex: "amount",
          },{
            title: this.$t('operation'),
            i18n: "operation",
            dataIndex: "operation",
          },
        ]
      }
    },
    methods: {
      onEditRecord(record){
        this.editableData={...record}
      },
      onSaveRecord(record){
        this.$inertia.patch(
          route("admin.budget.items.update", {budget:this.budget.id, item:this.editableData.id}),this.editableData,{
            onSuccess: (page) => {
              console.log(page);
            },
            onError: (error) => {
              console.log(error);
            },
          }
        );
        this.editableData={id:null, account_code:null,actural:0}
      },
    },
  };
  </script>
  