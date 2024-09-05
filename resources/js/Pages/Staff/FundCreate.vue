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
          :model="fund"
          name="fund"
          :label-col="labelCol"

          autocomplete="off"
          :rules="rules"
          :validate-messages="validateMessages"
          @finish="onFinish"
          enctype="multipart/form-data"

        >
          <a-form-item :label="$t('project_entity')" name="entity">
            <a-input v-model:value="fund.entity" />
          </a-form-item>
          <a-form-item :label="$t('project_declarant')" name="declarant">
            <a-input v-model:value="fund.declarant" />
          </a-form-item>
          <a-form-item :label="$t('birm')" name="birm">
            <a-input v-model:value="fund.birm" />
          </a-form-item>
          <a-form-item :label="$t('project_code')" name="project_code">
            <a-input v-model:value="fund.project_code" />
          </a-form-item>
          <a-form-item :label="$t('project_title')" name="title">
            <a-input v-model:value="fund.title" />
          </a-form-item>
          <a-form-item :label="$t('project_responsible')" name="responsible">
            <a-input v-model:value="fund.responsible" />
          </a-form-item>
          <a-form-item :label="$t('project_amount')" name="amount">
            <a-input v-model:value="fund.amount" />
          </a-form-item>
          <a-form-item :label="$t('project_type')" name="type">
            <a-input v-model:value="fund.type" />
          </a-form-item>
          <a-form-item :label="$t('project_duration')" name="duration">
            <a-input v-model:value="fund.duration" />
          </a-form-item>
          <a-row  class="bg-blue-100 p-5">
            <a-col :span="24">
              <a-form-item :label="$t('project_grant')" name="grant">
              <a-input v-model:value="fund.grant" />
            </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item :label="$t('project_phase1')" name="grants0">
                <a-input v-model:value="fund.grants[0]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase2')" name="grants1">
                <a-input v-model:value="fund.grants[1]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase3')" name="grants2">
                <a-input v-model:value="fund.grants[2]" />
              </a-form-item>
           </a-col>
           <a-col :span="12">
            <a-form-item :label="$t('project_phase4')" name="grants3">
                <a-input v-model:value="fund.grants[3]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase5')" name="grants5">
                <a-input v-model:value="fund.grants[4]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase6')" name="grants5">
                <a-input v-model:value="fund.grants[5]" />
              </a-form-item>
           </a-col>
          </a-row>
          <a-row  class="bg-red-100 p-5">
            <a-col :span="24">
              <a-form-item :label="$t('project_replayment')" name="repayment">
                <a-input v-model:value="fund.repayment" />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item :label="$t('project_phase1')" name="repayments0">
                <a-input v-model:value="fund.repayments[0]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase2')" name="repayments1">
                <a-input v-model:value="fund.repayments[1]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase3')" name="repayments2">
                <a-input v-model:value="fund.repayments[2]" />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item :label="$t('project_phase4')" name="repayments3">
                <a-input v-model:value="fund.repayments[3]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase5')" name="repayments4">
                <a-input v-model:value="fund.repayments[4]" />
              </a-form-item>
              <a-form-item :label="$t('project_phase6')" name="repayments5">
                <a-input v-model:value="fund.repayments[5]" />
              </a-form-item>
           </a-col>
          </a-row>
          <div class="flex flex-row item-center justify-center gap-5 pt-5">
            <a-button :href="route('staff.funds.index')">{{ $t('back') }}</a-button>
            <a-button type="primary" html-type="submit">{{ $t('submit') }}</a-button>
            <a-button :href="route('staff.fund.items.index',fund.id)" v-if="fund.id">{{ $t('funding_items') }}</a-button>
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
    props: ["categories",'fund'],
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
  