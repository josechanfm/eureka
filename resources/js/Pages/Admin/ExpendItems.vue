<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('expend_items') }}
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <ExpendHeader :expend="expend"/>
        </div>
        <a-divider/>
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="expend.items" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="['account_code'].includes(column.dataIndex)">
                <template v-if="editableData.id==record.id">
                  <a-input v-model:value="editableData.account_code"/>
                </template>
                <template v-else>
                  {{ text }}
                </template>
              </template>
              <template v-else-if="column.dataIndex == 'operation'">
                <template v-if="editableData.id==record.id">
                  <a-button @click="onSaveRecord(record)">Save</a-button>
                </template>
                <template v-else>
                  <a-button @click="onEditRecord(record)">Edit</a-button>
                </template>
                <!-- <a-button :href="route('admin.fund.expends.edit',{fund:record.fund_id,expend:record.id})" >Edit</a-button> -->
              </template>
            </template>
          </a-table>
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
    props: ["expend","availableSplits"],
    data() {
      return {
        splits:[],
        editableData:{
          id:null,
          account_code:null,
        },
        columns: [
          {
            title: "Description",
            i18n: "description",
            dataIndex: "description",
          },{
            title: "Account Code",
            i18n: "account_code",
            dataIndex: "account_code",
          },{
            title: "Reference",
            i18n: "reference",
            dataIndex: "reference_code",
          },{
            title: "Amount",
            i18n: "amount",
            dataIndex: "amount",
          },{
            title: "Operation",
            i18n: "operation",
            dataIndex: "operation",
          },
        ],
     
        labelCol: {
          style: {
            width: "150px",
          },
        },
      };
    },
    created() {
      this.splits=this.availableSplits.map(a=> ({
          value:a.id,
          label:a.account_code+' '+a.description+' ('+a.available+')'
        })
      )
    },
    methods: {
      onEditRecord(record){
        this.editableData={...record}
      },
      onSaveRecord(record){
        this.$inertia.patch(
          route("admin.expend.items.update", {expend:this.expend.id, item:this.editableData.id}),this.editableData,{
            onSuccess: (page) => {
              console.log(page);
            },
            onError: (error) => {
              console.log(error);
            },
          }
        );
        this.editableData={id:null, account_code:null}
      },
    },
  };
  </script>
  