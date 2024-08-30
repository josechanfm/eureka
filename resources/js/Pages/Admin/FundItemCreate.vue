<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Funding
      </h2>
    </template>

    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <div class="float-right">
          <a-select v-model:value="catItemSelected" :style="{ width: '400px' }" class="mr-5">
            <a-select-option 
              v-for="item in category.items"
              :key="item.id"
              :value="item.id"
              :disabled="isDisabled(item.id)"
            >
              {{ item.name_zh }}
            </a-select-option>
          </a-select>
          <a-button @click="onAddCategoryItem()" type="primary">Add Section</a-button>
        </div>
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
            <template v-for="(catItem, i) in myCategoryItems">
              <tr>
                <td colspan="6">
                  {{ i + 1 }}. {{ catItem.name_zh }}
                </td>
              </tr>
              <template v-for="(item, itemIdx) in fund.items.filter(i => i.category_item_id == catItem.id)">
                <template v-if="item.accounts.length==1">
                  <tr>
                    <td width="50px" style="text-align: right;">{{ i + 1 }}.{{ itemIdx + 1 }}</td>
                    <td width="400px">
                      <a-select v-model:value="item.accounts[0].category_item_account_id" :options="catItem.accounts"
                        :fieldNames="{ value: 'id', label: 'name_zh' }" :style="{ width: '100%' }" />
                      <!-- <a-input v-model:value="item.accounts[0].description"/> -->
                    </td>
                    <td>
                      <a-input v-model:value="item.accounts[0].description"/>
                    </td>
                    <td width="60px">
                      <a-tooltip>
                        <template #title>Multiple Items</template>
                          <a-button @click="onMultipleAccounts(item, catItem)" type="info" size="small">*</a-button>
                      </a-tooltip>
                    </td>
                    <td width="200px">
                      <a-input v-model:value="item.accounts[0].amount" />
                    </td>
                    <td width="60px">
                      <a-tooltip>
                          <template #title>Add budget item</template>
                          <a-button @click="onAddItem(itemIdx, catItem, item)" type="info" size="small">+</a-button>
                      </a-tooltip>
                      <a-popconfirm title="Are you sure delete this task?" ok-text="Yes" cancel-text="No"
                              @confirm="onRemoveItem(itemIdx, catItem, item)" @cancel="() => { }">
                        <a-button type="danger" size="small">-</a-button>
                      </a-popconfirm>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr>
                    <td width="50px" style="text-align: right;">{{ i + 1 }}.{{ itemIdx + 1 }}</td>
                    <td colspan="3">
                      <table width="100%">
                        <tr v-for="(account, accountIdx) in item.accounts">
                          <td width="400px">
                            <a-select v-model:value="account.category_item_account_id" :options="catItem.accounts"
                              :fieldNames="{ value: 'id', label: 'name_zh' }" :style="{ width: '400px' }" />
                          </td>
                          <td>
                            <a-input v-model:value="account.description"/>
                          </td>
                          <td width="150px">
                            <a-input v-model:value="account.amount" />
                          </td>
                          <td width="60px">
                            <a-tooltip>
                              <template #title>Add budget item</template>
                              <a-button @click="onAddItemAccount(accountIdx, item, catItem)" type="info"
                                size="small">+</a-button>
                            </a-tooltip>
                              <a-popconfirm title="Are you sure delete this task?" ok-text="Yes" cancel-text="No"
                                @confirm="onRemoveItemAccount(accountIdx, item, catItem)" @cancel="() => { }">
                                <a-tooltip>
                                  <template #title>Remove budget item</template>
                                  <a-button type="danger" size="small">-</a-button>
                                </a-tooltip>
                            </a-popconfirm>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td>
                      <a-input v-model:value="item.account"/>
                    </td>
                    <td>
                      <a-button @click="onAddItem(itemIdx, catItem, item)" type="info" size="small">+</a-button>
                        <a-popconfirm title="Are you sure delete this task?" ok-text="Yes" cancel-text="No"
                          @confirm="onRemoveItem(itemIdx, catItem, item)" @cancel="() => { }">
                          <a-tooltip>
                            <template #title>Remove budget item</template>
                            <a-button type="danger" size="small">-</a-button>
                          </a-tooltip>
                        </a-popconfirm>
                    </td>
                  </tr>
                </template>
              </template>
              <tr>
                <td colspan="3" style="text-align: right;">小計</td>
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
      myCategoryItems:[],
      catItemSelected: this.category.items[0].id,
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
  mounted(){
    const uniqueCatItems = this.fund.items.reduce((acc, obj) => {
        if (!acc.includes(obj.category_item_id)) {
            acc.push(parseInt(obj.category_item_id));
        }
        return acc;
    }, []);
    this.myCategoryItems=this.category.items.filter(i=>uniqueCatItems.includes(i.id));
  },
  computed() {
  },
  methods: {
    isDisabled(id){
      if(this.myCategoryItems){
        return this.myCategoryItems.find(i=>i.id==id)
      }
      return false
     
    },
    onAddCategoryItem() {
      const catItem = this.category.items.find(i => i.id == this.catItemSelected);
      this.myCategoryItems.push(catItem);
      this.fund.items.push({
        'fund_id': this.fund.id,
        'category_item_id': this.catItemSelected,
        'accounts': [{
          'category_item_account_id': catItem.accounts[0].id,
          'account_code': ''
        }]
      });
    },
    onMultipleAccounts(item, catItem) {
      item.accounts.push({
        category_item_account_id: catItem.accounts[0].id
      })
    },
    onAddItem(itemIdx, catItem, fundItem) {
      this.fund.items.splice(this.fund.items.indexOf(fundItem) + 1, 0, {
        "fund_id": fundItem.fund_id,
        "category_item_id": catItem.id,
        "description": 'xx',
        "amount": 123,
        "accounts": [
          {
            "fund_item_id": fundItem.id,
            "category_item_account_id": catItem.accounts[0].id
          }
        ]
      })
    },
    onRemoveItem(itemIdx, catItem, fundItem) {
      this.fund.items.splice(this.fund.items.indexOf(fundItem), 1)
    },
    onAddItemAccount(accountIdx, item, catItem) {
      item.accounts.splice(accountIdx + 1, 0, { 'category_item_account_id': catItem.accounts[0].id })
      //item.accounts.push({})
    },
    onRemoveItemAccount(accountIdx, item, catItem) {
      item.accounts.splice(accountIdx, 1)
    },
    onFinish() {
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
<style scoped>
table td,
tr {
  border: 1px solid lightgray
}
</style>
