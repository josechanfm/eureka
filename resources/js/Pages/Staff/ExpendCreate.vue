<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>

      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
          <a-form
          :model="expend"
          name="fund"
          :label-col="labelCol"
          autocomplete="off"
          :rules="rules"
          :validate-messages="validateMessages"
          @finish="onFinish"
          enctype="multipart/form-data"

        >
          <a-form-item label="申請實體" name="entity">
            <a-input v-model:value="fund.entity" />
          </a-form-item>
          <div class="flex flex-row item-center justify-center">
            <a-button type="primary" html-type="submit">Submit</a-button>
          </div>
        </a-form>
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
    props: ["fund",'expends'],
    data() {
      return {
        // fund:{
        //   grants:{},
        //   repayments:{}
        // },
        rules: {
          entity: { required: true },
          declarant: { required: true},
          birm: { required: true },
          project_code: { required: true },
          title:{ required: true }
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
        // wrapperCol{

        // }
      };
    },
    created() {
      
    },
    computed(){
    },
    methods: {
      onFinish() {
        if(this.fund.id==null){
          this.recordStore()
        }else{
          this.recordUpdate()
        }
      },
      recordStore(){
        this.$inertia.post(route("staff.funds.store"), this.fund, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (error) => {
            console.log(error);
          },
        });

      },
      recordUpdate(){
        this.$inertia.patch(route("staff.funds.update", this.fund.id), this.fund, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (error) => {
            console.log(error);
          },
        });

      }
    },
  };
  </script>
  