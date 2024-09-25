<template>
    <StaffLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('my_project') }}
        </h2>
      </template>

      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
          <a-typography-title class="text-center">{{ category.title_zh }}</a-typography-title>
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
            <a-radio-group v-model:value="fund.type" button-style="solid">
              <a-radio-button value="P">{{ $t('compensated') }}</a-radio-button>
              <a-radio-button value="U">{{ $t('non_compensated') }}</a-radio-button>
            </a-radio-group>
          </a-form-item>
          <a-form-item :label="$t('project_duration')" name="duration">
            <a-input-number v-model:value="fund.duration" />{{ $t('month') }}
          </a-form-item>
          <a-row  class="bg-blue-100 p-5">
            <a-col :span="24">
              <a-form-item :label="$t('project_grant')" name="grant">
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
              <a-form-item :label="$t('project_phase1')" name="grants0">
                <a-input v-model:value="fund.grants[0]"  v-if="fund.grant>=1"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase2')" name="grants1">
                <a-input v-model:value="fund.grants[1]"  v-if="fund.grant>=2"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase3')" name="grants2">
                <a-input v-model:value="fund.grants[2]"  v-if="fund.grant>=3"/>
              </a-form-item>
           </a-col>
           <a-col :span="12">
            <a-form-item :label="$t('project_phase4')" name="grants3">
                <a-input v-model:value="fund.grants[3]"  v-if="fund.grant>=4"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase5')" name="grants4">
                <a-input v-model:value="fund.grants[4]" v-if="fund.grant>=5"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase6')" name="grants5" >
                <a-input v-model:value="fund.grants[5]" v-if="fund.grant>=6"/>
              </a-form-item>
           </a-col>
          </a-row>
          <a-row  class="bg-red-100 p-5" v-if="fund.type=='P'">
            <a-col :span="24">
              <a-form-item :label="$t('project_repayment')" name="repayment">
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
              <a-form-item :label="$t('project_phase1')" name="repayments0">
                <a-input v-model:value="fund.repayments[0]" v-if="fund.repayment>=1"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase2')" name="repayments1">
                <a-input v-model:value="fund.repayments[1]" v-if="fund.repayment>=2"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase3')" name="repayments2">
                <a-input v-model:value="fund.repayments[2]" v-if="fund.repayment>=3"/>
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item :label="$t('project_phase4')" name="repayments3">
                <a-input v-model:value="fund.repayments[3]" v-if="fund.repayment>=4"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase5')" name="repayments4">
                <a-input v-model:value="fund.repayments[4]" v-if="fund.repayment>=5"/>
              </a-form-item>
              <a-form-item :label="$t('project_phase6')" name="repayments5">
                <a-input v-model:value="fund.repayments[5]" v-if="fund.repayment>=6"/>
              </a-form-item>
           </a-col>
          </a-row>
          <div class="flex flex-row item-center justify-center gap-5 pt-5">
            <a-button :href="route('staff.funds.index')">{{ $t('back') }}</a-button>
            <a-button type="primary" html-type="submit" v-if="fund.is_submitted==false">{{ $t('save') }}</a-button>
            <a-button :href="route('staff.fund.items.index',fund.id)" v-if="fund.id">{{ $t('funding_items') }}</a-button>
          </div>
        </a-form>
        </div>
      </div>
    </StaffLayout>
  </template>
  
  <script>
  import StaffLayout from "@/Layouts/StaffLayout.vue";
  import { defineComponent, reactive } from "vue";

  export default {
    components: {
      StaffLayout,
    },
    props: ["category",'fund'],
    data() {
      return {
        // fund:{
        //   grants:{},
        //   repayments:{}
        // },
        rules: {
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
    mounted(){
      console.log(this.$t('grant_phases', { phase: 1 }));

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
  