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
        <div class="bg-white relative shadow rounded-lg overflow-x-auto text-right">
          <div class="p-5">
            <a-button type="primary" @click="createRecord()">{{ $t('create') }}</a-button>
          </div>
          <a-table :dataSource="budgets" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button @click="deleteRecord(record)" type="primary" danger :disabled="!record.items.length==0">{{ $t('delete') }}</a-button>
                <a-button @click="editRecord(record)" :disabled="record.is_locked || record.is_closed">{{ $t('edit') }}</a-button>
                <a-button :href="route('staff.budget.items.index',record.id)" type="budget">{{ $t('budget_item') }}</a-button>
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
          <a-form-item :label="$t('year')" name="year">
            <a-select v-model:value="modal.data.year" :options="years" :disabled="modal.data.status > 'S2'"/>
          </a-form-item>
          <a-form-item :label="$t('budget_title')" name="title">
            <a-input v-model:value="modal.data.title" :disabled="modal.data.status > 'S2'"/>
          </a-form-item>
          <a-form-item :label="$t('proposal_number')" name="proposal_number">
            {{ modal.data.proposal_number }}
          </a-form-item>
          <a-form-item :label="$t('proposed_at')" name="proposed_at">
            {{ modal.data.proposed_at }}
          </a-form-item>
          <a-form-item :label="$t('proposed_by')" name="proposed_by">
            {{  modal.data.proposed_by }}
          </a-form-item>
          <a-form-item :label="$t('approved_at')" name="approved_at">
            {{  modal.data.approved_at }}
          </a-form-item>
          <a-form-item :label="$t('remark')" name="remark">
            <div v-html="modal.data.remark"/>
          </a-form-item>
        </a-form>
        <template #footer>
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
        </template>
      </a-modal>
      <!-- Modal End-->
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
    props: ["fund","budgets"],
    data() {
      return {
        years:[],
        dateFormat:'YYYY-MM-DD',
        modal: {
          isOpen: false,
          data: {},
          title: "Modal",
          mode: "",
        },
        rules: {
          year:{ required: true },
          title:{ required: true },
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
      let yearStart=new Date().getFullYear();
      for(let i=0;i<5;i++){
        this.years.push({value:yearStart+i})
      }
    },
    computed:{
      columns(){
        return[
        {
            title: this.$t('year'),
            i18n: "year",
            dataIndex: "year",
          },{
            title:  this.$t('budget_proposal'),
            i18n: "title",
            dataIndex: "title",
          },{
            title: this.$t('proposal_number'),
            i18n: "proposal_number",
            dataIndex: "proposal_number",
          },{
            title: this.$t('proposed_at'),
            i18n: "proposed_at",
            dataIndex: "proposed_at",
          },{
            title: this.$t('operation'),
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
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
      deleteRecord(record){
        console.log('delete record')
        console.log(record)
        this.$inertia.delete(route('staff.fund.budgets.destroy',{fund:this.fund.id, budget:record.id}),{
          onSuccess: (page) => {
            console.log(page)
          },
          onError: (err) => {
            console.log(err);
          },
        })
      },
      storeRecord() {
        this.$refs.modalRef
          .validateFields()
          .then(() => {
            this.$inertia.post(route("staff.fund.budgets.store",this.fund.id), this.modal.data, {
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
          route("staff.fund.budgets.update", {fund:this.fund.id,budget:this.modal.data.id}),
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
    },
  };
  </script>
  