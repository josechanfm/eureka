<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t('budget_proposal') }}
      </h2>
    </template>
    <div class="container mx-auto pt-5">
      <!-- <FundHeader :fund="fund" /> -->
      <a-divider />
      <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <a-form :model="expend" name="expend" :label-col="labelCol" autocomplete="off" :rules="rules"
              :validate-messages="validateMessages" @finish="onFinish" enctype="multipart/form-data">
        <a-row>
          <a-col :span="12">
              <!-- <a-form-item :label="$t('budgets')" name="budget_id">
                <a-select v-model:value="expend.budget_id" :options="budgets" :fieldNames="{value:'id',label:'title'}"/>
              </a-form-item> -->
              <a-form-item :label="$t('expend_title')" name="title">
                <a-input v-model:value="expend.title" />
              </a-form-item>
              <a-form-item :label="$t('expend_number')" name="number">
                <a-input v-model:value="expend.number" />
              </a-form-item>
              <a-form-item :label="$t('expend_date')" name="date">
                <a-input v-model:value="expend.date" />
              </a-form-item>
              <a-form-item :label="$t('expend_remark')" name="remark">
                <a-textarea v-model:value="expend.remark" />
              </a-form-item>
          </a-col>
          <a-col :span="12">
            <a-table :dataSource="budget.items" :columns="columnBudgetItems" :pagination="false"/>
          </a-col>
        </a-row>
        <a-button @click="addItem()" type="primary">Add item</a-button>
        <table width="100%" border="1">
          <thead>
            <tr>
              <th>Description</th>
              <th>Amount</th>
              <th>Remark</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, itemIdx) in expend.items">
                <td>
                  <a-input v-model:value="item.description" />
                </td>
                <td>
                  <a-input v-model:value="item.amount" />
                </td>
                <td>
                  <!-- <a-select 
                    v-model:value="item.budget_item_id" 
                    :options="budgets.find(b=>b.id==expend.budget_id).items" 
                    :fieldNames="{value:'id',label:'description'}"
                    :style="{width:'100%'}"
                  /> -->
                </td>
                <td>
                  <a-button @click="removeItem(itemIdx)" danger>Delete</a-button>
                </td>
            </tr>

          </tbody>
        </table>
        <div class="flex flex-row item-center justify-center gap-5 pt-5">
          <a-button :href="route('admin.budget.expends.index',expend.budget_id)">{{ $t('back') }}</a-button>
          <a-button type="primary" html-type="submit">
            <span v-if="expend.id">
              {{ $t('update') }}
            </span>
            <span v-else>
              {{ $t('save') }}
            </span>
          </a-button>

        </div>
      </a-form>

      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import FundHeader from "@/Pages/Staff/FundHeader.vue";
import { message } from 'ant-design-vue';

export default {
  components: {
    AdminLayout,
    FundHeader,
  },
  props: ["budget", "expend"],
  data() {
    return {
      dateFormat: 'YYYY-MM-DD',
      columnBudgetItems:[
        {
          title:'Description',
          dataIndex:'description'
        },
        {
          title:'Amount',
          dataIndex:'amount'
        },{
          title:'Account Code',
          dataIndex:'account_code'
        },
        {
          title:'Reference code',
          dataIndex:'reference_code'
        }
      ],
      rules: {
        title: { required: true },
      },
      validateMessages: {
        required: "${label} is required!",
        types: {
          email: "${label} is not a valid email!",
          number: "${label} is not a valid number!",
        },
        number: {
          range: "${label} must be between ${min} and ${max}",
        },
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
  computed: {
    budgetItems(){
      if(this.expend.budget_id){
        return this.budgets.find(b=>b.id==this.expend.budget_id).items

      }
    }
  },
  methods: {
    addItem(){
      this.expend.items.push({
        'budget_item_id':this.budget.id,
        'description':'new item',
        'amount':'0',
        'remark':null
      })
    },
    removeItem(itemIdx){
      console.log(itemIdx)
      this.expend.items.splice(itemIdx,1);
    },
    onFinish(){
      if(this.expend.id){
        console.log('update');
            this.$inertia.patch(route("admin.budget.expends.update",{budget:this.expend.budget_id,expend:this.expend.id}), this.expend, {
              onSuccess: (page) => {
                console.log(page)
              },
              onError: (err) => {
                console.log(err);
              },
            });
      }else{
        console.log('store');
        this.$inertia.post(route("admin.budget.expends.store",this.expend.budget_id), this.expend, {
              onSuccess: (page) => {
                console.log(page)
              },
              onError: (err) => {
                console.log(err);
              },
            });

      }
      console.log(this.expend)
    }
  },
};
</script>