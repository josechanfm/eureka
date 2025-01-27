<template>
    <StaffLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
          <BudgetHeader :budget="budget"/>
        <div class="container mx-auto pt-5">
          <div class="bg-white relative shadow rounded-lg md:p-5">
            <table width="100%" border="1">
              <thead>
                <tr>
                  <th>#</th>
                  <th width="500px">{{ $t('budget_item_title') }}</th>
                  <th>{{ $t('budget_item_description') }}</th>
                  <th width="150px">{{ $t('amount') }}</th>
                  <th>{{ $t('reference_code') }}</th>
                  <th>{{ $t('expend_accumulated') }}</th>
                  <th>{{ $t('operation') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, idx) in budget.items">
                  <td>{{ idx+1 }}</td>
                  <td>
                    <div>{{ getFundItemSplit(item.fund_item_split_id) }}</div>
                    <a-select v-model:value="item.account_code" :options="categoryItemAccountsByBudgetItem(item)" :style="{width:'500px'}" :disabled="disabledMode()"/>
                  </td>
                  <td>
                    <a-input v-model:value="item.description"  :disabled="disabledMode()"/>
                  </td>
                  <td>
                    <a-input v-model:value="item.amount"  :disabled="disabledMode()"/>
                  </td>
                  <td>{{item.reference_code}}</td>
                  <td>{{ sumExpendItems(item.expend_items) }}</td>
                  <td>
                    <a-popconfirm :title="$t('funding_remove_item')" ok-text="Yes" cancel-text="No"
                      @confirm="removeItem(idx)" @cancel="() => { }">
                      <a-button size="small" type="primary" danger>{{ $t('delete') }}</a-button>
                    </a-popconfirm>
                    <!-- <inertia-link :href="route('staff.budget.items.destroy',{budget:budget.id,item:item.id})">Delete</inertia-link> -->
                  </td>
                </tr>
                <tr>
                  <td colspan="3" style="text-align:right">{{ $t('total') }}</td>
                  <td>{{ grandTotal() }}</td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="pt-5">
          <span v-if="budget.status<='S2'">
            <a-button type="primary" @click="onSaveBudgetItems(false)">{{ $t('save') }}</a-button>
            <a-button type="primary" @click="onSaveBudgetItems(true)" class="ml-2">{{ $t('save_submit') }}</a-button>
          </span>
          <a-button class="ml-2" @click="printPdf()">Print PDF</a-button>
          <a-button :href="route('staff.fund.budgets.index',fund.id)" class="ml-2">{{ $t('back') }}</a-button>
        </div>
        <a-divider/>

        <div class="container mx-auto pt-5" v-if="budget.status<='S2'">
          <div class="bg-white relative shadow rounded-lg md:p-5">
            <a-button @click="onAddSplitItem2()" type="primary">{{ $t('add') }}</a-button>
            <div class="pt-5">
              <table width="100%" border="1">
                    <tr>
                      <th colspan="2">#</th>
                      <th width="100px">{{ $t('selection') }}</th>
                      <th>{{ $t('funding_description') }}</th>
                      <th>{{ $t('amount') }}</th>
                      <th>{{ $t('available') }}</th>
                    </tr>
                    <template v-for="(catItem, catItemIdx) in categoryItems">
                      <tr>
                        <td width="50px">{{ catItemIdx+1 }}</td>
                        <td width="50px"></td>
                        <td colspan="3">{{ catItem.name_zh }}</td>
                      </tr> 
                      <tr v-for="(item, idx) in fund.items.filter(item=>item.category_item_id==catItem.id)">
                        <td></td> 
                        <td>{{ catItemIdx+1 }}.{{ idx+1 }}</td>
                          <template v-if="item.splits.length==1">
                            <td>
                              <input type="radio" v-model="selectedSplit.splitId" :value="item.splits[0].id" style="width:30px" @change="onChnageSelectedSplit(catItem, item.splits[0])">{{ $t('select') }}</input>
                            </td>
                            <td>
                              {{ item.splits[0].description }}
                            </td>
                          </template>
                          <template v-else>
                            <td colspan="2">
                              <table width="100%" border="1">
                                <tr v-for="split in item.splits">
                                  <td width="100px">
                                    <input type="radio" v-model="selectedSplit.splitId" :value="split.id" style="width:30px" @change="onChnageSelectedSplit(catItem, split)">{{ $t('select') }}</input>
                                  </td>
                                  <td>
                                    {{ split.description }}
                                  </td>
                                  <td>{{ split.amount }}</td>
                                </tr>
                              </table>
                            </td>
                          </template>
                        <td>
                            {{ item.amount.toLocaleString() }}
                        </td>
                        <td>
                          {{ budgetAvailable(item).toLocaleString() }}
                        </td>
                      </tr>
                    </template>
              </table>
            </div>
          </div>
        </div>
        
      </div>


    </StaffLayout>
  </template>
  

  <script>
  import StaffLayout from "@/Layouts/StaffLayout.vue";
  import BudgetHeader from "@/Pages/Staff/BudgetHeader.vue";

  export default {
    components: {
      StaffLayout,
      BudgetHeader
    },
    props: ["categoryItems","fund","budget","availableSplits"],
    data() {
      return {
        selectedSplit:{
          catItemId:null,
          splitId:null,
          name:null,
          description:null,
        },
      };
    },
    created() {
    },
    computed:{
      // fundItemSplits(){
      //   const fundItems = this.fund.items.filter(i => i.category_item_id == this.selectedSplit.catItemId)
      //   let splits=[];
      //   fundItems.forEach(item=>{
      //     if(item.splits.length==1){
      //       splits.push({value:item.splits[0].id,label:item.splits[0].description})
      //     }else{
      //       item.splits.forEach(split=>{
      //         splits.push({value:split.id,label:split.description})
      //       })
      //     }
      //   })

      //   return splits;
      // },
    },
    methods: {
      printPdf(){
        alert("print to PDF");
      },
      disabledMode(){
        return (this.budget.status=='S1' || this.budget.status=='S2')?false:true
      },
      sumExpendItems(expendItems){
        return expendItems.reduce((a, c) => a + parseInt(c.amount), 0).toLocaleString()
      },
      categoryItemAccountsByBudgetItem(budgetItem){
        let categoryItemId=null;
        this.budget.fund.items.forEach(fundItem=>{
          if(categoryItemId) return ;
          fundItem.splits.forEach(split=>{
            if(split.id==budgetItem.fund_item_split_id){
              categoryItemId=fundItem.category_item_id;
            }
          })
        })
        const accounts = this.categoryItems.find(i => i.id == categoryItemId)?.accounts || [];
        return accounts.map(account => ({
            value: account.account_code,
            label: account.name_zh + ' ' + account.account_code
          })
        );
        // const accounts=[{value:'a',label:'aaa'}]
        // return accounts
      },
      categoryItemAccountsByCatItemId(catItemId){
        const accounts = this.categoryItems.find(i => i.id == catItemId)?.accounts || [];
        return accounts.map(account => ({
            value: account.account_code,
            label: account.name_zh + ' ' + account.account_code
          })
        );
        
          //return this.categoryItems.find(i=>i.id==this.selectedSplit.catItemId).accounts;
      },
      storeRecord() {
        this.$refs.modalRef
          .validateFields()
          .then(() => {
            this.$inertia.post(route("staff.budget.items.store",this.budget.id), this.selectedSplit, {
              onSuccess: (page) => {
                console.log(page)
              },
              onError: (err) => {
                console.log(err)
              },
            });
          })
          .catch((err) => {
            console.log(err);
          });
      },
      updateRecord() {
        this.$inertia.patch(
          route("staff.budget.items.update", {budget:this.budget.id, item:this.modal.data.id}),this.modal.data,{
            onSuccess: (page) => {
              this.modal.data = {};
              this.modal.isOpen = false;
              console.log(page);
            },
            onError: (error) => {
              console.log(error);
            },
          }
        );
      },
      validateAmount(){
        const split=this.availableSplits.find(a=>a.id==this.modal.data.fund_item_split_id)
        const value=split.available-this.modal.data.amount
        return new Promise((resolve, reject)=>{
          if (value<0) {
            reject(new Error('Budget limit exceeded. remains:'+split.available));
            // } else if (value.length < 3) {
            //   callback(new Error('Username must be at least 3 characters long.'));
          } else {
            resolve();
          }

        })
      },
      onChangeAmount(){
        const split=this.availableSplits.find(a=>a.id==this.modal.data.fund_item_split_id)
      },
      getFundItemSplit(fundItemSplitId){
        const item=this.availableSplits.find(a=>a.id==fundItemSplitId)
        return item?item.description:''
      },
      budgetAvailable(item){
        if(item.splits.length==1){
          return this.availableSplits.find(a=>a.id==item.splits[0].id).available
        }else{
          return '---'
        }
        
      },
      onChnageSelectedSplit(catItem, split){
        this.selectedSplit.id=split.id
        this.selectedSplit.catItemId=catItem.id
        this.selectedSplit.description=split.description
      },
      onAddSplitItem2(){
        let accounts=this.categoryItemAccountsByCatItemId(this.selectedSplit.catItemId);
        this.budget.items.push({
          'budget_id':this.budget.id,
          'fund_item_split_id':this.selectedSplit.splitId,
          'category_item_id':this.selectedSplit.catItemId,
          'account_code':accounts[0].value,
          'description':'--',
          'amount':0,
          'expend_items':[]
        });
      },
      onAddSplitItem(){
        this.budget.items.push({
          'budget_id':this.budget.id,
          'fund_item_split_id':this.selectedSplit.catItemId,
          'description':this.selectedSplit.description,
          'amount':this.selectedSplit.amount

        });
      },
      onSaveBudgetItems(toSubmit=false){
        this.$inertia.post(route("staff.budget.items.store",this.budget.id), 
        {toSubmit:toSubmit, items:this.budget.items},
        {
            onSuccess: (page) => {
              console.log(page)
            },
            onError: (err) => {
              console.log(err)
            },
          });
      },
      removeItem(itemIdx){
        console.log(itemIdx)
        this.budget.items.splice(itemIdx,1)
      },
      grandTotal(){
        const amounts = this.budget.items.map(i => i.amount);
        return amounts.reduce((sum,a)=>sum+parseInt(a),0).toLocaleString();
    },

    },
  };
  </script>
  