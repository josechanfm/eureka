<template>
  <StaffLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t('my_project') }}
      </h2>
    </template>
    <div class="container mx-auto pt-5">
        <FundHeader :fund="fund"/>
      <a-divider/>

      <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <a-form :model="fund.items" name="fund" :label-col="labelCol" autocomplete="off" :rules="rules"
          :validate-messages="validateMessages" @finish="onFinish(false)" enctype="multipart/form-data">
          <!-- <a-form-item label="支助項目分類" name="category">
            <a-select v-model:value="items.fund_category_id" :options="fundCategory.items" :fieldNames="{value:'id',label:'name_zh'}"/>
          </a-form-item> -->
          <table width="100%">
            <thead>
              <tr>
                <th>{{ $t('sequence') }}</th>
                <th>{{ $t('funding_items') }}</th>
                <th>{{ $t('amount') }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(catItem, i) in category.items">
                <tr>
                  <td colspan="5">
                    {{ i + 1 }}. {{ catItem.name_zh }}
                  </td>
                </tr>
                <template v-for="(item, itemIdx) in fund.items.filter(i => i.category_item_id == catItem.id)">
                  <template v-if="item.splits.length==1">
                    <tr>
                      <td width="50px" style="text-align: right;">{{ i + 1 }}.{{ itemIdx + 1 }}</td>
                      <td>
                        {{item.splits[0].description}}
                      </td>
                      <td width="200px">
                        {{  item.amount.toLocaleString() }}
                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr>
                      <td width="50px" style="text-align: right;">{{ i + 1 }}.{{ itemIdx + 1 }}</td>
                      <td colspan="2">
                        <table width="100%">
                          <tr v-for="(split, splitIdx) in item.splits">
                            <td>
                              {{ split.description }}
                            </td>
                            <td width="150px">
                            {{  split.amount?.toLocaleString() }}
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td width="150px">
                        {{ item.amount?.toLocaleString() }}
                      </td>
                    </tr>
                  </template>
                </template>
                <tr>
                  <td colspan="3" style="text-align: right;">{{ $t('sub_total') }}</td>
                  <td colspan="2">{{ subTotal(catItem) }}</td>
                </tr>
              </template>
              <tr>
                <td colspan="3" style="text-align: right;">{{ $t('grand_total') }}</td>
                <td colspan="2">{{ grandTotal() }}</td>
              </tr>
            </tbody>
          </table>
          <div class="flex flex-row item-center justify-center gap-5 pt-5">
            <a-button :href="route('staff.funds.index')">{{ $t('back') }}</a-button>
          </div>
        </a-form>
      </div>
    </div>
  </StaffLayout>
</template>

<script>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import FundHeader from "@/Pages/Staff/FundHeader.vue";

export default {
  components: {
    StaffLayout,
    FundHeader
  },
  props: ["fund", "category"],
  data() {
    return {
      myCategoryItems:[],
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
    // const uniqueCatItems = this.fund.items.reduce((acc, obj) => {
    //     if (!acc.includes(obj.category_item_id)) {
    //         acc.push(parseInt(obj.category_item_id));
    //     }
    //     return acc;
    // }, []);
    //this.myCategoryItems=this.category.items.filter(i=>uniqueCatItems.includes(i.id));
  },
  computed() {
  },
  methods: {
    subTotal(catItem){
      const items=this.fund.items.filter(i=>i.category_item_id==catItem.id)
      const amounts = items.map(i => i.amount);
      return amounts.reduce((sum,a)=>sum+parseInt(a),0).toLocaleString();
    },
    grandTotal(){
      const amounts = this.fund.items.map(i => i.amount);
      return amounts.reduce((sum,a)=>sum+parseInt(a),0).toLocaleString();
    },
    isDisabled(id){
      if(this.myCategoryItems){
        return this.myCategoryItems.find(i=>i.id==id)
      }
      return false
     
    },

    onMultipleSplits(item, catItem) {
      item.splits.push({
        //category_item_account_id: catItem.accounts[0].id
      })
    },
    onAddItem(catItem, fundItem) {
      this.fund.items.splice(this.fund.items.indexOf(fundItem) + 1, 0, {
        "fund_id": fundItem.fund_id,
        "category_item_id": catItem.id,
        "description": catItem.name_zh,
        "amount": 123,
        "splits": [
          {
            "fund_item_id": fundItem.id,
            "description":"new item"
            //"category_item_account_id": catItem.accounts[0].id
          }
        ]
      })
    },
    onRemoveItem(itemIdx, catItem, fundItem) {
      this.fund.items.splice(this.fund.items.indexOf(fundItem), 1)
    },
    onAddItemSplit(splitIdx, item, catItem) {
      item.splits.splice(splitIdx + 1, 0, {
        'description':'new item',
        'amount':0
      })
    },
    onRemoveItemSplit(splitIdx, item, catItem) {
      item.splits.splice(splitIdx, 1)
    },
    onAddCategoryItem(catItem){
      this.fund.items.push({
        "fund_id":this.fund.id,
        "category_item_id":catItem.id,
        "accounts":[{
          //"category_item_account_id":catItem.accounts[0].id,
          "account_code":catItem.accounts[0].account_code
        }]
      })
    },
    onFinish(submit=false) {
      this.$inertia.post(route("staff.fund.items.store", this.fund.id), {toSubmit:submit, items:this.fund.items}, {
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
table td, tr {
  border: 1px solid lightgray;
  padding: 0px;
}
</style>
