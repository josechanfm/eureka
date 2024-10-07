<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Create Funding
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
          <a-form-item label="檔案編號" name="project_code">
            <a-input v-model:value="fund.project_code" />
          </a-form-item>
          <a-form-item label="資助項目名稱" name="title">
            <a-input v-model:value="fund.title" />
          </a-form-item>
          <a-form-item label="項目負責人" name="responsible">
            <a-input v-model:value="fund.responsible" />
          </a-form-item>
          <a-form-item label="資助金額" name="amount">
            <a-input v-model:value="fund.amount" />
          </a-form-item>
          <a-form-item label="資助形式" name="type">
            <a-radio-group v-model:value="fund.type" button-style="solid">
              <a-radio-button value="P">{{ $t('compensated') }}</a-radio-button>
              <a-radio-button value="U">{{ $t('non_compensated') }}</a-radio-button>
            </a-radio-group>
          </a-form-item>
          <a-form-item label="研究期限" name="duration">
            <a-input-number v-model:value="fund.duration" />{{ $t('month') }}
          </a-form-item>
          <a-row  class="bg-blue-100 p-5">
            <a-col :span="24">
              <a-form-item label="資助發放形式:" name="grant">
                <a-select
                  ref="select"
                  v-model:value="fund.grant"
                  style="width: 200px"
                >
                  <template v-for="i in 6">
                    <a-select-option :value="i" >{{ $t('grant_phases', {phase: i}) }}</a-select-option>
                  </template>
                </a-select>
            </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="第一期" name="grants0" v-if="fund.grant>=1">
                <a-input v-model:value="fund.grants[0]" />
              </a-form-item>
              <a-form-item label="第二期" name="grants1" v-if="fund.grant>=2">
                <a-input v-model:value="fund.grants[1]" />
              </a-form-item>
              <a-form-item label="第三期" name="grants2" v-if="fund.grant>=3">
                <a-input v-model:value="fund.grants[2]" />
              </a-form-item>
           </a-col>
           <a-col :span="12">
            <a-form-item label="第四期" name="grants3" v-if="fund.grant>=4">
                <a-input v-model:value="fund.grants[3]" />
              </a-form-item>
              <a-form-item label="第五期" name="grants5" v-if="fund.grant>=5">
                <a-input v-model:value="fund.grants[4]" />
              </a-form-item>
              <a-form-item label="第六期" name="grants5" v-if="fund.grant>=6">
                <a-input v-model:value="fund.grants[5]" />
              </a-form-item>
           </a-col>
          </a-row>
          <a-row  class="bg-red-100 p-5">
            <a-col :span="24">
              <a-form-item label="資助償還形式:" name="repayment">
                <a-select
                  ref="select"
                  v-model:value="fund.repayment"
                  style="width: 200px"
                >
                <template v-for="i in 6">
                    <a-select-option :value="i" >{{ $t('repayment_phases', {phase: i}) }}</a-select-option>
                  </template>
                </a-select>
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="第一期" name="repayments0">
                <a-input v-model:value="fund.repayments[0]" v-if="fund.repayment>=1"/>
              </a-form-item>
              <a-form-item label="第二期" name="repayments1" v-if="fund.repayment>=2">
                <a-input v-model:value="fund.repayments[1]" />
              </a-form-item>
              <a-form-item label="第三期" name="repayments2" v-if="fund.repayment>=3">
                <a-input v-model:value="fund.repayments[2]" />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="第四期" name="repayments3" v-if="fund.repayment>=4">
                <a-input v-model:value="fund.repayments[3]" />
              </a-form-item>
              <a-form-item label="第五期" name="repayments4" v-if="fund.repayment>=5">
                <a-input v-model:value="fund.repayments[4]" />
              </a-form-item>
              <a-form-item label="第六期" name="repayments5" v-if="fund.repayment>=6">
                <a-input v-model:value="fund.repayments[5]" />
              </a-form-item>
           </a-col>
          </a-row>
          <div class="flex flex-row item-center justify-center gap-5 pt-5">
            <a-button :href="route('admin.funds.index')">{{ $t('back') }}</a-button>
            <a-button :href="route('admin.fund.items.index',fund.id)" type="fund">{{ $t('funding_items') }}</a-button>
            <!-- <a-button type="primary" html-type="submit">Submit</a-button> -->
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
        this.$inertia.post(route("admin.funds.store"), this.fund, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (error) => {
            console.log(error);
          },
        });

      },
      recordUpdate(){
        this.$inertia.patch(route("admin.funds.update", this.fund.id), this.fund, {
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
  