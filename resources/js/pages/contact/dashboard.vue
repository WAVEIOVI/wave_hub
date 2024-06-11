<script setup>
import WelcomeContactApp from '@/views/contact/dashboard/WelcomeContactApp.vue'
import ContactsStatistics from '@/views/contact/dashboard/ContactsStatistics.vue'
import ClientListTable from '@/views/contact/client/list/ClientListTable.vue'
import SupplierListTable from '@/views/contact/supplier/list/SupplierListTable.vue'

//SECTION Items

// 👉 Headers
const clientHeaders = [
  {
    title: 'Client',
    key: 'client_name',
  },
  {
    title: 'Type',
    key: 'client_type',
  },
  {
    title: 'Activity',
    key: 'client_activity',
  },
  {
    title: 'Status',
    key: 'client_status',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const supplierHeaders = [
  {
    title: 'Supplier',
    key: 'supplier_name',
  },
  {
    title: 'Type',
    key: 'supplier_type',
  },
  {
    title: 'Activity',
    key: 'supplier_activity',
  },
  {
    title: 'Status',
    key: 'supplier_status',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

// 👉 search filters
const types = [
  {
    title: 'Individual Client',
    value: 'individual client',
  },
  {
    title: 'Small Business Client ',
    value: 'small business client ',
  },
  {
    title: 'Enterprise Client',
    value: 'enterprise client',
  },
  {
    title: 'Government Client',
    value: 'government client',
  },
  {
    title: 'Non-Profit Client',
    value: 'non-profit client',
  },
  {
    title: 'Key Account',
    value: 'key account',
  },
]

const activities = [
  {
    title: 'Agriculture',
    value: 'agriculture',
  },
  {
    title: 'Automotive',
    value: 'automotive',
  },
  {
    title: 'Banking and Finance',
    value: 'banking and finance',
  },
  {
    title: 'Construction',
    value: 'construction',
  },
  {
    title: 'Education',
    value: 'education',
  },
  {
    title: 'Energy',
    value: 'energy',
  },
  {
    title: 'Healthcare',
    value: 'healthcare',
  },
  {
    title: 'Hospitality and Tourism',
    value: 'hospitality and tourism',
  },
  {
    title: 'Information Technology (IT)',
    value: 'information technology',
  },
  {
    title: 'Manufacturing',
    value: 'manufacturing',
  },
  {
    title: 'Real Estate',
    value: 'real estate',
  },
  {
    title: 'Retail',
    value: 'retail',
  },
  {
    title: 'Telecommunications',
    value: 'telecommunications',
  },
  {
    title: 'Transportation and Logistics',
    value: 'transportation and logistics',
  },
  {
    title: 'Utilities',
    value: 'utilities',
  },
  {
    title: 'Wholesale/Retail Trade',
    value: 'wholesale retail trade',
  },
  {
    title: 'Media and Entertainment',
    value: 'media and entertainment',
  },
  {
    title: 'Legal and Professional Services',
    value: 'legal and professional services',
  },
]

const status = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'Active',
    value: 'active',
  },
  {
    title: 'Inactive',
    value: 'inactive',
  },
]

//!SECTION Items
</script>

<template>
  <VRow class="match-height">
    <!-- 👉 Welcome Contact App -->
    <VCol
      cols="12"
      md="5"
      lg="4"
    >
      <WelcomeContactApp />
    </VCol>

    <!-- 👉 Contacts Statistics -->
    <VCol
      cols="12"
      md="7"
      lg="8"
    >
      <ContactsStatistics class="h-100" />
    </VCol>
    <VCol cols="12">
      <EcommerceRevenueReport />
    </VCol>
    <VCol cols="12">
      <ClientListTable
        :headers="clientHeaders" 
        :types="types" 
        :activities="activities" 
        :status="status"
      />
    </VCol>
    <VCol cols="12">
      <SupplierListTable
        :headers="supplierHeaders" 
        :types="types" 
        :activities="activities" 
        :status="status"
      />
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/libs/apex-chart.scss";
</style>
