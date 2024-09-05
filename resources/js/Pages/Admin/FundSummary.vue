<template>
    <AdminLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t('welcome') }}
        </h2>
      </template>

      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <FundHeader :fund="fund"/>
        </div>
        <a-divider/>
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <div class="p-5">
             <table width="100%">
              <tr>
                <th>#</th>
                <th>預算</th>
                <th style="text-align:center">支出</th>
                <th style="text-align:center">標題</th>
              </tr>
                <template v-for="(categoryItem, catIdx) in categoryItems">
                    <template v-for="item in fund.items.filter(i=>i.category_item_id==categoryItem.id)">
                            <tr>
                                <th colspan="5">{{catIdx+1}} {{ categoryItem.name_zh }}</th>    
                            </tr>
                            <template v-if="item.accounts.length==1">
                                <tr>
                                    <td>{{ item.category_item_id }}</td>
                                    <td>{{ item.accounts[0].description }} {{ item.accounts[0].account_code }}</td>
                                    <td style="text-align:right">{{ item.accounts[0].amount.toLocaleString() }}</td>
                                    <td style="text-align:right">{{ item.accounts[0].total.toLocaleString() }}</td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td class="number">{{ catIdx+1 }}</td>
                                    <td>
                                    <table width="100%">
                                        <template v-for="(account, accIdx) in item.accounts">
                                            <tr>
                                            <td>{{ account.description }} {{ account.account_code }}</td>
                                            <td style="text-align:right">{{ account.amount.toLocaleString() }}</td>
                                            <td style="text-align:right">{{ item.amount.toLocaleString() }}</td>
                                            </tr>
                                        </template>
                                    </table>
                                    </td>
                                <td style="text-align:right">{{ item.amount.toLocaleString() }}</td>
                                <td style="text-align:right">{{ sumItemAccounts(item.accounts) }}</td>
                                </tr>
                            </template>
                            <tr>
                              <td colspan="3" style="text-align:right">Sub total:</td>
                              <td style="text-align:right">{{ subTotal(fund.items, categoryItem) }}</td>
                            </tr>
                    </template>
                </template>
                <tr>
                  <td colspan="3" style="text-align: right;">Grand Total:</td>
                  <td style="text-align:right">{{ grandTotal(fund.items) }}</td>
                </tr>
            </table>
          </div>
        </div>
      </div>
    </AdminLayout>
  </template>
  
  <script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import FundHeader from "@/Pages/Staff/FundHeader.vue";
  
  export default {
    components: {
      AdminLayout,
      FundHeader
    },
    props: ["categoryItems","fund"],
    data() {
      return {
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
          },
          {
            title: "Operation",
            i18n: "operation",
            dataIndex: "operation",
            key: "operation",
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
      
    },
    methods: {
        sumItemAccounts(accounts){
            const total=accounts.reduce((a,c)=>a+parseInt(c.total),0).toLocaleString()
            return total
        },
        subTotal(fundItems, categoryItem){
          return fundItems.filter(i=>i.category_item_id==categoryItem.id).reduce((a,c)=>a+parseInt(c.amount),0).toLocaleString()
        },
        grandTotal(fundItems){
          return fundItems.reduce((a,c)=>a+parseInt(c.amount),0).toLocaleString()
        }

    },
  };
  </script>

  <style scoped>
  table td, tr {
    border: 1px solid lightgray;
    padding: 5px;
  }
  th{
    text-align: left;
  }
  </style>
  