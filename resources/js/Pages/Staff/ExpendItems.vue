<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('welcome') }}
          ..
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <ExpendHeader :expend="expend"/>
        </div>
        <a-divider/>

        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary" @click="createRecord()" :disabled="expend.is_locked || expend.is_closed">Create</a-button>
          <a-table :dataSource="expend.items" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <!-- <a-button :href="route('staff.fund.expends.edit',{fund:record.fund_id,expend:record.id})" >Edit</a-button> -->
              </template>
              <template v-else>
                {{ record[column.dataIndex] }}
              </template>
            </template>
          </a-table>
        </div>
      </div>

            <!-- Modal Start-->
            <a-modal v-model:open="modal.isOpen" :title="modal.title" width="60%">
        <a-form
          ref="modalRef"
          :model="modal.data"
          name="Teacher"
          :label-col="{ span: 8 }"
          :wrapper-col="{ span: 16 }"
          autocomplete="off"
          :rules="rules"
          :validate-messages="validateMessages"
        >
          <a-form-item label="Account" name="fund_item_account_id">
            <a-select v-model:value="modal.data.fund_item_account_id" :options="accounts"/>
          </a-form-item>
          <a-form-item label="Description" name="description">
            <a-input v-model:value="modal.data.description" />
          </a-form-item>
          <a-form-item label="Amount" name="amount" >
            <a-input v-model:value="modal.data.amount" :disabled="modal.data.fund_item_account_id==null || modal.data.description==null"/>
          </a-form-item>
          <a-form-item label="Remark" name="remark">
            <a-textarea v-model:value="modal.data.remark" />
          </a-form-item>
        </a-form>
        <template #footer>
          <a-button
            v-if="modal.mode == 'EDIT'"
            key="Update"
            type="primary"
            @click="updateRecord()"
            >Update</a-button
          >
          <a-button
            v-if="modal.mode == 'CREATE'"
            key="Store"
            type="primary"
            @click="storeRecord()"
            >Add</a-button
          >
        </template>
      </a-modal>
      <!-- Modal End-->

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
    props: ["expend","availableAccounts"],
    data() {
      return {
        accounts:[],
        modal: {
          isOpen: false,
          data: {},
          title: "Modal",
          mode: "",
        },
        columns: [
          {
            title: "Description",
            i18n: "description",
            dataIndex: "description",
          },{
            title: "Amount",
            i18n: "amount",
            dataIndex: "amount",
          },
        ],
        rules: {
          fund_item_account_id: { required: true },
          description: { required: true },
          amount: { required: true, validator: this.validateAmount, trigger: 'blur'},
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
      this.accounts=this.availableAccounts.map(a=> ({
          value:a.id,
          label:a.account_code+' '+a.description+' ('+a.available+')'
        })
      )
      console.log(this.accounts);
    },
    methods: {
      createRecord(){
        this.modal.data = {}
        this.modal.data.expend_id = this.expend.id
        this.modal.mode = "CREATE"
        this.modal.title = "create"
        this.modal.isOpen = true
      },
      editRecord(record){
        this.modal.data = {...record}
        this.modal.mode = "CREATE"
        this.modal.title = "create"
        this.modal.isOpen = true
      },
      storeRecord() {
        this.$refs.modalRef
          .validateFields()
          .then(() => {
            this.$inertia.post(route("staff.expend.items.store",this.expend.id), this.modal.data, {
              onSuccess: (page) => {
                this.modal.data = {};
                this.modal.isOpen = false;
              },
              onError: (err) => {
                console.log(err);
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
          route("staff.expend.items.update", this.modal.data.id),this.modal.data,{
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
      }
    },
  };
  </script>
  