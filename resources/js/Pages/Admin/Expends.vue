<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('budget_proposal') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
          <!-- <FundHeader :fund="fund" /> -->
        <a-divider/>
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary">Add Expend</a-button>
          <a-table :dataSource="expends" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button :href="route('admin.expends.edit',record.id)" type="edit">{{ $t('expend_item') }}</a-button>
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
          <a-form-item :label="$t('budget_proposal')" name="title">
            <a-input v-model:value="modal.data.title" />
          </a-form-item>
          <a-form-item :label="$t('proposal_number')" name="proposal_number">
            <a-input v-model:value="modal.data.proposal_number" />
          </a-form-item>
          <a-form-item :label="$t('proposed_at')" name="proposed_at">
            <a-date-picker v-model:value="modal.data.proposed_at" :format="dateFormat" :valueFormat="dateFormat"/>
          </a-form-item>
          <a-form-item :label="$t('proposed_by')" name="proposed_by">
            <a-input v-model:value="modal.data.proposed_by"/>
          </a-form-item>
          <a-form-item :label="$t('approved_at')" name="approved_at">
            <a-date-picker v-model:value="modal.data.approved_at" :format="dateFormat" :valueFormat="dateFormat"/>
          </a-form-item>
          <a-form-item :label="$t('remark')" name="remark">
            <a-textarea v-model:value="modal.data.remark" />
          </a-form-item>
        </a-form>
        <template #footer>
          <a-button @click="modal.isOpen=false" class="mx-5">{{ $t('back') }}</a-button>
          <span v-role="['admin','dei']">
            <a-button
              v-if="modal.mode == 'EDIT'"
              key="Update"
              type="primary"
              @click="updateRecord()"
              >{{ $t('update') }}</a-button
            >
            <a-button
              v-if="modal.mode == 'CREATE'"
              key="Store"
              type="primary"
              @click="storeRecord()"
              >{{ $t('add') }}</a-button
            >
          </span>
        </template>
      </a-modal>
      <!-- Modal End-->
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
    props: ["fund","budgets","expends"],
    data() {
      return {
        dateFormat:'YYYY-MM-DD',
        modal: {
          isOpen: false,
          data: {},
          title: "Modal",
          mode: "",
        },
          teacherStateLabels: {},
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
    computed:{
      columns(){
        return[
          {
            title: this.$t('expend_title'),
            dataIndex: "title",
          },{
            title: this.$t('expend_number'),
            dataIndex: "number",
          },{
            title: this.$t('expend_date'),
            dataIndex: "date",
          },{
            title: this.$t('expend_item_amount'),
            dataIndex: "amount",
          },{
            title: this.$t('operation'),
            i18n: "operation",
            dataIndex: "operation",
            width: "250px",
            customCell:(text,record,index)=>({
              style:{minWidth: "250px"}
            })
          },
        ]
      }
    },
    methods: {
      createRecord(){
        this.modal.data = {}
        this.modal.data.fund_id=this.fund.id
        this.modal.mode = "CREATE"
        this.modal.title = this.$t('create')
        this.modal.isOpen = true
      },
      editRecord(record){
        this.modal.data = {...record}
        this.modal.mode = "EDIT"
        this.modal.title = this.$t('edit')
        this.modal.isOpen = true
      },
      viewRecord(record){
        this.modal.data = {...record}
        this.modal.mode = "VIEW"
        this.modal.title = "View"
        this.modal.isOpen = true
      },
      storeRecord() {
        this.$refs.modalRef
          .validateFields()
          .then(() => {
            this.$inertia.post(route("admin.fund.budgets.store",this.fund.id), this.modal.data, {
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
          route("admin.fund.budgets.update", {fund:this.fund.id,budget:this.modal.data.id}),
          this.modal.data,
          {
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
      onChangeStatus(record, status){
        console.log(status);
        this.$inertia.post(route('admin.budget.changeStatus',record.id),
          {status:status},
          {
            onSuccess: (page) => {
            },
            onError: (error) => {
              console.log(error);
              if(error.message){
                message.error(error.message)
              }
            },
          });
      },
    },
  };
  </script>
  