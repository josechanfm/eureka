<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('welcome') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto text-right">
          <a-button type="primary" @click="createRecord()">Create</a-button>
          <a-table :dataSource="expends" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button :href="route('staff.expend.items.index',record.id)" >Items</a-button>
                <a-button @click="editRecord(record)" :disabled="record.is_locked || record.is_closed">Edit</a-button>
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
          <a-form-item label="Title" name="title">
            <a-input v-model:value="modal.data.title" />
          </a-form-item>
          <a-form-item label="Proposal No." name="proposal_number">
            <a-input v-model:value="modal.data.proposal_number" />
          </a-form-item>
          <a-form-item label="Proposed at" name="proposed_at">
            <a-date-picker v-model:value="modal.data.proposed_at" :format="dateFormat" :valueFormat="dateFormat"/>
          </a-form-item>
          <a-form-item label="Proposed by" name="proposed_by">
            <a-input v-model:value="modal.data.proposed_by"/>
          </a-form-item>
          <a-form-item label="Approved at" name="approved_at">
            <a-date-picker v-model:value="modal.data.approved_at" :format="dateFormat" :valueFormat="dateFormat"/>
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
  import { defineComponent, reactive } from "vue";
  
  export default {
    components: {
      AdminLayout,
    },
    props: ["fund","expends"],
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
        columns: [
          {
            title: "Title",
            i18n: "title",
            dataIndex: "title",
          },{
            title: "Propsal Number",
            i18n: "proposal_number",
            dataIndex: "proposal_number",
          },{
            title: "Propsal At",
            i18n: "proposed_at",
            dataIndex: "proposed_at",
          },{
            title: "Propssed By",
            i18n: "proposed_by",
            dataIndex: "proposed_by",
          },{
            title: "Operation",
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
          },
        ],
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
    methods: {
      createRecord(){
        this.modal.data = {}
        this.modal.data.fund_id=this.fund.id
        this.modal.mode = "CREATE"
        this.modal.title = "Create"
        this.modal.isOpen = true
      },
      editRecord(record){
        this.modal.data = {...record}
        this.modal.mode = "EDIT"
        this.modal.title = "Edit"
        this.modal.isOpen = true
      },
      storeRecord() {
        this.$refs.modalRef
          .validateFields()
          .then(() => {
            this.$inertia.post(route("staff.fund.expends.store",this.fund.id), this.modal.data, {
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
          route("staff.fund.expends.update", {fund:this.fund.id,expend:this.modal.data.id}),
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
  