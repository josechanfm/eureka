<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Config
        </h2>
      </template>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-button type="primary" class="float-right m-5" @click="create()">Create</a-button>
          <div class="p-5">{{ category.title_zh }}</div>
          <a-table :dataSource="category.items" :columns="columns">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <a-button v-if="editableData[index]" @click="save(index)">Save</a-button>
                <a-button v-else @click="edit(index)">Edit</a-button>
                <a-button :href="route('admin.category.item.accounts.index',record.id)">Accounts</a-button>
                <!-- <a-button @click="editRecord(record)">Edit</a-button> -->
              </template>
              <template v-else>
                <a-input v-if="editableData[index]" v-model:value="editableData[index][column.dataIndex]"/>
              </template>
            </template>
          </a-table>
        </div>
      </div>

    </AdminLayout>
  </template>
  
  <script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import { defineComponent, reactive } from "vue";
  
  export default {
    components: {
      AdminLayout,
    },
    props: ["category"],
    data() {
      return {
        editableData:{},
        columns: [
          {
            title: "Name",
            i18n: "name_zh",
            dataIndex: "name_zh",
          },
          {
            title: "Operation",
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
          },
        ],
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
      };
    },
    created() {
      
    },
    methods: {
      edit(index){
        console.log(index);
        this.editableData[index]={...this.category.items[index]}
      },
      save(index){
        console.log(this.editableData[index]);
        if(this.editableData[index].id){
            this.updateRecord(this.category, this.editableData[index])
        }else{
            this.storeRecord(this.category, this.editableData[index])
        }
        this.editableData[index]=null;
      },
      create(){
        this.editableData[this.category.items.length]={}
        this.category.items.push({})
      },
      storeRecord(category, item) {
            this.$inertia.post(route("admin.category.items.store", category.id), item, {
              onSuccess: (page) => {
              },
              onError: (err) => {
                console.log(err);
              },
            });
      },
      updateRecord(category, item) {
        this.$inertia.patch(
          route("admin.category.items.update", {category:category.id, item:item.id}),
          item,
          {
            onSuccess: (page) => {
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
  