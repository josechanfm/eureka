<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <ExpendHeader :expend="expend"/>
        </div>
        <div class="container mx-auto pt-5">
          <div class="bg-white relative shadow rounded-lg md:p-5">
            <table width="100%" border="1">
              <tr>
                <th>#</th>
                <th>Description</th>
                <th>amount</th>
                <th>fund item account id</th>
              </tr>
              <tr v-for="(item, idx) in expend.items">
                <td>{{ idx+1 }}</td>
                <td>{{ item.description }}</td>
                <td>{{ item.amount }}</td>
                <td>{{ getFundItemAccount(item.fund_item_account_id) }}</td>
              </tr>
            </table>
          </div>
        </div>
        <a-divider/>
        
        <div class="container mx-auto pt-5">
          <div class="bg-white relative shadow rounded-lg md:p-5">
            <div class="flex items-center gap-5 p-5">
              <table width="100%">
                <tr>
                  <td width="50px">
                    <a-select v-model:value="selectedAccount.itemId" :style="{width:'200px'}" :options="categoryItems" :fieldNames="{value:'id',label:'name_zh'}"/>
                  </td>
                <td>
                  <a-input v-model:value="selectedAccount.description" width="100%"/>
                </td>
                <td width="100px">
                  <a-input v-model:value="selectedAccount.amount" width="100%"/>
                </td>
                <td width="20px">
                  <a-button type="primary" @click="onAddAccountItem()">Add</a-button>
                </td>
              </tr>
              <tr>
                <td></td>
                <td colspan="3">{{ selectedAccount.name }}</td>
              </tr>
              </table>
              
            </div>
            <table width="100%" border="1">
            <tr>
              <th>#</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Available</th>
            </tr>
            <tr v-for="(item, idx) in fund.items.filter(item=>item.category_item_id==selectedAccount.itemId)">
              <td>{{ selectedAccount.itemId }}.{{ idx+1 }}</td>
              <td>
                <template v-if="item.accounts.length==1">
                  {{ item.accounts[0].description }}
                  {{ item.accounts[0].account_code }}
                  <input type="radio" v-model="selectedAccount.accountId" :value="item.accounts[0].id" style="width:30px" @change="onChnageSelectedAccount(item.accounts[0])">Select</input>
                </template>
                <template v-else>
                  <table width="100%" border="1">
                    <tr v-for="account in item.accounts">
                      <td>
                        {{ account.description }}
                        {{ account.account_code }}
                      </td>
                      <td>{{ account.amount }}</td>
                    </tr>
                  </table>
                </template>
              </td>
              <td>
                  {{ item.amount }}
              </td>
              <td>
                {{ budgetAvailable(item) }}
              </td>
            </tr>
            </table>
          </div>
        </div>
      </div>


    </AdminLayout>
  </template>
  

  <script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import ExpendHeader from "@/Pages/Staff/ExpendHeader.vue";

  export default {
    components: {
      AdminLayout,
      ExpendHeader
    },
    props: ["categoryItems","fund","expend","availableAccounts"],
    data() {
      return {
        selectedAccount:{
          itemId:null,
          accountId:null,
          name:null,
          description:null,
        },
      };
    },
    created() {
    },
    methods: {
      storeRecord() {
        this.$refs.modalRef
          .validateFields()
          .then(() => {
            this.$inertia.post(route("staff.expend.items.store",this.expend.id), this.selectedAccount, {
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
        console.log(this.modal.data);
        this.$inertia.patch(
          route("staff.expend.items.update", {expend:this.expend.id, item:this.modal.data.id}),this.modal.data,{
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
        console.log('validating amount');
        const account=this.availableAccounts.find(a=>a.id==this.modal.data.fund_item_account_id)
        console.log(account.available)  
        console.log(this.modal.data.amount);

        const value=account.available-this.modal.data.amount
        return new Promise((resolve, reject)=>{
          if (value<0) {
            reject(new Error('Budget limit exceeded. remains:'+account.available));
            // } else if (value.length < 3) {
            //   callback(new Error('Username must be at least 3 characters long.'));
          } else {
            resolve();
          }

        })
      },
      onChangeAmount(){
        const account=this.availableAccounts.find(a=>a.id==this.modal.data.fund_item_account_id)
        console.log(account.available)  
        console.log(this.modal.data.amount);
        console.log(account.available-this.modal.data.amount)  
      },
      getFundItemAccount(fundItemAccountId){
        const item=this.availableAccounts.find(a=>a.id==fundItemAccountId)
        return item.description+" "+item.account_code
      },
      budgetAvailable(item){
        if(item.accounts.length==1){
          return this.availableAccounts.find(a=>a.id==item.accounts[0].id).available
        }else{
          return '---'
        }
        
      },
      onChnageSelectedAccount(account){
        this.selectedAccount.name=account.description
      },
      onAddAccountItem(){
        console.log(this.selectedAccount);
        this.$inertia.post(route("staff.expend.items.store",this.expend.id), this.selectedAccount, {
            onSuccess: (page) => {
              console.log(page)
            },
            onError: (err) => {
              console.log(err)
            },
          });
      }
    },
  };
  </script>
  