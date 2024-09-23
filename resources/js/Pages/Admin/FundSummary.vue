<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t('expend_summary') }}
      </h2>
    </template>

    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <FundHeader :fund="fund" />
      </div>
      <div class="pt-5 text-center">
        <a-button :href="route('admin.funds.index')">{{ $t('back') }}</a-button>
      </div>
      <a-divider />
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <div class="p-5">
          <table width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ $t('funding_description') }}</th>
                <th style="text-align:center">{{ $t('amount') }}</th>
                <th style="text-align:center">{{ $t('expend_reserved') }}</th>
                <th style="text-align:center">{{ $t('available') }}</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(catItem, catIdx) in categoryItems">
                <tr>
                  <th colspan="5">{{ catIdx + 1 }} {{ catItem.name_zh }}</th>
                </tr>
                <template v-for="(item, fundItemIdx) in fund.items.filter(i => i.category_item_id == catItem.id)">
                  <template v-if="item.splits.length == 1">
                    <tr>
                      <td>{{ catIdx + 1 }}.{{ fundItemIdx + 1 }}</td>
                      <td>{{ item.splits[0].description }} {{ item.splits[0].account_code }}</td>
                      <!-- <td style="text-align:right">
                                    <span>{{ sumItemAccounts(item.splits) }}</span>
                                  </td> -->
                      <td style="text-align:right">{{ item.amount.toLocaleString() }}</td>
                      <td style="text-align:right">{{ item.budgeted }}</td>
                      <td style="text-align:right">{{ (item.amount - item.budgeted).toLocaleString() }}</td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr>
                      <td class="number">{{ catIdx + 1 }}.{{ fundItemIdx + 1 }}</td>
                      <td>
                        <table width="100%">
                          <template v-for="(split, accIdx) in item.splits">
                            <tr>
                              <td>{{ split.description }} {{ split.account_code }}</td>
                              <td style="text-align:right">
                                <span v-if="split.amount">{{ split.amount }}</span><span v-else>---</span>
                              </td>
                            </tr>
                          </template>
                        </table>
                      </td>
                      <!-- <td style="text-align:right">{{ sumItemAccounts(item.splits) }}b</td> -->
                      <td style="text-align:right">{{ item.amount.toLocaleString() }}</td>
                      <td style="text-align:right">{{ item.budgeted }}</td>
                      <td style="text-align:right">{{ (item.amount - item.budgeted).toLocaleString() }}</td>
                    </tr>
                  </template>
                </template>
                <tr>
                  <td colspan="2" style="text-align:right">{{ $t('sub_total') }}:</td>
                  <td style="text-align:right">{{ subTotal(fund.items, catItem).toLocaleString() }}</td>
                  <td style="text-align:right">{{ subBudgeted(fund.items, catItem).toLocaleString() }}</td>
                  <td style="text-align:right">{{ (subTotal(fund.items, catItem) - subBudgeted(fund.items,
                    catItem)).toLocaleString() }}</td>
                </tr>
              </template>
              <tr>
                <td colspan="2" style="text-align: right;">{{ $t('grand_total') }}:</td>
                <td style="text-align:right">{{ grandTotal(fund.items).toLocaleString() }}</td>
                <td style="text-align:right">{{ grandBudegeted(fund.items).toLocaleString() }}</td>
                <td style="text-align:right">{{ (grandTotal(fund.items) - grandBudegeted(fund.items)).toLocaleString() }}
                </td>
              </tr>
            </tbody>
          </table>
          <div class="p-5 text-center">
            <a-button :href="route('admin.funds.index')">{{ $t('back') }}</a-button>
          </div>
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
  props: ["categoryItems", "fund"],
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
    sumItemAccounts(splits) {
      console.log('sumItemAccounts');
      console.log(splits);
      return splits.reduce((a, c) => {
        if (c.amount) {
          return a + parseInt(c.amount)
        } else {
          return a;
        }
      }, 0)
    },
    subTotal(fundItems, catItem) {
      return fundItems.filter(i => i.category_item_id == catItem.id).reduce((a, c) => a + parseInt(c.amount), 0)
    },
    grandTotal(fundItems) {
      return fundItems.reduce((a, c) => a + parseInt(c.amount), 0)
    },
    subBudgeted(fundItems, catItem) {
      return fundItems.filter(i => i.category_item_id == catItem.id).reduce((a, c) => a + parseInt(c.budgeted), 0)
    },
    grandBudegeted(fundItems) {
      return fundItems.reduce((a, c) => a + parseInt(c.budgeted), 0)
    },

  },
};
</script>

<style scoped>
table td,
tr {
  border: 1px solid lightgray;
  padding: 5px;
}

th {
  text-align: left;
}
</style>
