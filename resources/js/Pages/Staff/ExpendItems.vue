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
                <th>fund item split id</th>
              </tr>
              <tr v-for="(item, idx) in expend.items">
                <td>{{ idx+1 }}</td>
                <td>{{ item.description }}</td>
                <td>{{ item.amount }}</td>
                <td>{{ getFundItemSplit(item.fund_item_split_id) }}</td>
              </tr>
            </table>
          </div>
        </div>
        <a-button type="primary" @click="onSaveExpendItems">Save</a-button>
        <a-divider/>
        
        <div class="container mx-auto pt-5">
          <div class="bg-white relative shadow rounded-lg md:p-5">
            <div class="flex items-center gap-5 p-5">
              <table width="100%">
                <tr>
                  <td width="50px">
                    <a-select v-model:value="selectedSplit.itemId" :style="{width:'200px'}" :options="categoryItems" :fieldNames="{value:'id',label:'name_zh'}"/>
                  </td>
                <td>
                  <a-input v-model:value="selectedSplit.description" width="100%"/>
                </td>
                <td width="100px">
                  <a-input v-model:value="selectedSplit.amount" width="100%"/>
                </td>
                <td width="20px">
                  <a-button type="primary" @click="onAddSplitItem()">Add</a-button>
                </td>
              </tr>
              <tr>
                <td></td>
                <td colspan="3">{{ selectedSplit.name }}</td>
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
            <tr v-for="(item, idx) in fund.items.filter(item=>item.category_item_id==selectedSplit.itemId)">
              <td>{{ selectedSplit.itemId }}.{{ idx+1 }}</td>
              <td>
                <template v-if="item.splits.length==1">
                  {{ item.splits[0].description }}
                  <input type="radio" v-model="selectedSplit.splitId" :value="item.splits[0].id" style="width:30px" @change="onChnageSelectedSplit(item.splits[0])">Select</input>
                </template>
                <template v-else>
                  <table width="100%" border="1">
                    <tr v-for="split in item.splits">
                      <td>
                        {{ split.description }}
                      </td>
                      <td>{{ split.amount }}</td>
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
    props: ["categoryItems","fund","expend","availableSplits"],
    data() {
      return {
        selectedSplit:{
          itemId:null,
          splitId:null,
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
            this.$inertia.post(route("staff.expend.items.store",this.expend.id), this.selectedSplit, {
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
        const split=this.availableSplits.find(a=>a.id==this.modal.data.fund_item_split_id)
        console.log(split.available)  
        console.log(this.modal.data.amount);

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
        console.log(split.available)  
        console.log(this.modal.data.amount);
        console.log(split.available-this.modal.data.amount)  
      },
      getFundItemSplit(fundItemSplitId){
        const item=this.availableSplits.find(a=>a.id==fundItemSplitId)
        return item.description
      },
      budgetAvailable(item){
        if(item.splits.length==1){
          return this.availableSplits.find(a=>a.id==item.splits[0].id).available
        }else{
          return '---'
        }
        
      },
      onChnageSelectedSplit(split){
        this.selectedSplit.name=split.description
      },
      onAddSplitItem(){
        console.log(this.selectedSplit);
        this.expend.items.push({
          'expend_id':this.expend.id,
          'fund_item_split_id':this.selectedSplit.itemId,
          'description':this.selectedSplit.description,
          'amount':this.selectedSplit.amount

        });
        // this.$inertia.post(route("staff.expend.items.store",this.expend.id), this.selectedSplit, {
        //     onSuccess: (page) => {
        //       console.log(page)
        //     },
        //     onError: (err) => {
        //       console.log(err)
        //     },
        //   });
      },
      onSaveExpendItems(){
        console.log(this.expend);
        this.$inertia.post(route("staff.expend.items.store",this.expend.id), this.expend.items, {
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
  