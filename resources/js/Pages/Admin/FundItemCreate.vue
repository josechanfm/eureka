<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Funding
      </h2>
    </template>

    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <a-form :model="fund.items" name="fund" :label-col="labelCol" autocomplete="off" :rules="rules"
          :validate-messages="validateMessages" @finish="onFinish" enctype="multipart/form-data">
          <!-- <a-form-item label="支助項目分類" name="category">
            <a-select v-model:value="items.fund_category_id" :options="fundCategory.items" :fieldNames="{value:'id',label:'name_zh'}"/>
          </a-form-item> -->
          <table width="100%">
            <tr>
              <th>序號</th>
              <th>支出項目</th>
              <th>批准金額</th>
              <th></th>
            </tr>
            <template v-for="(catItem, i) in category.items">
              <tr>
                <td colspan="3">
                  {{ i + 1 }}. {{ catItem.name_zh }}
                  <a-button @click="onModifyItems(catItem,fund)" class="float-right ant-btn-primary">Modify</a-button>
                </td>
              </tr>
              <template v-for="(item, itemIdx) in fund.items">
                <template v-if="catItem.id == item.category_item_id">
                  <template v-if="item.accounts.length>1">
                    <tr>
                    <td width="50px" style="text-align: right;">{{ i + 1 }}.{{ itemIdx + 1 }}</td>
                    <td width="80%">
                      <table width="100%">
                        <tr v-for="(account, accountIdx) in item.accounts">
                          <td>
                            <a-select 
                              v-model:value="account.category_item_account_id" 
                              :options="catItem.accounts" 
                              :fieldNames="{value:'id',label:'name_zh'}" 
                              :style="{width:'400px'}"
                            />

                          </td>
                          <td width="150px">
                            <a-input v-model:value="account.amount"/>
                          </td>
                          <td><a-button @click="onAddItemAccount(accountIdx, item)">+</a-button></td>
                        </tr>
                      </table>
                    </td>
                    <td>
                      <a-input v-model:value="item.amount"/>
                    </td>
                    <td>
                      <a-button @click="onAddItem(itemIdx, catItem, item)">+</a-button>
                    </td>
                  </tr>
                  </template>
                  <template v-else-if="item.accounts.length>0">
                    <tr>
                    <td width="50px" style="text-align: right;">{{ i + 1 }}.{{ itemIdx + 1 }}</td>
                    <td width="80%">
                      <a-select 
                        v-model:value="item.accounts[0].category_item_account_id" 
                        :options="catItem.accounts" 
                        :fieldNames="{value:'id',label:'name_zh'}" 
                        :style="{width:'400px'}"
                      />
                      <!-- <a-input v-model:value="item.accounts[0].description"/> -->
                    </td>
                    <td>
                      <a-input v-model:value="item.accounts[0].amount"/>
                      
                    </td>
                    <td>
                      <a-button @click="onAddItem(catItem, item)">+</a-button>
                    </td>
                  </tr>

                  </template>
                </template>
              </template>
              <tr>
                <td colspan="2" style="text-align: right;">小計</td>
                <td>xxx</td>
              </tr>
            </template>
          </table>
          <div class="flex flex-row item-center justify-center">
            <a-button type="primary" html-type="submit">Submit</a-button>
          </div>
        </a-form>
      </div>
    </div>
      <!-- Modal Start-->
      <a-modal v-model:open="modal.isOpen" :title="modal.title" width="60%">
        <template v-for="item in modal.items">
          <template v-for="account in item.accounts">
            <a-row>
              <a-col :span="16">
                {{ account.description }}
              </a-col>
              <a-col :span="6">
                {{ account.amount }}
              </a-col>
              <a-col :span="2">

              </a-col>
            </a-row>
          </template>
        </template>
        <hr>
        <a-row>
            <a-col :span="16">
              <a-select 
                v-model:value="modal.catItemAccountId" 
                :options="modal.catItem.accounts" 
                :fieldNames="{value:'id',label:'name_zh'}" 
                style="width:400px"
              />
            </a-col>
            <a-col :span="6">
              <a-input v-model:value="modal.amount"/>
            </a-col>
            <a-col :span="2">
              <a-button @click="addFundItem()">Add</a-button>
            </a-col>
          </a-row>

      </a-modal>
    
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { defineComponent, reactive } from "vue";

export default {
  components: {
    AdminLayout,
  },
  props: ["fund", "category"],
  data() {
    return {
      modal:{
        isOpen:false,
        catItem:null,
        items:null
      },
      rules: {
        name: { required: true },
        email: { required: true, type: "email" },
        password: { required: true },
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
      // wrapperCol{

      // }
    };
  },
  created() {

  },
  computed() {
  },
  methods: {
    onAddItem(itemIdx, catItem,fundItem){
      console.log('onAddItem'+itemIdx)
      console.log(catItem)
      console.log(fundItem)
      console.log(this.fund.items)
      this.fund.items.push({
        "fund_id":fundItem.fund_id,
        "category_item_id":catItem.id,
        "description":'xx',
        "amount":123,
        "accounts":[
          {"fund_item_id":fundItem.id}
        ]
      })
    },
    onAddItemAccount(accountIdx, item){
      console.log('onAddItemAccount'+accountIdx)
      item.accounts.push({})
    },
    onModifyItems(catItem, fund) {
      this.modal.isOpen=true
      this.modal.catItem=catItem
      this.modal.fund_id=fund.id
      this.modal.items=fund.items.filter(i=>i.category_item_id==catItem.id)
    },
    // addFundItem(){
    //   console.log('addFundItem')
    //   let catAccount=this.modal.catItem.accounts.find(a=>a.id==this.modal.catItemAccountId)
    //   let fundItemAccount={
    //     "description":catAccount.name_zh,
    //     "account_code":catAccount.account_code,
    //     "amount":this.modal.amount

    //   }

    //   this.modal.items.push({
    //     "fund_id":this.modal.fund_id,
    //     "category_item_id":catAccount.category_item_id,
    //     "accounts":fundItemAccount
    //   });
      
      // this.modal.items.push({
      //   "fund_id":fundItem.id,
      //   "category_item_id":fundItem.category_item_id
      // })
      // console.log(fundItem);
      // let account=this.modal.catItem.accounts.find(a=>a.id==this.modal.catItemAccountId)
      // //console.log(account);

      // fundItem.accounts.push({
      //   "fund_item_id":fundItem.id,
      //   "account_code":account.account_code,
      //   "description":account.name_zh,
      //   "amount":this.modal.amount
      // });
    //},
    onFinish() {
      console.log(this.fund);
      this.$inertia.post(route("admin.fund.items.store", this.fund.id), this.fund.items, {
        onSuccess: (page) => {
          console.log(page);
        },
        onError: (error) => {
          console.log(error);
        },
      });
    }
  },
};
</script>
<style>
table td,
tr {
  border: 1px solid black
}
</style>
