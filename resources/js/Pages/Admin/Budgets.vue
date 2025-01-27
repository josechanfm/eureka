<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('budget_proposal') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
          <FundHeader :fund="fund" />
        <a-divider/>
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="budgets" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button @click="viewRecord(record)" v-if="record.is_locked || record.is_closed">{{ $t('view') }}</a-button>
                <a-button @click="editRecord(record)" v-else>{{ $t('edit') }}</a-button>
                <a-button :href="route('admin.budget.items.index',record.id)" type="budget">{{ $t('budget_item') }}</a-button>
                <a-button :href="route('admin.budget.export',record.id)">{{ $t('export') }}</a-button>
                <a-button :href="route('admin.budget.expends.index',record.id)" type="expend">{{ $t('expend') }}</a-button>
              </template>
              <template v-else-if="column.dataIndex == 'status'">
                <!-- Status label -->
                <template v-if="record.status=='S2'">
                  {{ $t('revise') }}
                </template>
                <template v-else-if="record.status=='S3'">
                  {{ $t('submitted') }}
                </template>
                <template v-else-if="record.status=='S4'">
                  {{ $t('accepted') }}
                </template>
                <template v-else-if="record.status=='S5'">
                  {{ $t('proposed') }}
                </template>
                <template v-else-if="record.status=='S6'">
                  {{ $t('archived') }}
                </template>
                <template v-else>
                  {{ $t('preparing') }}
                </template>
                <!-- //Status label -->
                <!-- Status Action Button -->
                <span v-role="['admin','dei']">
                  <template v-if="record.status=='S2'">
                      <a-button :disabled="true">{{ $t('return') }}</a-button>
                      <a-button :disabled="true">{{ $t('accept') }}</a-button>
                  </template>
                  <template v-else-if="record.status=='S3'">
                      <a-button @click="onChangeStatus(record,'RETURN')">{{ $t('return') }}</a-button>
                      <a-button @click="onChangeStatus(record,'ACCEPT')">{{ $t('accept') }}</a-button><!-- to archive-->
                  </template>
                  <template v-else-if="record.status=='S4'">
                      <a-button @click="onChangeStatus(record,'REVIEW')">{{ $t('review') }}</a-button>
                      <a-button @click="onChangeStatus(record,'PROPOSE')">{{ $t('propose') }}</a-button><!-- to archive-->
                  </template>
                  <template v-else-if="record.status=='S5'">
                      <a-button @click="onChangeStatus(record,'REWORK')">{{ $t('rework') }}</a-button>
                      <a-button @click="onChangeStatus(record,'ARCHIVE')">{{ $t('archive') }}</a-button><!-- to archive-->
                  </template>
                </span>

                <!-- //Status Action Button -->
              </template>
              <template v-else-if="column.dataIndex == 'reference'">
                {{ '000'+record.id }}
              </template>
              <template v-else-if="column.dataIndex == 'year'">
                {{ record.category.year }}
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
          <a-form-item :label="$t('expend_proposal')" name="title">
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
    props: ["fund","budgets"],
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
            title: this.$t('year'),
            dataIndex: "year",
          },{
            title: this.$t('expend_title'),
            dataIndex: "title",
          },{
            title: this.$t('proposal_number'),
            dataIndex: "proposal_number",
          },{
            title: this.$t('proposed_at'),
            dataIndex: "proposed_at",
          },{
            title: this.$t('proposed_by'),
            dataIndex: "proposed_by",
          },{
            title: this.$t('reference_code'),
            dataIndex: "reference",
          },{
            title: this.$t('status'),
            dataIndex: "status",
            minWidth: "260px",
            customCell:(text,record,index)=>({
              style:{minWidth: "260px"}
            })
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
  