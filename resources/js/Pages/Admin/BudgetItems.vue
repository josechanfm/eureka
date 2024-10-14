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
              <template v-if="column.dataIndex == 'operation'">
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
              <template v-else-if="column.dataIndex=='account_code'">
                <template v-if="editableData.id==record.id">
                  <a-input v-model:value="editableData.account_code" v-if="editableData.user_define"/>
                  <a-select v-model:value="editableData.category_item_account_id" :options="editableData.options" :style="{'width':'100%'}" @change="onChangeAccountCode"/>
                </template>
                <template v-else>
                  {{ record.category_item_account_code}}
                </template>
              </template>
              <!-- <template v-if="column.dataIndex=='actual'">
                <template v-if="editableData.id==record.id">
                  <a-input v-model:value="editableData.actual"/>
                </template>
              </template> -->
              <template v-else-if="column.dataIndex=='fund_item_split'">
                {{ record.split.item.description }}<br>
                {{ record.split.description }}<br>
              </template>
              <template v-else-if="column.dataIndex=='expend'">
                {{ sumExpends(record) }}
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
import CategoryItems from "./CategoryItems.vue";
  
  export default {
    components: {
      AdminLayout,
      BudgetHeader
    },
    props: ["categoryItems","budget","availableSplits"],
    data() {
      return {
        splits:[],
        editableData:{
          id:null,
          category_item_account_id:null,
          account_code:null,
          actual:null,
          options:null,
          user_define:false
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
            dataIndex: "fund_item_split",
          },{
            title: this.$t('budget_item_description'),
            dataIndex: "description",
          },{
            title: this.$t('account_code'),
            dataIndex: "account_code",
          },{
            title: this.$t('reference_code'),
            dataIndex: "reference_code",
          },{
            title: this.$t('amount'),
            dataIndex: "amount",
          },{
            title: this.$t('expend_accumulated'),
            dataIndex: "expend",
          },{
            title: this.$t('operation'),
            i18n: "operation",
            dataIndex: "operation",
          },
        ]
      }
    },

    methods: {
      onChangeAccountCode(categoryItemAccountid){
        const account=this.editableData.options.find(option=>option.value==categoryItemAccountid);
        this.editableData.account_code=account.user_define?account.account_code:null
        this.editableData.user_define=account.user_define
      },
      sumExpends(record){
        return record.expend_items.reduce((a, c) => a + parseInt(c.amount), 0).toLocaleString()
      },
      onEditRecord(record){
        const categoryItemAccounts=this.categoryItems.find(item=>item.id==record.split.item.category_item_id).accounts
        this.editableData={...record}
        this.editableData.user_define=categoryItemAccounts.find(account=>account.id==record.category_item_account_id)?.user_define
        this.editableData.options=categoryItemAccounts.map(a=>({
          value:a.id, 
          label:a.name_zh+a.account_code,
          account_code:a.account_code,
          user_define:a.user_define
        }))
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
        this.editableData={id:null, account_code:null,actual:0}
      },
    },
  };
  </script>
  